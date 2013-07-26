<?php

/**
 * Calls the class on the post edit screen
 */
function call_RelatedPosts() 
{
    return new RelatedPosts();
}
if ( is_admin() )
    add_action( 'load-post.php', 'call_RelatedPosts' );

/** 
 * The Class
 */
class RelatedPosts {
	const LANG = 'some_textdomain';

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container
	 */
	public function add_meta_box() {
		add_meta_box(
			 'related_posts_meta_box'
			,__( 'Related Posts', self::LANG )
			,array( &$this, 'render_meta_box_content' )
			,'post'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
		// First we need to check if the current user is authorised to do this action. 
		if ( 'page' == $_REQUEST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}

		// Secondly we need to check if the user intended to change this value.
		if ( ! isset( $_POST['mc_related_posts_nonce'] ) || ! wp_verify_nonce( $_POST['mc_related_posts_nonce'], 'save_related_posts' ) )
			return;

		// Thirdly we can save the value to the database

		//if saving in a custom table, get post_ID
		$post_ID = $_POST['post_ID'];
		//sanitize user input
		$mydata = sanitize_text_field( $_POST['mc_related_posts'] );

		// Do something with $mydata 
		// either using 
		if ( !add_post_meta( $post_ID, '_mc_related_posts', $mydata, true ) ) {
			update_post_meta( $post_ID, '_mc_related_posts', $mydata );
		}
		// or a custom table (see Further Reading section below)
	}


	/**
	 * Render Meta Box content
	 */
	public function render_meta_box_content( $post ) {
		// Use nonce for verification
		wp_nonce_field( 'save_related_posts', 'mc_related_posts_nonce' );

		// The actual fields for data entry
		// Use get_post_meta to retrieve an existing value from the database and use the value for the form
		$value = get_post_meta( $post->ID, '_mc_related_posts', true );
		echo '<table width="100%"><tr><td width="33%" valign="top">';

		echo '<label for="show_mc_related_posts">Chosen posts:</label> ';
		echo '<input type="hidden" id="mc_related_posts" name="mc_related_posts" value="'. $value . '" />';
		echo '<span id="show_mc_related_posts"><br/>loading...</span><br/>';

		echo '</td><td width="33%" valign="top">';
		
		echo '<label for="similar_tags">Add a post with similar tags</label>';
		
		echo $this->get_suggested_related_posts(null);
//		echo $this->get_titles('');

		echo '</td><td width="33%" valign="top">';
		
		echo '<label for="similar_tags">search posts by title</label><br/>';
		
		echo '<input type="text" id="mc_rp_search" value="" />';
		echo '<span id="mc_rp_search_results"><br/></span><br/>';

		echo '</td></tr></table>';
	}
	
	public function get_suggested_related_posts( $already_chosen_posts ) {
		
		$ret = '';
		// get this post_id
		$p_id = get_the_ID();
		
		// get tags from this post
		$post_tags = wp_get_post_tags( $p_id, array( 'fields' => 'ids' ) );
		
		// wp_query to get posts with same tags
		$the_query = new WP_Query( array( 'tag__in' => $post_tags ) );
		
		// The Loop
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			extract(mc_load(array('id', 'title')));
			$ret .= '<br/><a class="add-to-sp" p-id="'. $id . '" href="javascript:arrien();">add</a> ' . $title;
		}
		
		// Restore original Post Data 
		wp_reset_postdata();
		
		return $ret;
	}
	public function get_titles( $search ) {
		global $wpdb; // this is how you get access to the database
		
		$ret = '';
		$ids = $wpdb->get_col("select ID from $wpdb->posts where post_title like '%$search%' ");
		$post_results = array();

		// wp_query to get posts with same tags
		$the_query = new WP_Query( array( 'post__in' => $ids ) );
		
		// The Loop
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			extract(mc_load(array('id', 'title')));
			$ret .= '<br/><a class="add-to-sp" p-id="'. $id . '" href="javascript:arrien();">' . $title . '</a>';
		}
		
		// Restore original Post Data 
		wp_reset_postdata();
		
		return $ret;
	}
}

// javascript for the related posts

add_action( 'admin_footer', 'add_related_post_by_url_javascript' );

