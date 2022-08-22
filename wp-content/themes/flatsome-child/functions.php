<?php
// Add custom Theme Functions here

function wpdocs_codex_gallery() {
    $labels = array(
        'name'                  => _x( 'Gallery', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Gallery', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Gallery', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Gallery', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Gallery', 'textdomain' ),
        'new_item'              => __( 'New Gallery', 'textdomain' ),
        'edit_item'             => __( 'Edit Gallery', 'textdomain' ),
        'view_item'             => __( 'View Gallery', 'textdomain' ),
        'all_items'             => __( 'All Gallery', 'textdomain' ),
        'search_items'          => __( 'Search Gallery', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Gallery:', 'textdomain' ),
        'not_found'             => __( 'No Gallery found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Gallery found in Trash.', 'textdomain' ),

    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'gallery' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'gallery', $args );
    register_taxonomy( 'gallery-categories', array('gallery'), array(
'hierarchical' => true,
'label' => 'Gallery Categories',
'singular_label' => 'Category',
'rewrite' => array( 'slug' => 'gallery-categories', 'with_front'=> false )
));
register_taxonomy_for_object_type( 'categories', 'prodotti' );
}
add_action( 'init', 'wpdocs_codex_gallery' );


function home_gallery($atts, $content = null) {
    extract(shortcode_atts(array(
       'id' => "",
       'class' => "",
    ), $atts)); ?>
    <?php
 $loop = new WP_Query( array( 'post_type' => 'gallery', 'posts_per_page' => -1, 'order' => 'DESC' ) );?>
<!-- <div class="slick-wrapper slick-gallery-outer"> -->
  <div class="lumixgalleryNavigation">
        <a class="galleryprev"><i class="fa fa-angle-left"></i></a>
        <a class="gallerynext"><i class="fa fa-angle-right"></i></a>
      </div>
  <div id="lumix_gallery_slider" class="owl-carousel owl-theme">
   <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>


    <?php if( $loop->current_post % 6 == 0 ) echo "\n".'<div class="item">'."\n"; ?>


     <div class="slide-item rl-gallery-item">
        <a href="<?php the_post_thumbnail_url(); ?>" title="" data-rl_title="" class="rl-gallery-link" data-rl_caption="<?php
$get_description = get_post(get_post_thumbnail_id())->post_excerpt;
  if(!empty($get_description)){//If description is not empty show the div
  echo '' . $get_description . '';
  }?>" data-rel="-gallery-1">
            <img src="<?php the_post_thumbnail_url(); ?>" width="300" height="300">
            <div class="rl-gallery-item-caption">
                <?php
$get_description = get_post(get_post_thumbnail_id())->post_excerpt;
  if(!empty($get_description)){//If description is not empty show the div
  echo '' . $get_description . '';
  }?>
            </div>
        </a>
     </div>
<?php if( $loop->current_post % 6 == 5 ) echo '</div> <!--/.wrap-->'."\n"; ?>


    <?php endwhile;?>

</div>
<!-- </div> -->



<?php wp_reset_query(); ?>
<?php
 }
 add_shortcode('home_gallery', 'home_gallery');


function enqueue_assets(){
	wp_enqueue_style('owl-carousel-style-css', 'https://lumixpro.panasonic.com.au/members/assets/css/owl.carousel.css');
	wp_enqueue_style('owl-carousel-theme-style-css', 'https://lumixpro.panasonic.com.au/members/assets/css/owl.theme.css');
	wp_enqueue_style('owl-carousel-theme-default-style-css', 'https://lumixpro.panasonic.com.au/members/assets/css/owl.theme.default.min.css');
	wp_enqueue_style('font-awesome-4.7.0-cdn','https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_script('owl-carousel-js-file', 'https://lumixpro.panasonic.com.au/members/assets/js/owl.carousel.js', array(), null, true );
}
add_action('wp_enqueue_scripts', 'enqueue_assets');
