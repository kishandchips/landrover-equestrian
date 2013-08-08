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

</body>
</html>