function add_related_post_by_url_javascript() {
?>
<script type="text/javascript" >
var loaded_posts = new Array();

function arrien(){}

jQuery(document).ready(function($) {


	function chosen_post(the_post_id, the_post_title){
		return '<span class="selected-post" p-id="' + the_post_id + '"><a class="selected-post-remove" p-id="' + the_post_id + '" href="javascript:arrien();">x</a> ' + the_post_title + '</span>';
	}

	// Start up chosen related posts
	function update_chosen_posts()
	{
		$('#show_mc_related_posts').html('<br/>updating...');
		var data = {
			action: 'add_related_post_by_url',
			action_type: 'titles_by_id',
			ids: $('#mc_related_posts').val()
		};
		
		$.post(ajaxurl, data, function(response) {
			var my_posts = jQuery.parseJSON(response);
			$('#show_mc_related_posts').html('');
			for(post in my_posts)
			{
				$('#show_mc_related_posts').append('<br/>' + chosen_post(my_posts[post].id, my_posts[post].title));
			}
			if($('#show_mc_related_posts').html() == '') $('#show_mc_related_posts').html('<br/>no post chosen');
			assign_functions();
		});
	}
	
	update_chosen_posts();
	
	function assign_functions()
	{
		$('.selected-post-remove').click(function(){
			var id_to_remove = $(this).attr('p-id');
			var ids = $('#mc_related_posts').val().split(',');
			var new_ids = new Array();
			for(i in ids)
			{
				if(ids[i] != '' && ids[i] != id_to_remove) new_ids.push(ids[i]);
			}
			$('#mc_related_posts').val(new_ids.toString());
			update_chosen_posts();
		});

	
		$('.add-to-sp').click(function(){
			var new_id = $(this).attr('p-id');
			var ids = $('#mc_related_posts').val().split(',');
			ids.push(new_id);
			$('#mc_related_posts').val(ids.toString());
			update_chosen_posts();
		});

	}

	var last_search = '';
	function mc_rp_perform_search()
	{
		if($('#mc_rp_search').val() != last_search)
		{
			last_search = $('#mc_rp_search').val();
			$('#mc_rp_search_results').html('searching...');
			var data = {
				action: 'add_related_post_by_url',
				action_type: 'titles_by_title',
				title: $('#mc_rp_search').val()
			};
			
			$.post(ajaxurl, data, function(response) {
				var my_posts = jQuery.parseJSON(response);
				$('#mc_rp_search_results').html('');
				for(post in my_posts)
				{
					$('#mc_rp_search_results').append('<br/><a class="add-to-sp" p-id="'+ my_posts[post].id + '" href="javascript:arrien();">add</a> ' + my_posts[post].title);
				}
				if($('#mc_rp_search_results').html() == '') $('#mc_rp_search_results').html('<br/>no post found');
				assign_functions();
			});
		}
	}

	assign_functions();
	$('#mc_rp_search').keypress(function(e) {
    if(e.which == 13) {
    		e.preventDefault();
    		mc_rp_perform_search();
    }
	});

	$('#mc_rp_search').change(mc_rp_perform_search);

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
//	$.post(ajaxurl, data, function(response) {
//		alert('Got this from the server: ' + response);
//	});
});
</script>
<?php
}

add_action('wp_ajax_add_related_post_by_url', 'add_related_post_by_url_callback');

function add_related_post_by_url_callback() {
	global $wpdb; // this is how you get access to the database

	$action_type = $_POST['action_type'];
	$response = 'nothing';

	if($action_type == 'titles_by_id')
	{
		$ids = $_POST['ids'];
		$post_results = array();

		// wp_query to get posts with same tags
		$the_query = new WP_Query( array( 'post__in' => explode(',',$ids) ) );
		
		// The Loop
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			extract(mc_load(array('id', 'title')));
			$post_results["post-$id"] = array('id' => "$id", 'title' => "$title");
		}
		
		// Restore original Post Data 
		wp_reset_postdata();

		$response = json_encode($post_results);
	}
	else if($action_type == 'titles_by_title')
	{
		$search = sanitize_text_field($_POST['title']);
		
		$ids = $wpdb->get_col("select ID from $wpdb->posts where post_title like '%$search%' ");
		$post_results = array();

		// wp_query to get posts with same tags
		$the_query = new WP_Query( array( 'post__in' => $ids ) );
		
		// The Loop
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			extract(mc_load(array('id', 'title')));
			$post_results["post-$id"] = array('id' => "$id", 'title' => "$title");
		}
		
		// Restore original Post Data 
		wp_reset_postdata();

		$response = json_encode($post_results);
		
		
	}

  echo $response;

	die(); // this is required to return a proper result
}

?>