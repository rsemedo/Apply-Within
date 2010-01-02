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

		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>

			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>

				<p class="postmetadata alt">
					<small>
						This entry was posted
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/wordpress/time-since/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

						<?php if ( comments_open() && pings_open() ) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif ( !comments_open() && pings_open() ) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif ( comments_open() && !pings_open() ) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif ( !comments_open() && !pings_open() ) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry','','.'); ?>

					</small>
				</p>

			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>
</div>
</div>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
