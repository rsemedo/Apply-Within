<?php get_header(); ?>
<div id="whitebox_m">
<div id="area">
<?php get_sidebar(); ?>
<div id="leftcolumn">
			<div class="moduletable">
					<h3>Stay In Touch</h3>
					<script language="javascript">
function doClear(theText) {
     if (theText.value == theText.defaultValue) {
         theText.value = ""
     }
 }
</script>
<form action="http://oi.vresp.com?fid=d0845581c8" method="post"> <input style="margin-top: 5px; margin-bottom: 5px; padding: 3px; border: 1px solid #999;" name="email_address" type="text" value="Email Address" onFocus="doClear(this)" /> 
 <input style="margin-top: 5px;" type="submit" value="Subscribe" /> </form>
 			</div>
            
			<div class="moduletable">
					<h3>Enterprising Mom?</h3>
					<p>Looking for a source of support, connection and inspiration? <a href="http://theenterprisingmoms.com" target="_blank">Join us!</a></p>
           	</div>
            
			<div class="moduletable">
					<h3>Free Consultation</h3>
					<p>Curious about coaching?</p>
<p>The best way to learn about it is to experience it for yourself.</p>
<p><a href="mailto:coach@applywithin.com?subject=Free Sample Session or Consultation">Contact me</a> for a free 30-minute exploratory session.</p>
			</div>
		</div>
	<div id="area">
        <div id="maincolumn" class="blogmaincolumn">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
</div>
</div>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
