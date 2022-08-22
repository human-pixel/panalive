<?php
/**
 * Description of Product Model: CodeIgniter
 *
 * @author AcutWeb Team
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_Model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_products() {
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where("active", 1);
        $this->db->order_by('position');
		$query = $this->db->get();
		if($query->result()){
			return $query->result_array();
		}
	}

    public function get_s_camera_products() {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where("active", 1);
        $this->db->where("type", 'Camera');
        $this->db->where("series", 'S');
        $this->db->order_by('position');
        $query = $this->db->get();
        if($query->result()){
            return $query->result_array();
        }
    }

    public function get_s_lens_products() {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where("active", 1);
        $this->db->where("type", 'Lens');
        $this->db->where("series", 'S');
        $this->db->order_by('position');
        $query = $this->db->get();
        if($query->result()){
            return $query->result_array();
        }
    }

    public function get_g_camera_products() {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where("active", 1);
        $this->db->where("type", 'Camera');
        $this->db->where("series", 'G');
        $this->db->order_by('position');
        $query = $this->db->get();
        if($query->result()){
            return $query->result_array();
        }
    }

	public function get_g_lens_products() {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where("active", 1);
        $this->db->where("type", 'Lens');
        $this->db->where("series", 'G');
        $this->db->order_by('position');
        $query = $this->db->get();
        if($query->result()){
            return $query->result_array();
        }
	}

    public function get_eligibility_criteria() {
        $this->db->select("*");
        $this->db->from("eligibility_criteria");
        $this->db->where("status", 1);
        $query = $this->db->get();
        if($query->result()){
            return $query->result_array();
        }
    }
}
