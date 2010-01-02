 
<h2 class="contentheading"><?php echo htmlspecialchars($this->cat_name) ?></h2>

<?php
if ( (isset($this->cat_image) && $this->cat_image <> '') || (isset($this->cat_desc) && $this->cat_desc <> '') ) {
	echo '<div id="cat-desc">';
	if (isset($this->cat_image) && $this->cat_image <> '') {
		echo '<div id="cat-image">';
		$this->plugin( 'image', $this->config->getjconf('live_site').$this->config->get('relative_path_to_cat_small_image') . $this->cat_image , $this->cat_name, '', '', '' );
		echo '</div>';
	}
	if ( isset($this->cat_desc) && $this->cat_desc <> '') {	echo '<p>' . $this->cat_desc . '</p>'; }
	echo '</div>';
}
?>

<?php include $this->loadTemplate( 'sub_subCats.tpl.php' ) ?>

<?php if( $this->cat_show_listings ) include $this->loadTemplate( 'sub_listings.tpl.php' ) ?>