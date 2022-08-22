<?php include './members/external.php';   ?>
<!DOCTYPE html>
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="ie9 <?php flatsome_html_classes(); ?>"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="ie8 <?php flatsome_html_classes(); ?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="<?php flatsome_html_classes(); ?>"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'flatsome_after_body_open' ); ?>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>

<div id="wrapper">
<?php do_action( 'flatsome_before_header' ); ?>
    <style>
        .hp-sumenu { width: 170px !important; min-width: 170px !important; }
        .hp-sumenu li a { font-size: 16px; text-transform: uppercase; font-weight: 600; }
    </style>
    <?php if(!empty($_SESSION['login']) and $_SESSION['login'] == 1): ?>
    <style>
        .hp-sumenu { width: 235px !important; min-width: 235px !important; }
        .hp-sumenu li a { font-size: 16px; text-transform: uppercase; font-weight: 600; }
    </style>
    <?php  endif; ?>
        <header id="header" class="header <?php flatsome_header_classes(); ?>">
        <div class="header-wrapper">
            <?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
        </div>
           <?php if(!empty($_SESSION['login']) and $_SESSION['login'] == 1): $m_fname=!empty($_SESSION['personal_detail']['first_name'])?$_SESSION['personal_detail']['first_name']:''; $m_lname=!empty($_SESSION['personal_detail']['last_name'])?$_SESSION['personal_detail']['last_name']:''; $m_number=!empty($_SESSION['membership']['m_ship_num'])?$_SESSION['membership']['m_ship_num']:'';  ?>
        <div class="header-bar">
            <div class="container">
            <div class="header-bar-left">
                Hi <strong><?=$m_fname.' '.$m_lname?></strong>, Your Membership Number is: <strong><?=$m_number?></strong>
            </div>
            <div class="header-right">
                <a href="<?=get_site_url().'/members/users/logout'?>">LOGOUT</a></div>
            </div>
        </div>
            <?php endif; ?>
    </header>

	<?php do_action( 'flatsome_after_header' ); ?>

	<main id="main" class="<?php flatsome_main_classes(); ?>">
