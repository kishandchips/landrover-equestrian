<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package landrover
 * @since landrover 1.0
 */
$ajax = (isset($_GET['ajax']) && $_GET['ajax'] == true) ? true : false;
if(!$ajax):
?>
	</div><!-- #main .site-main -->
	<footer id="footer" class="site-footer grey-gradient-bg" role="contentinfo">
		<div class="inner container">
			<p class="text-right bold"><?php the_field('footer_text', 'options') ?></p>
		</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->
<?php endif; ?>
<?php wp_footer(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2727159-30', 'occam-dm.com');
  ga('send', 'pageview');

</script>
</body>
</html>