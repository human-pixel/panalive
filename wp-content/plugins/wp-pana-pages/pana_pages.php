<?php
/*
Plugin Name: PANA Pages
Plugin URI:
description: Manage Paragraph Text for Selected Pages
Version: 1.0
Author: Webchefz Infotech
Author URI:
License: GPL2
*/
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

function addMenuPANAPages(){
    add_menu_page(
         'PANA Pages',
         'PANA Pages',
         'manage_options',
         'panapages',
         'panapages',
         'dashicons-admin-page',
         2
     );
}
add_action( 'admin_menu', 'addMenuPANAPages' );
/* PANA Pages added to option DB */
function AddPANAPagesToOptions(){
    $pageOptions=panaPagesArray();
    if(!empty($pageOptions)):
        foreach($pageOptions as $pageOptionsa):
            add_option($pageOptionsa, '');
        endforeach;
    endif;
}
add_action('admin_init', 'AddPANAPagesToOptions');
//function for pana pages
function panapages(){
    if(!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    require_once(plugin_dir_path( __FILE__ ) . '/panapages.php');
}
function get_pages_data(){
    $pageOptions=panaPagesArray(); $return=array();
    $pageOptionsLabel=panaPagesLabelArray();
    if(!empty($pageOptions)): $c=0;
        foreach($pageOptions as $pageOptionsa):
            array_push($return, [
                'key'=>$pageOptionsa,
                'label'=>$pageOptionsLabel[$c],
                'value' => get_option($pageOptionsa)
            ]);
            $c++;
        endforeach;
    endif;
    return $return;
}
/* Pana Page Options Array   */
function panaPagesArray(){
    return [
        'pana_applypage',
        'pana_loginpage',
        'pana_setpasswordpage',
        'pana_resetpasswordpage',
        'pana_forgotpasswordpage'
    ];
}
function panaPagesLabelArray(){
    return [
        'Apply Page',
        'Login Page',
        'Set Password Page',
        'Reset Password Page (Open Using Mail Link)',
        'Reset Password Page'
    ];
}
/* Update PANA Pages Data */
function secureOptionData($args=false){
    if(!empty($args['text']) and !empty($args['do'])):
        switch($args['do']):
            case 'set': return sanitize_textarea_field($args['text']); break;
            case 'get': return esc_textarea($args['text']); break;
        endswitch;
    endif;
}
function update_pana_pages($args=false){
    $redirect=get_admin_url().'admin.php?page=panapages';
    if(!empty($args)):
        foreach($args as $key => $value):
            update_option($key, !empty($value)?secureOptionData(['do'=>'set','text'=>$value]):'');
        endforeach;
        wp_redirect($redirect); exit();
    endif;
}
/* Get Sigle Page Data */
function getPageData($args=false){
    if(!empty($args)): $pages=panaPagesArray();
        if(in_array($args, $pages)):
            return secureOptionData(['do'=>'get','text'=>get_option($args)]);
        else:
            return 'wrong shortcode';
        endif;
    endif;
}
/* print_r function for debuggs */
function printRData($args=false){
    echo '<pre>'; print_r($args); echo '</pre>';
}

/* Shotcode to get specific page data   */
add_shortcode('pana_page', 'getPANAPageContent');
function getPANAPageContent($args=false){
    if(!empty($args['page'])):
        return getPageData('pana_'.$args['page']);
    endif;
}
