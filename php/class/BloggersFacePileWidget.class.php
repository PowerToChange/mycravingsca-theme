<?php

/**
 * Adds Foo_Widget widget.
 */
class Blogger_Facepile_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'blogger_facepile_widget', // Base ID
			'Blogger_Facepile_Widget', // Name
			array( 'description' => __( 'A Blogger Facepile Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$bloggers = explode(',', $instance['bloggers_list']);

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		if ( ! empty( $bloggers ) ) $this->bloggers_face_pile($bloggers);
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		if ( isset( $instance[ 'title' ] ) ) {
			$bloggers_list = $instance[ 'bloggers_list' ];
		}
		else {
			$bloggers_list = __( '', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<label for="<?php echo $this->get_field_name( 'bloggers_list' ); ?>"><?php _e( 'Bloggers:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'bloggers_list' ); ?>" name="<?php echo $this->get_field_name( 'bloggers_list' ); ?>" type="text" value="<?php echo esc_attr( $bloggers_list ); ?>" />

		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['bloggers_list'] = ( ! empty( $new_instance['bloggers_list'] ) ) ? strip_tags( $new_instance['bloggers_list'] ) : '';;
		return $instance;
	}
	
	function bloggers_face_pile($bloggers)
	{
		global $mycravings_bloggers;
		$mycravings_bloggers = $bloggers;
		echo "<div class=\"bloggers_facepile_title tk-league-gothic\">OUR BLOGGERS</div>";
		foreach ($bloggers as $blogger) {
			echo "<div class=\"blogger\">";
			$this->image_author($blogger);
			echo "</div>";
		}
	}
	
	function image_author($author_id)
	{
		$author_link = get_author_posts_url($author_id);
		$img = $this->get_author_img($author_id);
		echo "<a href=\"$author_link\"><img src=\"$img\" /></a>";
	}
	
	function get_author_img($author_id){
		$ret = '';
		if ( !$author_id ) {
			if ( in_the_loop() ) {
				$author_id = get_the_author_ID();
			} elseif ( is_singular() ) {
				global $wp_the_query;
				$author_id = $wp_the_query->posts[0]->post_author;
			} elseif ( is_author() ) {
				global $wp_the_query;
				$author_id = $wp_the_query->get_queried_object_id();
			} else {
				return;
			}
		}
		
		$author_image = get_usermeta($author_id, 'author_image');
		
		if ( $author_image === '' )
			$author_image = author_image::get_meta($author_id);
		
		if ( !$author_image )
			return;
		
		$author_image = content_url() . '/authors/' . str_replace(' ', rawurlencode(' '), $author_image);
		$ret = esc_url($author_image);		
		
		return $ret;
	
	} 

/*	For future use?
 * 		echo '<select id="website_users">';
		foreach ($bloggers as $blogger) {
			echo '<option value="' . $blogger->ID . '">' . $blogger->display_name . '</option>';
		}
		echo '</select>';
 * 
 * 
 * */


} // class Blogger_Facepile_Widget

// register Foo_Widget widget
function register_blogger_facepile_widget() {
    register_widget( 'Blogger_Facepile_Widget' );
}
add_action( 'widgets_init', 'register_blogger_facepile_widget' );


// javascript for the related posts

add_action( 'admin_footer', 'add_blogger_javascript' );

function add_blogger_javascript() {
?>
<script type="text/javascript" >

jQuery(document).ready(function($) {


});
</script>
<?php
}

?>