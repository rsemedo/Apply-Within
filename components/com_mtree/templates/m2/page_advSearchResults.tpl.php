<h2 class="contentheading"><?php echo JText::_( 'Advanced search results' ) ?></h2>

<div id="listings">
	<?php if ( !empty($this->links) ) { ?>

	<div class="pages-links">
		<span class="xlistings"><?php echo $this->pageNav->getResultsCounter(); ?></span>
		<?php echo $this->pageNav->getPagesLinks(); ?>
	</div>
	
	<?php
	foreach ($this->links AS $link): 
	$fields = $this->fields[$link->link_id];
	
	include $this->loadTemplate('sub_listingSummary.tpl.php') ?>
	<?php endforeach; ?>

	<?php
	if( $this->pageNav->total > 0 ) { ?>
	<div class="pages-links">
		<span class="xlistings"><?php echo $this->pageNav->getResultsCounter(); ?></span>
		<?php echo $this->pageNav->getPagesLinks(); ?>
	</div>
	<?php }
	?>
	
	<?php } else { ?>
	<p /><center><?php echo JText::_( 'Your search does not return any result' ) ?></center><p />
	<?php } ?>
	
</div>