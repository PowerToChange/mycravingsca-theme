    <div class="front_article">
      <div class="front_article_title_black_box"></div>
<?php
if(!$author_image) {
?>
      <div class="front_article_title tk-league-gothic">
        <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
        <div class="author"><a href="<?php echo $author_url; ?>"><?php echo $author; ?></a></div>
      </div>
<?php
}
else {
?>
      <div class="front_article_title tk-league-gothic with_image">
        <a href="<?php echo $author_url; ?>"><?php echo $author_image; ?></a><a href="<?php echo $url; ?>"><?php echo $title; ?></a>
        <div class="author"><a href="<?php echo $author_url; ?>"><?php echo $author; ?></a></div>
      </div>
<?php
}
?>
      <a href="<?php echo $url; ?>"><?php echo $thumbnail_full; ?></a>
    </div>
