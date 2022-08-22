<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('Product_Model', 'product');
	}

	public function view($page = 'home'){
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		$data['title'] = ucfirst($page);

		if($page == 'eligibility') {
			$data['products'] = $this->product->get_products();
			$criteria = $this->product->get_eligibility_criteria();
			foreach ($criteria as $value) {
				if($value['series'] == 'G') {
					if($value['membership'] == 'Platinum') {
						$gpcc_array = $value['camera'];
						$gpcl_array = $value['lens'];
					}
					else {
						$gscc_array = $value['camera'];
						$gscl_array = $value['lens'];
					}
				}
				if($value['series'] == 'S') {
					if($value['membership'] == 'Platinum') {
						$spcc_array = $value['camera'];
						$spcl_array = $value['lens'];
					}
					else {
						$sscc_array = $value['camera'];
						$sscl_array = $value['lens'];
					}
				}
			}
			$data['gpcc_array'] = $gpcc_array;
			$data['gpcl_array'] = $gpcl_array;
			$data['gscc_array'] = $gscc_array;
			$data['gscl_array'] = $gscl_array;
			$data['spcc_array'] = $spcc_array;
			$data['spcl_array'] = $spcl_array;
			$data['sscc_array'] = $sscc_array;
			$data['sscl_array'] = $sscl_array;
		}
		if($page == 'contact-us' && !$this->session->userdata('login') ) {
			redirect(base_url('users/login'));exit();
		}

		$this->load->view('templates/header');
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
	}

	public function numberTowords($num) {

		switch ($num) {
			case 1: return 'ONE ('. $num .')'; break;
			case 2: return 'TWO ('. $num .')'; break;
			case 3: return 'THREE ('. $num .')'; break;
			case 4: return 'FOUR ('. $num .')'; break;
			case 5: return 'FIVE ('. $num .')'; break;
			case 6: return 'SIX ('. $num .')'; break;
			case 7: return 'SEVEN ('. $num .')'; break;
			case 8: return 'EIGHT ('. $num .')'; break;
			case 9: return 'NINE ('. $num .')'; break;
			case 10: return 'TEN ('. $num .')'; break;
		}
	}

	public function get_eligibility_requirements()
    {
        $data['s_camera_products'] = $this->product->get_s_camera_products();
        $data['s_lens_products'] = $this->product->get_s_lens_products();
        $data['g_camera_products'] = $this->product->get_g_camera_products();
        $data['g_lens_products'] = $this->product->get_g_lens_products();
        $criteria = $this->product->get_eligibility_criteria();
        foreach ($criteria as $value) {
            if($value['series'] == 'G') {
                if($value['membership'] == 'Platinum') {
                    $gpcc_array = $value['camera'];
                    $gpcl_array = $value['lens'];
                }
                else {
                    $gscc_array = $value['camera'];
                    $gscl_array = $value['lens'];
                }
            }
            if($value['series'] == 'S') {
                if($value['membership'] == 'Platinum') {
                    $spcc_array = $value['camera'];
                    $spcl_array = $value['lens'];
                }
                else {
                    $sscc_array = $value['camera'];
                    $sscl_array = $value['lens'];
                }
            }
        }
        $data['gpcc_array'] = $gpcc_array;
        $data['gpcl_array'] = $gpcl_array;
        $data['gscc_array'] = $gscc_array;
        $data['gscl_array'] = $gscl_array;
        $data['spcc_array'] = $spcc_array;
        $data['spcl_array'] = $spcl_array;
        $data['sscc_array'] = $sscc_array;
        $data['sscl_array'] = $sscl_array;

        echo json_encode($data);
    }
}
