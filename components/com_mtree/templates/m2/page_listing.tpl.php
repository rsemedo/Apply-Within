<?php 

// Check listing details' access
if( 
	$this->config->getTemParam('limitDetailsViewToRegistered',0) == 0
	||
	(
		$this->config->getTemParam('limitDetailsViewToRegistered',0) == 1
		&&
		$this->my->id > 0
	)
) {

	include $this->loadTemplate( 'sub_listingDetails.tpl.php' );

	if ($this->mtconf['use_map']) include $this->loadTemplate( 'sub_map.tpl.php' );

	if (!empty($this->images)) include $this->loadTemplate( 'sub_images.tpl.php' );

	if ($this->mt_show_review) include $this->loadTemplate( 'sub_reviews.tpl.php' ); 

} else {
	?>
	 
	<?php
	echo JText::_( 'Please login to view more information about this listing.' );
}

?>