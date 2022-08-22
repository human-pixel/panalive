jQuery( document ).ready(function($) {
	$( document ).on( "click", ".single-tab-nav a", function() {
	/*  First remove class "active" from currently active tab */
		$(".single-tab-nav").removeClass('active-tab');
		/*  Now add class "active" to the selected/clicked tab */
		$(this).parent('.single-tab-nav ').addClass("active-tab");
		/*  Hide all tab content */
		$(".wp-vgp-tab-cnt").hide();
		/*  Here we get the href value of the selected tab */
		var selected_single_tab = $(this).attr("href");
		/*  Show the selected tab content */
		$(selected_single_tab).show();
		/* Pass selected tab */
		$('.selected-tab').val(selected_single_tab);
		/*  after, we add return false so that the click on the link is not executed */
		return false;
	});
	/* Remain selected tab for user */
	if( $('.selected-tab').length > 0 ) {
		var sel_tab = $('.selected-tab').val();
		if( typeof(sel_tab) !== 'undefined' && sel_tab != ''  ) {
			$('.single-tab-nav [href="'+sel_tab+'"]').click();
		}
	}
	sg_vpg_grid();//defoult call
	sg_vpg_slider();//Call to slider shortcode ganrater 
	sg_vpg_playlist();//Call to playlist shortcode ganrater 
});
function sg_vpg_grid() {   
    var sg_main = "[vpg_grid  ";      
    var vpg_grid_template = jQuery('#vpg_grid_template').val();
    var vpg_grid_limit = jQuery('#vpg_grid_limit').val();
    var  vpg_cat = jQuery('#vpg_cat').val();  
    var  vpg_grid_cell = jQuery('#vpg_grid_cell').val(); 
    var  vpg_grid_post = jQuery('#vpg_grid_post').val(); 
    var  vpg_exclude_post = jQuery('#vpg_exclude_post').val(); 
    var  vpg_grid_offset = jQuery('#vpg_grid_offset').val(); 
    var  vpg_grid_title = jQuery('#vpg_grid_title').val();  
    var  vpg_grid_content = jQuery('#vpg_grid_content').val(); 
    var  vpg_grid_order = jQuery('#vpg_grid_order').val();   
    var  vpg_grid_orderby = jQuery('#vpg_grid_orderby').val(); 
    var  vpg_grid_popup_fix = jQuery('#vpg_grid_popup_fix').val();
    var  vpg_grid_popup_gallery = jQuery('#vpg_grid_popup_gallery').val();
    var  vpg_grid_extra_class = jQuery('#vpg_grid_extra_class').val();
if (vpg_grid_template == 'default-template') {} else { sg_main = sg_main + ' template="' + vpg_grid_template + '"';}
if (vpg_grid_limit == '-1') {} else { sg_main = sg_main + ' video_limit="' + vpg_grid_limit + '"';}
if (vpg_cat == 'nocat') {} else { sg_main = sg_main + ' video_cat="' + vpg_cat + '"';} 
if (vpg_grid_cell == 'default-value') {} else { sg_main = sg_main + ' video_cell="' + vpg_grid_cell + '"';}
if (vpg_grid_post == ' ') {} else { sg_main = sg_main + ' post="' + vpg_grid_post + '"';}
if (vpg_exclude_post == ' ') {} else { sg_main = sg_main + ' exclude_post="' + vpg_exclude_post + '"';}
if (vpg_grid_offset == ' ') {} else { sg_main = sg_main + ' query_offset="' + vpg_grid_offset + '"';}
if (vpg_grid_title == 'default-value') {} else { sg_main = sg_main + ' show_title="' + vpg_grid_title + '"';}
if (vpg_grid_content == 'default-value') {} else { sg_main = sg_main + ' show_content="' + vpg_grid_content + '"';}
if (vpg_grid_order == 'default-value') {} else { sg_main = sg_main + ' order="' + vpg_grid_order + '"';}
if (vpg_grid_orderby == 'default-value') {} else { sg_main = sg_main + ' orderby="' + vpg_grid_orderby + '"';}
if (vpg_grid_popup_fix == 'default-value') {} else { sg_main = sg_main + ' popup_fix="' + vpg_grid_popup_fix + '"';}
if (vpg_grid_popup_gallery == 'default-value') {} else { sg_main = sg_main + ' popup_gallery="' + vpg_grid_popup_gallery + '"';}
if (vpg_grid_extra_class == ' ') {} else { sg_main = sg_main + ' extra_class="' + vpg_grid_extra_class + '"';}
   sg_main = sg_main + ']';
    jQuery("#vpg_sg_grid_shortcode").text(sg_main);
    jQuery("#vpg_sg_grid_shortcode_php").text("'"+sg_main+"'");
}
function sg_vpg_slider() {   
    var sg_main = "[vpg_slider  ";      
    var vpg_slider_template = jQuery('#vpg_slider_template').val();
     var vpg_slider_limit = jQuery('#vpg_slider_limit').val();
    var  vpg_slider_cat = jQuery('#vpg_slider_cat').val();  
    var  vpg_slider_cell = jQuery('#vpg_slider_cell').val(); 
    var  vpg_slider_post = jQuery('#vpg_slider_post').val(); 
    var  vpg_slider_exclude_post = jQuery('#vpg_slider_exclude_post').val(); 
    var  vpg_slider_offset = jQuery('#vpg_slider_offset').val(); 
    var  vpg_slider_title = jQuery('#vpg_slider_title').val();  
    var  vpg_slider_content = jQuery('#vpg_slider_content').val(); 
    var  vpg_slider_order = jQuery('#vpg_slider_order').val();   
    var  vpg_slider_orderby = jQuery('#vpg_slider_orderby').val(); 
    var  vpg_slider_popup_fix = jQuery('#vpg_slider_popup_fix').val();  
    var  vpg_slider_popup_gallery = jQuery('#vpg_slider_popup_gallery').val(); 
    var  vpg_slider_autoplay = jQuery('#vpg_slider_autoplay').val(); 
    var  vpg_slider_autoplay_speed = jQuery('#vpg_slider_autoplay_speed').val();
    var  vpg_slider_speed = jQuery('#vpg_slider_speed').val();
    var  vpg_slider_arrow = jQuery('#vpg_slider_arrow').val(); 
    var  vpg_slider_dots = jQuery('#vpg_slider_dots').val(); 
    var  vpg_slider_loop = jQuery('#vpg_slider_loop').val(); 
    var  vpg_slider_center_mode = jQuery('#vpg_slider_center_mode').val(); 
    var  vpg_slider_auto_height = jQuery('#vpg_slider_auto_height').val();
    var  vpg_slider_scroll = jQuery('#vpg_slider_scroll').val();   
    var  vpg_slider_extra_class = jQuery('#vpg_slider_extra_class').val();
 if (vpg_slider_template == 'default-template') {} else { sg_main = sg_main + ' template="' + vpg_slider_template + '"';}
 if (vpg_slider_limit == '-1') {} else { sg_main = sg_main + ' video_limit="' + vpg_slider_limit + '"';}
 if (vpg_slider_cat == 'nocat') {} else { sg_main = sg_main + ' video_cat="' + vpg_slider_cat + '"';} 
 if (vpg_slider_cell == ' ') {} else { sg_main = sg_main + ' video_cell="' + vpg_slider_cell + '"';}
 if (vpg_slider_post == ' ') {} else { sg_main = sg_main + ' post="' + vpg_slider_post + '"';}
 if (vpg_slider_exclude_post == ' ') {} else { sg_main = sg_main + ' exclude_post="' + vpg_slider_exclude_post + '"';}
 if (vpg_slider_offset == ' ') {} else { sg_main = sg_main + ' query_offset="' + vpg_slider_offset + '"';}
 if (vpg_slider_title == 'default-value') {} else { sg_main = sg_main + ' show_title="' + vpg_slider_title + '"';}
 if (vpg_slider_content == 'default-value') {} else { sg_main = sg_main + ' show_content="' + vpg_slider_content + '"';}
 if (vpg_slider_order == 'default-value') {} else { sg_main = sg_main + ' order="' + vpg_slider_order + '"';}
 if (vpg_slider_orderby == 'default-value') {} else { sg_main = sg_main + ' orderby="' + vpg_slider_orderby + '"';}
 if (vpg_slider_popup_fix == 'default-value') {} else { sg_main = sg_main + ' popup_fix="' + vpg_slider_popup_fix + '"';} 
 if (vpg_slider_popup_gallery == 'default-value') {} else { sg_main = sg_main + ' popup_gallery="' + vpg_slider_popup_gallery + '"';}
 if (vpg_slider_autoplay == 'default-value') {} else { sg_main = sg_main + ' autoplay="' + vpg_slider_autoplay + '"';} 
 if (vpg_slider_autoplay_speed == '2000') {} else { sg_main = sg_main + ' autoplay_interval="' + vpg_slider_autoplay_speed + '"';}
 if (vpg_slider_speed == '1000') {} else { sg_main = sg_main + ' speed="' + vpg_slider_speed + '"';}
 if (vpg_slider_arrow == 'default-value') {} else { sg_main = sg_main + ' arrows="' + vpg_slider_arrow + '"';}
 if (vpg_slider_dots == 'default-value') {} else { sg_main = sg_main + ' pagination_dots="' + vpg_slider_dots + '"';}
 if (vpg_slider_loop == 'default-value') {} else { sg_main = sg_main + ' loop="' + vpg_slider_loop + '"';}
 if (vpg_slider_center_mode == 'default-value') {} else { sg_main = sg_main + ' center_mode="' + vpg_slider_center_mode + '"';}
 if (vpg_slider_auto_height == 'default-value') {} else { sg_main = sg_main + ' auto_height="' + vpg_slider_auto_height + '"';} 
 if (vpg_slider_scroll == '1') {} else { sg_main = sg_main + ' slides_scroll="' + vpg_slider_scroll + '"';}
 if (vpg_slider_extra_class == ' ') {} else { sg_main = sg_main + ' extra_class="' + vpg_slider_extra_class + '"';}
   sg_main = sg_main + ']';
    jQuery("#vpg_sg_slider_shortcode").text(sg_main);
    jQuery("#vpg_sg_slider_shortcode_php").text("'"+sg_main+"'");
}
function sg_vpg_playlist() {   
    var sg_main = "[vpg_playlist ";      
    var vpg_playlist_template = jQuery('#vpg_playlist_template').val();
    var vpg_playlist_limit = jQuery('#vpg_playlist_limit').val();
    var  vpg_playlist_cat = jQuery('#vpg_playlist_cat').val();    
    var  vpg_playlist_post = jQuery('#vpg_playlist_post').val(); 
    var  vpg_playlist_exclude_post = jQuery('#vpg_playlist_exclude_post').val(); 
    var  vpg_playlist_offset = jQuery('#vpg_playlist_offset').val(); 
    var  vpg_playlist_title = jQuery('#vpg_playlist_title').val();  
    var  vpg_playlist_content = jQuery('#vpg_playlist_content').val(); 
    var  vpg_playlist_order = jQuery('#vpg_playlist_order').val();   
    var  vpg_playlist_orderby = jQuery('#vpg_playlist_orderby').val(); 
    var  vpg_playlist_popup_fix = jQuery('#vpg_playlist_popup_fix').val();      
    var  vpg_playlist_autoplay = jQuery('#vpg_playlist_autoplay').val(); 
    var  vpg_playlist_autoplay_speed = jQuery('#vpg_playlist_autoplay_speed').val();
    var  vpg_playlist_speed = jQuery('#vpg_playlist_speed').val();
    var  vpg_play_arrow = jQuery('#vpg_play_arrow').val(); 
    var  vpg_playlist_dots = jQuery('#vpg_playlist_dots').val();  
    var  vpg_playlist_loop = jQuery('#vpg_playlist_loop').val(); 
    var  vpg_playlist_center_mode = jQuery('#vpg_playlist_center_mode').val(); 
    var  vpg_playlist_auto_height = jQuery('#vpg_playlist_auto_height').val(); 
    var  vpg_playlist_row = jQuery('#vpg_playlist_row').val();
    var  vpg_playlist_arrow = jQuery('#vpg_playlist_arrow').val();  
    var  vpg_playlist_extra_class = jQuery('#vpg_playlist_extra_class').val();
 if (vpg_playlist_template == 'default-template') {} else { sg_main = sg_main + ' template="' + vpg_playlist_template + '"';}
 if (vpg_playlist_limit == '-1') {} else { sg_main = sg_main + ' video_limit="' + vpg_playlist_limit + '"';}
 if (vpg_playlist_cat == 'nocat') {} else { sg_main = sg_main + ' video_cat="' + vpg_playlist_cat + '"';} 
 if (vpg_playlist_post == ' ') {} else { sg_main = sg_main + ' post="' + vpg_playlist_post + '"';}
 if (vpg_playlist_exclude_post == ' ') {} else { sg_main = sg_main + ' exclude_post="' + vpg_playlist_exclude_post + '"';}
 if (vpg_playlist_offset == ' ') {} else { sg_main = sg_main + ' query_offset="' + vpg_playlist_offset + '"';}
 if (vpg_playlist_title == 'default-value') {} else { sg_main = sg_main + ' show_title="' + vpg_playlist_title + '"';}
 if (vpg_playlist_content == 'default-value') {} else { sg_main = sg_main + ' show_content="' + vpg_playlist_content + '"';}
 if (vpg_playlist_order == 'default-value') {} else { sg_main = sg_main + ' order="' + vpg_playlist_order + '"';}
 if (vpg_playlist_orderby == 'default-value') {} else { sg_main = sg_main + ' orderby="' + vpg_playlist_orderby + '"';}
 if (vpg_playlist_popup_fix == 'default-value') {} else { sg_main = sg_main + ' popup_fix="' + vpg_playlist_popup_fix + '"';} 
 if (vpg_playlist_autoplay == 'default-value') {} else { sg_main = sg_main + ' autoplay="' + vpg_playlist_autoplay + '"';} 
 if (vpg_playlist_autoplay_speed == '2000') {} else { sg_main = sg_main + ' autoplay_interval="' + vpg_playlist_autoplay_speed + '"';}
 if (vpg_playlist_speed == '1000') {} else { sg_main = sg_main + ' speed="' + vpg_playlist_speed + '"';}
 if (vpg_play_arrow == 'default-value') {} else { sg_main = sg_main + ' arrows="' + vpg_play_arrow + '"';}
 if (vpg_playlist_dots == 'default-value') {} else { sg_main = sg_main + ' pagination_dots="' + vpg_playlist_dots + '"';}
 if (vpg_playlist_loop == 'default-value') {} else { sg_main = sg_main + ' loop="' + vpg_playlist_loop + '"';}
 if (vpg_playlist_center_mode == 'default-value') {} else { sg_main = sg_main + ' center_mode="' + vpg_playlist_center_mode + '"';}
 if (vpg_playlist_auto_height == 'default-value') {} else { sg_main = sg_main + ' auto_height="' + vpg_playlist_auto_height + '"';} 
 if (vpg_playlist_row == '4') {} else { sg_main = sg_main + ' playlist_row="' + vpg_playlist_row + '"';}
 if (vpg_playlist_arrow == 'default-value') {} else { sg_main = sg_main + ' playlist_arrow=" ' + vpg_playlist_arrow + '"';}
 if (vpg_playlist_extra_class == ' ') {} else { sg_main = sg_main + ' extra_class="' + vpg_playlist_extra_class + '"';}
   sg_main = sg_main + ']';
    jQuery("#vpg_sg_playlist_shortcode").text(sg_main);
    jQuery("#vpg_sg_playlist_shortcode_php").text("'"+sg_main+"'");
}
