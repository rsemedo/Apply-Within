<div class="listing-summary<?php echo ($link->link_featured && $this->config->getTemParam('useFeaturedHighlight','1')) ? ' featured':''?>">
		<h3><?php 
			$link_name = $fields->getFieldById(1);
			switch( $this->config->getTemParam('listingNameLink','1') )
			{
				default:
				case 1:
					$this->plugin( 'ahreflisting', $link, $link_name->getOutput(2), '', array('delete'=>false) );
					break;
				case 4:
					if( !empty($link->website) ) {
						$this->plugin( 'ahreflisting', $link, $link_name->getOutput(2), '', array('delete'=>false), 1 );
					} else {
						$this->plugin( 'ahreflisting', $link, $link_name->getOutput(2), '', array('delete'=>false) );
					}
					break;
				case 2:
					$this->plugin( 'ahreflisting', $link, $link_name->getOutput(2), '', array('delete'=>false), 1 );
					break;
				case 3:
					$this->plugin( 'ahreflisting', $link, $link_name->getOutput(2), 'target="_blank"', array('delete'=>false), 1 );
					break;
				case 0:
					$this->plugin( 'ahreflisting', $link, $link_name->getOutput(2), '', array('delete'=>false, 'link'=>false) );
					break;
			}
		?></h3><?php
		
		// Rating
		$this->plugin( 'rating', $link->link_rating, $link->link_votes, $link->attribs);
		
		// Address
		if( $this->config->getTemParam('displayAddressInOneRow','1') ) {
			$fields->resetPointer();
			$address_parts = array();
			while( $fields->hasNext() ) {
				$field = $fields->getField();
				$output = $field->getOutput(2);
				if(in_array($field->getId(),array(4,5,6,7,8)) && !empty($output)) {
					$address_parts[] = $output;
				}
				$fields->next();
			}
			if( count($address_parts) > 0 ) { echo '<div class="address">' . implode(', ',$address_parts) . '</div>'; }
		}
		
		// Website
		$website = $fields->getFieldById(12);
		if(!is_null($website) && $website->hasValue()) { echo '<span class="website">' . $website->getOutput(2) . '</span>'; }

		// Listing's first image
		if(!is_null($fields->getFieldById(2)) || $link->link_image) {
			echo '<p style="margin:0;">';
			if ($link->link_image && $this->config->getTemParam('showImageInSummary',1) ) {
				$this->plugin( 'ahreflistingimage', $link, 'class="image' . (($this->config->getTemParam('imageDirectionListingSummary','right')=='right') ? '':'-left') . '" alt="'.htmlspecialchars($link->link_name).'"' );
			}
			if(!is_null($fields->getFieldById(2))) { 
				$link_desc = $fields->getFieldById(2);
				echo $link_desc->getOutput(2);
			}
			echo '</p>';
		}
		
		// Listing's category
		if($this->task <> 'listcats' && $this->task <> '' ) {
			echo '<div class="category"><span>' . JText::_( 'Category' ) . ':</span>';
			$this->plugin( 'mtpath', $link->cat_id, '' );
			echo '</div>';
		}
		
		// Other custom field		
		$fields->resetPointer();
		echo '<div class="fields">';
		while( $fields->hasNext() ) {
			$field = $fields->getField();
			$value = $field->getOutput(2);
			if(
				( 
					(
						!$field->hasInputField() && !$field->isCore() && empty($value)) 
						|| 
						(!empty($value) || $value == '0')
					) 
					&&	
					!in_array($field->getId(),array(1,2,12))
					&&
					(
						($this->config->getTemParam('displayAddressInOneRow','1') && !in_array($field->getId(),array(4,5,6,7,8))
						||
						$this->config->getTemParam('displayAddressInOneRow','1') == 0						
					)
				)
			) {
				echo '<div class="fieldRow">';
				if($field->hasCaption()) {
					echo '<span class="caption">' . $field->getCaption() . '</span>';
					echo '<span class="output">' . $field->getOutput(2) . '</span>';
				} else {
					echo '<span class="output">' . $field->getOutput(2) . '</span>';
				}
				echo '</div>';
			}
			$fields->next();
		}
		echo '</div>';
		
		if($this->config->getTemParam('showActionLinksInSummary','0')) {
			echo '<div class="actions">';
			$this->plugin( 'ahrefreview', $link, array("rel"=>"nofollow") ); 
			$this->plugin( 'ahrefrecommend', $link, array("rel"=>"nofollow") );	
			$this->plugin( 'ahrefprint', $link );
			$this->plugin( 'ahrefcontact', $link, array("rel"=>"nofollow") );
			$this->plugin( 'ahrefvisit', $link );
			$this->plugin( 'ahrefreport', $link, array("rel"=>"nofollow") );
			$this->plugin( 'ahrefclaim', $link, array("rel"=>"nofollow") );
			$this->plugin( 'ahrefownerlisting', $link );
			$this->plugin( 'ahrefmap', $link );
			echo '</div>';
		}
?></div>