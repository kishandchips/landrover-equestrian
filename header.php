<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package landrover
 * @since landrover 1.0
 */
global $post;
$ajax = (isset($_GET['ajax']) && $_GET['ajax'] == true) ? true : false;
if(!$ajax):
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href="<?php echo get_template_directory_uri(); ?>/images/misc/favicon.png" rel="shortcut icon" type="image/x-icon">
    
    <script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
		var url = (window.location != window.parent.location) ? document.referrer: document.location;
		if(url.indexOf('apps.facebook.com') >= 0){
			window.top.location = 'https://www.facebook.com/landrover.uk/app_579639135402354?app_data=<?php echo $post->ID; ?>';
		}
	</script>
    <?php

	if ( ! is_admin() ) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js', false, '1.9.1');
        wp_enqueue_script('jquery');
    }
	
	function load_assets() {

		wp_enqueue_style('style', get_template_directory_uri().'/css/style.css');
		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/libs/modernizr.min.js');
		wp_enqueue_script('jquery', get_template_directory_uri().'/js/libs/jquery.min.js');
		wp_enqueue_script('easing', get_template_directory_uri().'/js/plugins/jquery.easing.js', array('jquery'), '', true);
		wp_enqueue_script('scroller', get_template_directory_uri().'/js/plugins/jquery.scroller.js', array('jquery'), '', true);
		wp_enqueue_script('actual', get_template_directory_uri().'/js/plugins/jquery.actual.js', array('jquery'), '', true);
		wp_enqueue_script('imagesloaded', get_template_directory_uri().'/js/plugins/jquery.imagesloaded.js', array('jquery'), '', true);
		wp_enqueue_script('transit', get_template_directory_uri().'/js/plugins/jquery.transit.js', array('jquery'), '', true);
		wp_deregister_script('accordion');
		wp_register_script('accordion', get_template_directory_uri().'/js/plugins/jquery.accordion.js', array('jquery'), '', true);
		wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery'), '', true);
		wp_register_script('youtube', '//www.youtube.com/player_api', false, '', true);
	}
	add_action('wp_enqueue_scripts', 'load_assets');
	wp_head();
?>

</head>
<body <?php body_class(); ?>>
<div id="fb-root"></div>
<div id="lightbox">
	<div class="loader"></div>
	<div class="content"></div>
	<div class="overlay"></div>
</div>
<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="header" role="banner">
		<div class="inner container">
			<h1 class="logo-container">
				<a class="logo" href="<?php echo get_permalink( get_field('homepage', 'options') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<?php if(!is_front_page()): ?>
				<span class="description">
					<?php _e("Equestrian:<br />The pursuit of Excellence", THEME_NAME); ?>
				</span>
				<?php endif; ?>
			</h1>
			<?php if(!is_front_page()): ?>
			<div class="navigation-container">
				<!--button class="mobile-navigation-btn uppercase">menu <i aria-hidden="true" class="icon-arrow-down tiny"></i></button-->
				<nav role="navigation" class="site-navigation main-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary_header', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
				</nav><!-- .site-navigation .main-navigation -->
			</div>
			<?php endif; ?>
		</div>
	</header><!-- #header -->
	<div id="main" class="site-main" role="main">

<?php endif; ?>