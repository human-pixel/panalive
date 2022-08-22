<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lumix Pro Services</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.theme.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.theme.default.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flatsome.css">
	    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fl-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>admintemplate/bower_components/select2/dist/css/select2.min.css" />

        <!-- Latest compiled and minified JavaScript -->

		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/owl.carousel.js"></script>
		<script type='text/javascript' src='/wp-includes/js/hoverIntent.min.js?ver=1.8.1'></script>
       <script type='text/javascript'>
		/* <![CDATA[ */
var flatsomeVars = {"ajaxurl":"https:\/\/pana.dev.humanpixel.com.au\/wp-admin\/admin-ajax.php","rtl":"","sticky_height":"70","lightbox":{"close_markup":"<button title=\"%title%\" type=\"button\" class=\"mfp-close\"><svg xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"><\/line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"><\/line><\/svg><\/button>","close_btn_inside":false},"user":{"can_edit_pages":false}};
/* ]]> */

</script>

		<script type='text/javascript' src='/wp-content/themes/flatsome/assets/js/flatsome.js?ver=3.11.3'></script>

        <script src="<?php echo base_url(); ?>assets/js/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>admintemplate/bower_components/select2/dist/js/select2.full.min.js"></script>
        <style>
            .select2-selection__rendered {
                line-height: 34px !important;
            }
            .select2-container .select2-selection--single {
                height: 38px !important;
            }
            .select2-selection__arrow {
                height: 37px !important;
            }
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #E60012;
                border-color: #E60012; !important;
            }

            .eligible-message-error-icon {
                background-color: palevioletred;
                padding: 8px;
                border-radius: 20px;
            }
            .eligible-message-success-icon {
                background-color: darkseagreen;
                padding: 8px;
                border-radius: 20px;
            }
        </style>
    </head>
    <body <?php body_class(); ?>>
        <div class="wrapper">
		<?php do_action( 'flatsome_before_header' ); ?>
            <header id="header" class="header <?php flatsome_header_classes(); ?>">
                <div class="header-wrapper">
                    <?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
                </div>
            </header>

			<?php do_action( 'flatsome_after_header' ); ?>
            <div class="main">
                <div class="background_white">
