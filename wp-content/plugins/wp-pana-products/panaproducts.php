<?php
/*
Plugin Name: PANA Products
Plugin URI:
description: Used for Get Products from Database
Version: 1.0
Author: Webchefz Infotech
Author URI:
License: GPL2
*/

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
require_once(plugin_dir_path( __FILE__ ) . '/dataset.php');

class WPPANAProducts
{
    private $dataset;
    public function __construct(){
        //associate shortcode 'pana' with a method 'shortcode' in this class
        add_shortcode('pana_products', array($this, 'shortcode'));
    }
    /**
     * Initialise this object and its initialise collaborators.
     * @param $args
     */
    private function initialise($args=false){
        if(!empty($args['table_name']))
            $this->dataset = new WPPANADataset($this->sanitise($args['table_name']));
    }

    /**
     * Never trust user's input! To prevent all sorts of injections, sanitise it.
     * This is only (!) protecting against injection of HTML and PHP tags (e.g. <script>)
     * @param $value
     * @return string
     */
    private function sanitise($value){
        //FIXME:cater for script injections as well, if you invoke system commands
        return strip_tags($value, "");
    }


    /**
     * Each usage of shortcode 'products' will invoke this function.
     * @param $atts - attributes passed into shortcode
     * @param $content - contents of shortcode (between 'tags'), here it will be prompt
     * @return string - html snippet to insert instead of shortcode
     */
    public function shortcode($atts, $content){
        //echo '<pre>'; print_r($atts); echo '</pre>';
        //echo '<pre>'; print_r($content); echo '</pre>';
        if(!empty($atts['type'])){
            switch($atts['type']){
                case 'requirments':
                    return $this->getEligiReqHTML();
                break;
                case 'camera':
                    return $this->getCamerasHTML(['series'=>!empty($atts['series'])?$atts['series']:'S']);
                break;
                case 'lens':
                    return $this->getLensHTML(['series'=>!empty($atts['series'])?$atts['series']:'S']);
                break;
            }
        }
    }

