<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package flatsome
 */

get_header(); ?>
<?php do_action( 'flatsome_before_404' ); ?>
<?php
if ( get_theme_mod( '404_block' ) ) :
	echo do_shortcode( '[block id="' . get_theme_mod( '404_block' ) . '"]' );
else :
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main container pt" role="main">
			<section class="error-404 not-found mt mb">
				<div class="row">
						<header class="page-title">
							<h1 class="page-title"><?php esc_html_e( 'Page not found', 'flatsome' ); ?></h1>
						</header>
						<div class="page-content">
							<p><?php esc_html_e( "We're sorry, the page you are looking for could not be found.", 'flatsome' ); ?></p>
							<p><?php esc_html_e( "Please find some useful links below to help get you back on track.", 'flatsome' ); ?></p>
							<ul>
								<li><a href="<?php echo get_site_url()?>">Home</a></li>
                        <li><a href="<?php echo get_site_url()?>/members/users/login">Member Login</a></li>
                        <li><a href="<?php echo get_site_url()?>/faq">FAQ</a></li>
							</ul>
						</div>
				</div>
			</section>
		</main>
	</div>
<?php endif; ?>
<?php do_action( 'flatsome_after_404' ); ?>
<?php get_footer(); ?>
