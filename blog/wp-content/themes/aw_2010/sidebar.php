	<div id="rightcolumn" style="float:right;">
 
        <div class="moduletable">
        <h3>Pages</h3>
        		<ul>
			<?php wp_list_pages(); ?>
            	</ul>
		</div>
        <div class="moduletable">
			<h3>Archives</h3>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
		</div>
        <div class="moduletable">
        <h3>Catagories</h3>
				<ul>
			<?php wp_list_categories('show_count=1'); ?>
        		</ul>
        </div>

	</div>