    ///get eligibilities html
    private function getEligiReqHTML(){
        $er=$this->getEligibilityRequirments(); //print_r($er);
        $html='<div class="membershipLevel">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th style="width:50%;"></th>
									<th>SILVER</th>
                                    <th>PLATINUM</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>S Series</td>';
                                if(!empty($er)):
                                    foreach($er as $ers):
                                        if($ers->series == 'S'):
                                            $html.='<td>'.$this->getTextBody($ers->camera).' + '.$this->getTextLens($ers->lens).'</td>';
                                        endif;
                                    endforeach;
                                endif;
                    $html.='</tr>
                                    <tr>
                                        <td>G Series</td>';
                                if(!empty($er)):
                                    foreach($er as $ers):
                                        if($ers->series == 'G'):
                                            $html.='<td>'.$this->getTextBody($ers->camera).' + '.$this->getTextLens($ers->lens).'</td>';
                                        endif;
                                    endforeach;
                                endif;
                    $html.= '</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>Current as at '.date('M Y').'</p>';
            return $html;
    }
    private function getTextBody($args=false){
        return ($args == 1)?$args.' body':$args.' bodies';
    }
    private function getTextLens($args=false){
        return ($args == 1)?$args.' lens':$args.' lenses';
    }
    private function getCamerasHTML($args=false){
        switch($args['series']):
            case 'G':
                $gprod=$this->getproducts(['series'=>'G','type'=>'Camera']); //$this->printRData($gprod);

                    if(!empty($gprod)):
		$html='<div class="lumix-carousel-outer"><div class="lumixGSerirs_category owl-carousel owl-theme" id="lumixGSerirs_slider_body">';
                        foreach($gprod as $gproda):
		if(!empty($gproda->name)):
                            $extlink=!empty($gproda->ext_url)?'<a href="'.$gproda->ext_url.'" target="_blank">'.$gproda->name.'</a>':$gproda->name;
                            $html.='<div class="col-sm-3 text-center"><img src="'.$this->imgurl().$gproda->image.'" alt="" /><div class="caption">'.$extlink.'</div></div>';
		endif;
                        endforeach;
		$html.='</div>';
                if(count($gprod) > 4):
                    $html.='<div class="lumixGCSerirsNavigation">
                                        <a class="GCprev"><i class="fa fa-angle-left"></i></a>
                                        <a class="GCnext"><i class="fa fa-angle-right"></i></a>
                                    </div>';
                endif;
                $html.='</div>';
                    endif;

            break;
            case 'S':
                $sprod=$this->getproducts(['series'=>'S','type'=>'Camera']); //$this->printRData($sprod);

                    if(!empty($sprod)):
		$html='<div class="lumix-carousel-outer"><div id="lumixSSerirs_slider_body" class="lumixSSerirs_category owl-carousel owl-theme">';
                        foreach($sprod as $sproda):
		if(!empty($sproda->name)):
            $extlink=!empty($sproda->ext_url)?'<a href="'.$sproda->ext_url.'" target="_blank">'.$sproda->name.'</a>':$sproda->name;
                            $html.='<div class="col-sm-3 text-center"><img src="'.$this->imgurl().$sproda->image.'" alt="" /><div class="caption">'.$extlink.'</div></div>';
		endif;
                        endforeach;
		$html.='</div>';
                if(count($sprod) > 4):
                    $html.='<div class="lumixSCSerirsNavigation">
                                        <a class="SCprev"><i class="fa fa-angle-left"></i></a>
                                        <a class="SCnext"><i class="fa fa-angle-right"></i></a>
                                    </div>';
                endif;
                $html.='</div>';
                    endif;

            break;
        endswitch;
        return $html;
    }
    private function getLensHTML($args=false){
        switch($args['series']):
            case 'G':
                $gprod=$this->getproducts(['series'=>'G','type'=>'Lens']); //$this->printRData($gprod);
                    if(!empty($gprod)):
                        $html='<div class="lumix-carousel-outer"><div id="lumixGSerirs_slider" class="owl-carousel owl-theme">';
                        foreach($gprod as $gproda):
		if(!empty($gproda->name)):
            $extlink=!empty($gproda->ext_url)?'<a href="'.$gproda->ext_url.'" target="_blank">'.$gproda->name.'</a>':$gproda->name;
                            $html.='<div class="col-sm-3 text-center"><img src="'.$this->imgurl().$gproda->image.'" alt="" /><div class="caption">'.$extlink.'</div></div>';
		endif;
                        endforeach;
                        $html.='</div>';
                        if(count($gprod) > 4):
                            $html.='<div class="lumixGSerirsNavigation">
                                        <a class="Gprev"><i class="fa fa-angle-left"></i></a>
                                        <a class="Gnext"><i class="fa fa-angle-right"></i></a>
                                    </div>';
                        endif;
                        $html.='</div>';
                    endif;

            break;
            case 'S':
                $sprod=$this->getproducts(['series'=>'S','type'=>'Lens']); //$this->printRData($sprod);

                    if(!empty($sprod)):
                        $html='<div class="lumix-carousel-outer"><div id="lumixSSerirs_slider" class="owl-carousel owl-theme">';
                        foreach($sprod as $sproda):
					if(!empty($sproda->name)):
                        $extlink=!empty($sproda->ext_url)?'<a href="'.$sproda->ext_url.'" target="_blank">'.$sproda->name.'</a>':$sproda->name;
                            $html.='<div class="item text-center"><img src="'.$this->imgurl().$sproda->image.'" alt="" /><div class="caption">'.$extlink.'</div></div>';
					endif;
                        endforeach;
                        $html.='</div>';
                        if(count($sprod) > 4):
                        $html.='<div class="customNavigation">
                                        <a class="prev"><i class="fa fa-angle-left"></i></a>
                                        <a class="next"><i class="fa fa-angle-right"></i></a>
                                    </div>';
                        endif;
                        $html.='</div>';
                    endif;

            break;
        endswitch;
        return $html;
    }
    private function getEligibilityRequirments($args=false){
        $this->initialise(['table_name'=>'eligibility_criteria']);
        return $this->dataset->get_eligibility_criteria();
    }
    private function getproducts($args=false){
        $param['series']=!empty($args['series'])?$args['series']:'G';
        $param['type']=!empty($args['type'])?$args['type']:'Camera';
        $this->initialise(['table_name'=>'products']);
        return $erq = $this->dataset->get_products($param);
    }
    private function printRData($args=false){
        echo '<pre>'; print_r($args); echo '</pre>';
    }
    private function imgurl(){
        return get_site_url().'/members/assets/images/eligibility/';
    }

}
global $WPPANAProducts;
$WPPANAProducts = new WPPANAProducts();
