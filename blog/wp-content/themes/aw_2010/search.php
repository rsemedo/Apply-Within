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
	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>

				<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>
</div>
</div>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>