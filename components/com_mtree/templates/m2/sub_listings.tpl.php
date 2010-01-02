<div id="listings"><?php

if( $this->task == "search" && empty($this->links) ) {

	if( empty($this->categories) ) {
	?>
	<p /><center><?php echo JText::_( 'Your search does not return any result' ) ?></center><p />
	<?php
	}
	
} else {
	?>
	<div class="title"><?php echo JText::_( 'Listings' ); ?>&nbsp;<?php echo ($this->mtconf['show_category_rss']) ? $this->plugin('showrssfeed','new') : ''; ?></div>

	<div class="pages-links">
		<span class="xlistings"><?php echo $this->pageNav->getResultsCounter(); ?></span>
		<?php echo $this->pageNav->getPagesLinks(); ?>
	</div>

	<?php
	if (isset($this->cat_allow_submission) && $this->cat_allow_submission && $this->user_addlisting >= 0) {
		echo $this->plugin("ahref","index.php?option=com_mtree&task=addlisting&cat_id=$this->cat_id&Itemid=$this->Itemid",JText::_( 'Add your listing here' ),'class="add-listing"');
	}
	
	foreach ($this->links AS $link) {
		$fields = $this->fields[$link->link_id];
		include $this->loadTemplate('sub_listingSummary.tpl.php');
	}

	if( $this->pageNav->total > $this->pageNav->limit ) { ?>
	<div class="pages-links">
		<span class="xlistings"><?php echo $this->pageNav->getResultsCounter(); ?></span>
		<?php echo $this->pageNav->getPagesLinks(); ?>
	</div>
	<?php
	}
	
}
?></div>