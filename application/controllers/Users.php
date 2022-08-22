<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('User_model');
		$this->load->model('Member_Model');
		$this->load->helper('api_request');
		//include helper methods from controllers
		require_once APPPATH . 'controllers/PANA_helpers.php';
		// User login status
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
	}

	public function check_email(){
		$input = $this->input->post();
		if ($this->Member_Model->check_email_exists($input['email'])) {
			echo 'false';
		}else {
			echo 'true';
		}
	}

	public function check_update_email($id){
		$input = $this->input->post();
		if ($this->Member_Model->check_update_email_exists($input['email'], $id)) {
			echo 'false';
		}else {
			echo 'true';
		}
	}

	// Check Email exists
	public function check_email_exists($email){
		$this->form_validation->set_message('check_email_exists', 'This Email is already registered.');
		if ($this->Member_Model->check_email_exists($email)) {
			return false;
		}else{
			return true;
		}
	}

	// Register User
	public function register(){

		if($this->session->userdata('login')) {
			redirect(base_url('users/dashboard'));
			$this->load->library('user_agent');
			if ($this->agent->is_referral())
			{
			    echo $this->agent->referrer();
			}
		}

		$data['title'] = 'Sign Up';

		$rules = array(
            array(
                'field' => 'salutation',
                'label' => 'salutation',
                'rules' => 'required'
            ),
            array(
                'field' => 'fname',
                'label' => 'first name',
                'rules' => 'required'
            ),
            array(
                'field' => 'fname',
                'label' => 'last name',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required|callback_check_email_exists'
            ),
            array(
                'field' => 'confirmemail',
                'label' => 'email confirmation',
                'rules' => 'required|matches[email]',
                'errors' => array(
                    'required' => '%s must match to email.',
                )
            ),
            array(
                'field' => 'age',
                'label' => 'age',
                'rules' => 'required'
            ),
            array(
                'field' => 'mobile',
                'label' => 'mobile',
                'rules' => 'required'
            ),
             array(
                'field' => 'state',
                'label' => 'state',
                'rules' => 'required'
            ),
              array(
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required'
            ),
               array(
                'field' => 'suburb',
                'label' => 'suburb',
                'rules' => 'required'
            ),
                array(
                'field' => 'postcode',
                'label' => 'post code',
                'rules' => 'required'
            ),
            array(
                'field' => 'mtype',
                'label' => 'membership',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Please select the %s in Select Membership tab',
                )
            )
        );

        $this->form_validation->set_rules($rules);

		$this->load->model('Db_Model');

		if($this->form_validation->run() === FALSE) {

			$this->db->select('*');
			$this->db->where('active', 1);
    		$query = $this->db->get('products');
			$data['products'] = $query->result_array();

			$this->db->select('*');
			$this->db->where('active', 1);
    		$query = $this->db->get('states');
			$data['states'] = $query->result_array();

			$this->load->view('templates/header');
			$this->load->view('users/register', $data);
			$this->load->view('templates/register_script', $data);
			$this->load->view('templates/footer');
		}
		else{
			$this->load->model("Member_Model");

			//Insert member lumix product into database.
			$lumixcam = array_slice($this->input->post('lumixcam'), 0);
			$lumixeligi = array_slice($this->input->post('lumixeligi'), 0);
			$lumixserial = array_slice($this->input->post('lumixserial'), 0);
			$purchase_date = array_slice($this->input->post('purchase_date'), 0);
			$mtype = $this->input->post('mtype');

			$this->db->select('*');
			$this->db->where('active', 1);
			$this->db->where_in('id', $lumixeligi);
    		$query = $this->db->get('products');
			$products = $query->result_array();

			$lumix = $lumix_data = $model__pc = array();

			foreach ($products as $key => $value) {

				$model__pc[] = $value['name'];

				$lumix_data[] = array(
			    	'prod_id' => $value['id'],
			    	'name' => $value['name'],
			    	'type' => $lumixcam[$key],
			    	'series' => $value['series'],
			    	'image' => $value['image'],
			    	'serial_num' => $lumixserial[$key],
			    	'availability' => $value['availability'],
					'purchase_date' => $purchase_date[$key]
				);
			}

			$lumix_count = array_count_values($lumixcam);

			if (!array_key_exists("Camera", $lumix_count)) {
				$lumix_count['Camera'] = 0;
			}
			elseif (!array_key_exists("Lens", $lumix_count)) {
				$lumix_count['Lens'] = 0;
			}

			$lumix_cnt['lumix_count'] = $lumix_count;
			$lumix['lumix'] = $lumix_data;
			$lumix = array_merge($lumix, $lumix_cnt);

			foreach ($lumix_data as $value) {
				$series[] = $value['series'];
			}
			if (count(array_unique($series)) > 1 ) {
				$this->session->set_flashdata("warning", 'The eligibility criteria does not match. Please check the critaria. <a href='.base_url('eligibility').' target="_blank"> here</a>');
                redirect(base_url('users/register'));
			}

			$lumix_detail = serialize($lumix);

			//Insert member personal detail into database.
			$email = $this->input->post('email');
			$state_id = $this->input->post('state');
			$state = $this->Member_Model->get_member_state($state_id);

			if($this->input->post('salutation') == 'mr') {
				$salutation = 'Mr.';
			}
			elseif ($this->input->post('salutation') == 'ms') {
				$salutation = 'Ms.';
			}
			elseif ($this->input->post('salutation') == 'mrs') {
				$salutation = 'Mrs.';
			}

			$age = ($this->input->post('age') == 1) ? TRUE : FALSE;

			$fields_array = array(
				'RecordTypeId' => SF_RECORD_TYPE_ID,
				'Salutation' => $salutation,
				'FirstName' => $this->input->post('fname'),
				'LastName' => $this->input->post('lname'),
				'PersonEmail' => $email,
				'PersonMobilePhone' => $this->input->post('mobile'),
				'BillingStreet' => $this->input->post('address'),
				'BillingState' => $state,
				'BillingPostalCode' => $this->input->post('postcode'),
				'LPS_Website__pc' => $this->input->post('website'),
				'LPS_Facebook__pc' => $this->input->post('fb'),
				'LPS_Instagram__pc' => $this->input->post('insta'),
				'LPS_Youtube__pc' => $this->input->post('youtube'),
				'Are_you_18_years_of_age_or_older__pc' => $age,
				'Product_Selection__pc' => $lumixcam[0],
				"Serial_Number__pc" => $lumixserial[0],
				'Purchase_Date__pc' => $purchase_date[0]
			);

			/* Map the member fileds data to SF helper function */
			$resp_data = api_request(SF_ACCOUNT_URL, $fields_array);

			/* Check if the response is success or failure */
			if($resp_data['success'] == 1) {
				/* Call the SF API's to get the registered memebrs data */
				$sf_account_url = SF_ACCOUNT_URL . $resp_data['id'];
				$sf_result = api_request($sf_account_url, '', 'GET');

				$personal_detail = array(
					'sf_memebr_id' => $sf_result['Id'],
					'title' => $this->input->post('salutation'),
					'first_name' => $this->input->post('fname'),
					'last_name' => $this->input->post('lname'),
					'email' => $email,
					'age' => $this->input->post('age'),
					'mobile' => $this->input->post('mobile'),
					'state_id' => $state_id,
					'state' => $state,
					'address' => $this->input->post('address'),
					'suburb' => $this->input->post('suburb'),
					'postcode' => $this->input->post('postcode'),
					'website' => $this->input->post('website'),
			    	'facebook' => $this->input->post('fb'),
			    	'instagram' => $this->input->post('insta'),
			    	'youtube' => $this->input->post('youtube')
				);

				$personal_detail_serialize = serialize($personal_detail);


				if (count(array_unique($series)) == 1 ) {

					$series = array_unique($series)[0];

					$criteria = $this->Member_Model->add_membership_criteria($mtype);

		    		if(!empty($criteria)){

			        	$m_type = ($criteria->membership == "Platinum") ? 1 : 2;

			        	$membership = array(
							'status' => '',
							'm_ship_num' => $sf_result['Membership_Number__pc'],
							'type' => $m_type,
							'series' => $series,
							'name' => $criteria->membership,
							'price' => $criteria->price,
							'start_date' => '',
							'end_date' => ''
						);
			        }
			        else {
			        	$membership = array(
							'status' => '',
							'm_ship_num' => $sf_result['Membership_Number__pc'],
							'type' => 3,
							'series' => $series,
							'name' => 'Black',
							'price' => '',
							'start_date' => '',
							'end_date' => ''
						);
			        }
			    }
			    else {
		        	$membership = array(
						'status' => '',
						'm_ship_num' => $sf_result['Membership_Number__pc'],
						'type' => 3,
						'series' => implode(", ", $series),
						'name' => 'Black',
						'price' => '',
						'start_date' => '',
						'end_date' => ''
					);
				}

				$membership_detail = serialize($membership);

				$paymentdata = NULL;
				if(!empty($this->input->post('stripeToken'))) {

					//include Stripe PHP library
					require_once APPPATH . "third_party/stripe/init.php";
					\Stripe\Stripe::setApiKey('sk_test_HUHTsTkhUw7EyM2nPQLktzga');
					//add customer to stripe
					$customer = \Stripe\Customer::create(array(
						'email'  => $email,
						'source' => $this->input->post('stripeToken')
					));

					\Stripe\SetupIntent::create([
					  	'customer' => $customer->id
					]);

					$customer_id = array(
						'customer_id'    => $customer->id,
						'payment_status' => 'pending'
					);

					$paymentdata = serialize($customer_id);
				}

				$member_data = array(
			    	'email' 		  => $this->input->post('email'),
			    	'token' 		  => md5(rand(1000, 999999)),
			    	'personal_detail' => $personal_detail_serialize,
			    	'lumix' 		  => $lumix_detail,
			    	'membership' 	  => $membership_detail,
			    	'payment_detail'  => $paymentdata
				);

				$user_id = $this->Db_Model->insert($member_data, 'members');

				if($user_id > 0) {

					$data['member']  = $personal_detail;
					$data['m_lumix'] = $lumix;

					$html = $this->load->view('templates/pdf-template/member-data', $data, true);

					$mpdf = new \Mpdf\Mpdf([
						'mode' => 'utf-8',
						'format' => 'A4',
						'margin_left' => 20,
						'margin_right' => 15,
						'margin_top' => 48,
						'margin_bottom' => 25,
						'margin_header' => 10,
						'margin_footer' => 10
					]);

					$pdfFilePath = "assets/pdf/Member-Record-Copy-".date('Y-m-d')."-".time().".pdf";

					$mpdf->WriteHTML($html);
					$mpdf->Output($pdfFilePath, 'F');

					$email_to = array($this->input->post('email'));
			        $subject = "Thank you, your application has been received";
					$template = $this->load->view('templates/email-template/LPS-application-received', $data['member'], true);
					$record_file = array($pdfFilePath);

			        // Send application received email to member.
	    			PANA_Helpers::pana_send_email($email_to, $subject, $template, $record_file, NULL, NULL);

					// Set Message
					$this->session->set_flashdata('success', 'Thank you for applying. Your application has been received.');
					redirect(base_url('users/thankyou'));
				}
			}
			else{
				//Set Message
				$this->session->set_flashdata('error', 'Member creation failed');
				redirect(base_url('users/register'));
			}
		}
	}

	/******* Member thank you **********/
	public function thankyou() {
		$this->load->view('templates/header');
		$this->load->view('pages/thanks');
		$this->load->view('templates/footer');
	}

	// Register User
	public function set_password($token){

		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');

		$this->load->model('Member_Model');

		$member_token = $this->Member_Model->get_token($token);

		if(empty($member_token)) {

			if($this->session->userdata('login')) {
				redirect(base_url('users/dashboard'));
			}
			else {
				redirect(base_url());
			}
		}
		else {

			if($this->form_validation->run() === FALSE) {

				$data['title'] = 'SET PASSWORD';
				$data['token'] = $member_token;
				// echo"<pre>";print_r($data);die();
				$this->load->view('templates/header');
				$this->load->view('users/set_password', $data);
				$this->load->view('templates/footer');
			}
			else{

				$password = md5($this->input->post('password'));

				$status = $this->db->query("update members set password='".$password."' where token='".$token."'");
				if($status == 1) {

					$this->db->select("email");
					$this->db->from("members");
					$this->db->where("active", "1");
					$this->db->where("token", $token);
					$query = $this->db->get();
					$result = $query->row();
					$email = $result->email;

					// echo"<pre>";print_r($email);die();

					$member = $this->Member_Model->memberLogin($email, $password);
					$membership = unserialize($member->membership);
					$member_data = array(
						'member_id' 	  => $member->id,
		 				'personal_detail' => unserialize($member->personal_detail),
		 				'membership' 	  => $membership,
		 				'member_email' 	  => $member->email,
		 				'login' 		  => true
				 	);

				 	$this->session->set_userdata($member_data);

				 	$this->db->query("update members set token = NULL where email='".$email."'");
				 	redirect(base_url().'users/dashboard');
				}
				else {
					$this->session->set_flashdata('error','invalid password');
					redirect(base_url().'users/set_password');
				}
			}
		}
	}

	/******* Member login**********/
	public function login() {

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'password', 'required');

		// $this->load->model('Db_Model');
		$this->load->model('Member_Model');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/login');
			$this->load->view('templates/footer');
		}
		else{

			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));

			$member_id = $this->Member_Model->memberLogin($email, $password);

			if ($member_id) {
				//Create Session
				$member_data = array(
					'member_id' 	  => $member_id->id,
	 				'personal_detail' => unserialize($member_id->personal_detail),
	 				'membership' 	  => unserialize($member_id->membership),
	 				'member_email' 	  => $member_id->email,
	 				'login' 		  => true
			 	);

			 	$this->session->set_userdata($member_data);

				$this->session->set_flashdata('user_loggedin', 'You are now logged in.');
				redirect(base_url().'users/dashboard');
			}
			else{
				$this->session->set_flashdata('member_error','invalid email and password');
				redirect(base_url().'users/login');
			}
		}
	}
	/*************/
	// log user out
	public function logout(){
		// unset user data
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('member_id');
		$this->session->unset_userdata('member_email');

		//Set Message
		$this->session->set_flashdata('user_loggedout', 'You are logged out.');
		redirect(base_url().'users/login');
	}

	public function email_exist(){
		$input = $this->input->post();
		if ($this->Member_Model->email_exists($input['email'])) {
			echo 'false';
		}else {
			echo 'true';
		}
	}

	// Check Email exists
	public function email_exists($email){
		$this->form_validation->set_message('email_exists', 'This Email is not exist.');
		if ($this->Member_Model->email_exists($email)) {
			return false;
		}else{
			return true;
		}
	}

	//forget password functions start
	public function forget_password_mail(){

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_email_exists');
        if($this->form_validation->run() === FALSE) {
            //$them_pass is the varible to be sent to the user's email
			$this->load->view('templates/header');
			$this->load->view('users/forget_password');
			$this->load->view('templates/footer');
        }
        else{
        	$member_email = $this->input->post('email');
        	$temp_pass['token'] = base64_encode($member_email);
        	$subject = "LPS Memebrs Password Reset";
			$email_contents = $this->load->view('templates/email-template/LPS-forget-password', $temp_pass, true);

			// echo"<pre>";print_r($email_contents);die();

			PANA_Helpers::pana_send_email($member_email, $subject, $email_contents, NULL, NULL, NULL);

			$this->session->set_flashdata('pass_reset','Password reset link has been sent to your email address. Please check your email for instructions, thank you.');
			redirect(base_url().'users/reset-password');
        }
	}

	//forget password functions start
	public function reset_password($token){

		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[password]');

        if($this->form_validation->run() === FALSE) {

        	$data['token'] = $token;
            //$them_pass is the varible to be sent to the user's email
			$this->load->view('templates/header');
			$this->load->view('users/reset_password', $data);
			$this->load->view('templates/footer');
        }
        else{
        	$memberemail = base64_decode($token);
        	$password = md5($this->input->post('password'));
        	$this->db->query("update members set password='".$password."' where email='".$memberemail."'");
			$this->session->set_flashdata('pass_set','Your password has been reset, thank you');
			redirect(base_url().'users/login');
        }
	}

	// return member dashboard.
	public function dashboard(){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$mem_id = $this->session->userdata('member_id');
		$this->load->model("Member_Model");
		$data['mem_id'] = $mem_id;

		$pt_detail = $this->Member_Model->get_member_payment_detail($mem_id);
		$offers = $this->Member_Model->get_member_offer_detail($mem_id);
		$membership = $this->Member_Model->get_member_membership_detail($mem_id);

		$data['m_detail'] = $membership;
		$data['pmt_detail'] = $pt_detail;

		$data['offer_msg'] = PANA_Helpers::display_membership_messages($pt_detail, $membership, $offers);

		// echo"<pre>";print_r($data);die();
		// echo"<pre>";print_r($data);die();
        if($this->Member_Model->is_expired($this->session->userdata('member_email'))) {
            $this->session->set_flashdata('expired_plan', " (Expired)");
        }
		$this->load->view('administrator/header-script');
		$this->load->view('templates/new-header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('users/dashboard', $data);
		$this->load->view('administrator/footer');
	}

	// return member profile.
	public function member_profile(){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$mem_id = $this->session->userdata('member_id');
		$this->load->model("Member_Model");

		$data['heading'] = 'Profile';

		$this->db->select("id, active, created_at");
		$this->db->from("members");
		$this->db->where("id", $mem_id);
		$query = $this->db->get();
		$member = $query->row_array();
		$data['member'] = $member;

		$data['mem_id'] = $mem_id;
		$data['p_detail'] = $this->Member_Model->get_member_personal_detail($mem_id);
		$data['m_detail'] = $this->Member_Model->get_member_membership_detail($mem_id);
		$data['ofr_detail'] = $this->Member_Model->get_member_offer_detail($mem_id);
		$data['pt_detail'] = $this->Member_Model->get_member_payment_detail($mem_id);

		$message['offer_msg'] = PANA_Helpers::display_membership_messages($data['pt_detail'], $data['m_detail'], $data['ofr_detail']);

		$this->db->select('*');
		$this->db->where('active', 1);
		$query = $this->db->get('states');
		$data['states'] = $query->result_array();

		$this->load->model("Work_Type_Model");
		$data['works'] = $this->Work_Type_Model->get_work_types();
		$this->load->model("Specialization_Model");
		$data['fields'] = $this->Specialization_Model->get_specialise_fields();

		// echo"<pre>";print_r($data);die();


		$this->load->view('administrator/header-script');
		$this->load->view('templates/new-header');
		$this->load->view('templates/sidebar', $message);
		$this->load->view('users/profile', $data);
		$this->load->view('users/profile-script');
		$this->load->view('administrator/footer');
	}

	// Update member personal info .
	public function update_member_personal_info() {
        if (!$this->session->userdata('login')) {
            redirect(site_url('users/login'));
        }

        $mem_id = $this->uri->segment(4);
        $mem_id = base64_decode($mem_id);

        if (empty($mem_id)) { show_404(); }

        $this->load->model('Db_Model');
        $this->load->model('Member_Model');
        // Personal detail validation
        $this->form_validation->set_rules('salutation', 'Title', 'required');
		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[members.id !='.$mem_id.' and '.'email=]');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required');

		$personal_info = $this->Member_Model->get_member_personal_detail($mem_id);

        if ($this->form_validation->run() === FALSE) {

        	$data['heading'] = 'Profile';

			$this->db->select("id, active, created_at");
			$this->db->from("members");
			$this->db->where("id", $mem_id);
			$query = $this->db->get();
			$member = $query->row_array();
			$data['member'] = $member;

			$data['mem_id'] = $mem_id; $data['current_date'] = date("d-m-Y H:i:s");
			$data['p_detail'] = $personal_info;
			$data['w_detail'] = $this->Member_Model->get_member_work_detail($mem_id);
			$data['m_detail'] = $this->Member_Model->get_member_membership_detail($mem_id);
			$data['ofr_detail'] = $this->Member_Model->get_member_offer_detail($mem_id);
			$data['pt_detail'] = $this->Member_Model->get_member_payment_detail($mem_id);

			$message['offer_msg'] = PANA_Helpers::display_membership_messages($data['pt_detail'], $data['m_detail'], $data['ofr_detail']);

			$this->db->select('*');
			$this->db->where('active', 1);
			$query = $this->db->get('states');
			$data['states'] = $query->result_array();

			$this->load->model("Work_Type_Model");
			$data['works'] = $this->Work_Type_Model->get_work_types();
			$this->load->model("Specialization_Model");
			$data['fields'] = $this->Specialization_Model->get_specialise_fields();

        	$this->load->view('administrator/header-script');
			$this->load->view('templates/new-header');
			$this->load->view('templates/sidebar');
			$this->load->view('users/profile', $data);
			$this->load->view('administrator/footer');
        }
        else {

            $email = $this->input->post('email');
            $state_id = $this->input->post('state');
            $state = $this->Member_Model->get_member_state($state_id);
			// Update member personal detail into database.
			$personal_detail = array(
				'sf_memebr_id' => $personal_info['sf_memebr_id'],
				'title' => $this->input->post('salutation'),
				'first_name' => $this->input->post('fname'),
				'last_name' => $this->input->post('lname'),
				'email' => $email,
				'age' => $personal_info['age'],
				'mobile' => $this->input->post('mobile'),
				'state_id' => $state_id,
				'state' => $state,
				'address' => $this->input->post('address'),
				'suburb' => $this->input->post('suburb'),
				'postcode' => $this->input->post('postcode'),
				'website' => $this->input->post('website'),
		    	'facebook' => $this->input->post('fb'),
		    	'instagram' => $this->input->post('insta'),
		    	'youtube' => $this->input->post('youtube')
			);

	        // echo"<pre>";print_r($personal_detail);die();

			$member_data = array(
				'email' 		  => $email,
		    	'personal_detail' => serialize($personal_detail)
			);

			// echo"<pre>";print_r($member_data);die();

        	$update_status = $this->Db_Model->update($mem_id, $member_data, 'members');

        	if($update_status == 1) {
        		$m_detail = $this->session->userdata('personal_detail');
				$sf_account_url = SF_ACCOUNT_URL . $m_detail['sf_memebr_id'];

				if($this->input->post('salutation') == 'mr') {
					$salutation = 'Mr.';
				}
				elseif ($this->input->post('salutation') == 'ms') {
					$salutation = 'Ms.';
				}
				elseif ($this->input->post('salutation') == 'mrs') {
					$salutation = 'Mrs.';
				}
				$sf_personal_detail = array(
					'RecordTypeId' => SF_RECORD_TYPE_ID,
					'Salutation' => $salutation,
					'FirstName' => $this->input->post('fname'),
					'LastName' => $this->input->post('lname'),
					'PersonEmail' => $email,
					'PersonMobilePhone' => $this->input->post('mobile'),
					'BillingStreet' => $this->input->post('address'),
					'BillingState' => $state,
					'BillingPostalCode' => $this->input->post('postcode'),
					// 'Are_you_18_years_of_age_or_older__pc' => $personal_info['age'],
					'LPS_Website__pc' => $this->input->post('website'),
					'LPS_Facebook__pc' => $this->input->post('fb'),
					'LPS_Instagram__pc' => $this->input->post('insta'),
					'LPS_Youtube__pc' => $this->input->post('youtube')
				);

				api_request($sf_account_url, $sf_personal_detail, 'PATCH');

				$this->session->set_flashdata('success', 'The fields are updated.');
        	}
			else {
        		$this->session->set_flashdata('error', 'Opps! Something went wrong.');
			}
            redirect(base_url('users/profile'));
        }
    }

    // Update member work detail .
	public function update_member_work_detail() {
        if (!$this->session->userdata('login')) {
            redirect(site_url('users/login'));
        }

        $mem_id = $this->uri->segment(4);
        $mem_id = base64_decode($mem_id);

        if (empty($mem_id)) { show_404(); }

        $this->load->model('Db_Model');
        $this->load->model('Member_Model');

        //Insert member work detail into database.
	    $type_of_works = $this->input->post('work_type');
	    $other_work = $this->input->post('other_work');
	    $field_specialise = $this->input->post('field_specialise');
	    $other_fs = $this->input->post('other_fs');

	    // echo"<pre>";print_r($type_of_works);die();

	    $work_types = array();
	    foreach ($type_of_works as $wvalue) {
	    	if($wvalue == 'Other') {
	    		$work_types[] = $other_work;
	    		$work_types[] = $wvalue;
	    	}
	    	else {
	    		$work_types[] = $wvalue;
	    	}
	    }
	    $specialises = array();
	    foreach ($field_specialise as $svalue) {
	    	if($svalue == 'Other') {
	    		$specialises[] = $other_fs;
	    		$specialises[] = $svalue;
	    	}
	    	else {
	    		$specialises[] = $svalue;
	    	}
	    }

	    $work_detail = array(
	    	'type_of_work' => serialize($work_types),
	    	'other_work' => $other_work,
	    	'specialise_in' => serialize($specialises),
	    	'other_fs' => $other_fs,
	    	'comment' => str_replace("'", "`", $this->input->post('comment'))
		);

        // echo"<pre>";print_r($work_detail);die();

		$member_data = array(
	    	'work_detail' => serialize($work_detail)
		);

		// echo"<pre>";print_r($member_data);die();
    	$update_status = $this->Db_Model->update($mem_id, $member_data, 'members');

    	// echo"<pre>";print_r($update_status);die();

    	if($update_status == 1) {

    		$photography = $videography = $tw_other = FALSE;

    		foreach ($type_of_works as $wvalue) {
		    	if($wvalue == 'Photography') {
		    		$photography = TRUE;
		    	}
		    	elseif($wvalue == 'Videography') {
		    		$videography = TRUE;
		    	}
		    	elseif($wvalue == 'Other') {
		    		$tw_other = TRUE;
		    	}
		    }

		    $studio_commercial = $wedding = $events = $photo_journalism = $sports = $media_press = $fashion = $landscapes = $portrait = $nature_wildlife = $real_estate = $documentary = $sfs_oher = FALSE;

		    foreach ($field_specialise as $svalue) {

		    	if($svalue == 'Studio/Commercial') {
		    		$studio_commercial = TRUE;
		    	}
		    	elseif($svalue == 'Wedding') {
		    		$wedding = TRUE;
		    	}
		    	elseif($svalue == 'Events') {
		    		$events = TRUE;
		    	}
		    	elseif($svalue == 'Photo Journalism') {
		    		$photo_journalism = TRUE;
		    	}
		    	elseif($svalue == 'Sports') {
		    		$sports = TRUE;
		    	}
		    	elseif($svalue == 'Media/Press') {
		    		$media_press = TRUE;
		    	}
		    	elseif($svalue == 'Fashion') {
		    		$fashion = TRUE;
		    	}
		    	elseif($svalue == 'Landscapes') {
		    		$landscapes = TRUE;
		    	}
		    	elseif($svalue == 'Portrait') {
		    		$portrait = TRUE;
		    	}
		    	elseif($svalue == 'Nature/Wildlife') {
		    		$nature_wildlife = TRUE;
		    	}
		    	elseif($svalue == 'Real Estate') {
		    		$real_estate = TRUE;
		    	}
		    	elseif($svalue == 'Documentary') {
		    		$documentary = TRUE;
		    	}
		    	elseif($svalue == 'Other') {
		    		$sfs_oher = TRUE;
		    	}
		    }

		    $m_detail = $this->session->userdata('personal_detail');
			$sf_account_url = SF_ACCOUNT_URL . $m_detail['sf_memebr_id'];

		    $sf_work_detail = array(
				'RecordTypeId' => SF_RECORD_TYPE_ID,
				'Photography__pc' => $photography,
				'Videography__pc' => $videography,
				'Other__pc' => $tw_other,
				'Studio_Commercial__pc' => $studio_commercial,
				'Wedding__pc' => $wedding,
				'Events__pc' => $events,
				'Portrait__pc' => $portrait,
				'Media_Press__pc' => $media_press,
				'Photo_Journalist__pc' => $photo_journalism,
				'Sports__pc' => $sports,
				'Fashion__pc' => $fashion,
				'Real_Estate__pc' => $real_estate,
				'Nature_Wildlife__pc' => $nature_wildlife,
				'Landscape__pc' => $landscapes,
				'Documentary__pc' => $documentary,
				'Other2__pc' => $sfs_oher,
				'Other3__pc' => $this->input->post('other_fs'),
				'LPS_member_describe_self__pc' => str_replace("'", "`", $this->input->post('comment'))
			);

			api_request($sf_account_url, $sf_work_detail, 'PATCH');

    		$this->session->set_flashdata('success', 'The fields are updated.');
    	}
		else {
    		$this->session->set_flashdata('error', 'Opps! Something went wrong.');
		}
        redirect(base_url().'users/profile');
    }

    // Lists member sensor clean vouchers
    public function sensor_clean_vouchers(){

    	if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$member_id = $this->session->userdata('member_id');
		$this->db->select('*');
		$this->db->where('member_id', $member_id);
		$query = $this->db->get('sensor_clean_vouchers');
		$data['vouchers'] = $query->result();
		$data['m_ship'] = $this->Member_Model->get_member_membership_detail($member_id);
		// echo"<pre>";print_r($data);die();

		$this->load->view('administrator/header-script');
		$this->load->view('templates/new-header');
		$this->load->view('templates/sidebar');
        if($this->Member_Model->is_expired($this->session->userdata('member_email'))) {
            $this->session->set_flashdata('expired', "<a href=\'#renew'>Renew your membership</a> to access this feature.");
        } else {
            $this->load->view('users/forms/sensor-clean', $data);
        }

		$this->load->view('administrator/footer');
	}

	//  Download sensor clean voucher
    public function download_sensor_clean_voucher($v_no){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}
		//load the download helper
        $this->load->helper('download');

        //set the textfile's name
        $this->db->select('sc_voucher');
		$this->db->where('voucher_no', $v_no);
		$query = $this->db->get('sensor_clean_vouchers');
		$result = $query->row();
		$sc_voucher = $result->sc_voucher;

        //use this function to force the session/browser to download the created file
        force_download($sc_voucher, NULL);
	}

	// Self email sensor clean voucher
    public function self_mail_sensor_clean_voucher($v_no){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}
		$to_email = $this->session->userdata('member_email');
        //set the textfile's name
        $this->db->select('sc_voucher');
		$this->db->where('voucher_no', $v_no);
		$query = $this->db->get('sensor_clean_vouchers');
		$result = $query->row();
		$sc_voucher = array($result->sc_voucher);

        $subject = "LPS Sensor Clean Voucher";
		PANA_Helpers::pana_send_email($to_email, $subject, NULL, $sc_voucher, NULL, NULL);

		$this->session->set_flashdata('success', 'The voucher has been sent to your email address. Thank you.');
		redirect(base_url('users/sensor-clean'));
	}

	// Member general enquiry form
    public function general_enquiry(){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$member_id = $this->session->userdata('member_id');
		$this->load->model('Db_Model');
		$this->load->model("Member_Model");
		$data['member_id'] = $member_id;

		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[members.id !='.$member_id.' and '.'email=]');
		$this->form_validation->set_rules('enquiry_text', 'Enquiry Detail', 'required|max_length[350]');

		$m_ship = $this->Member_Model->get_member_membership_detail($member_id);
		$data['m_ship'] = $m_ship;

		if ($this->form_validation->run() === FALSE) {

			$data['p_detail'] = $this->Member_Model->get_member_personal_detail($member_id);

			// echo"<pre>";print_r($data['product']);die();

			$this->load->view('administrator/header-script');
			$this->load->view('templates/new-header');
			$this->load->view('templates/sidebar');
            if($this->Member_Model->is_expired($this->session->userdata('member_email'))) {
                $this->session->set_flashdata('expired', "<a href=\'#renew'>Renew your membership</a> to access this feature.");
            } else {
                $this->load->view('users/forms/enquiry-form', $data);
            }
			// $this->load->view('templates/enquiry_script');
			$this->load->view('administrator/footer');
		}
		else {

			$member_name = $this->input->post('fname');
			$member_email = $this->input->post('email');

			$enquiries = array(
		    	'member_id' => $member_id,
		    	'membership' => $m_ship['m_ship_num'],
		    	'fname' => $this->input->post('fname'),
		    	'lname' => $this->input->post('lname'),
		    	'email' => $member_email,
		    	'enquiry_text' => $this->input->post('enquiry_text')
			);

			// echo"<pre>";print_r($enquiries);die();

			$enquiry_id = $this->Db_Model->insert($enquiries, 'enquiries');

			if($enquiry_id > 0) {
				$to_email = array('LPS@au.panasonic.com');
				$subject = "IMPORTANT: LPS Member General Enquiry";
				$email_contents = $this->load->view('templates/email-template/LPS-general-enquiry-for-internal', $enquiries, true);
				PANA_Helpers::pana_send_email($to_email, $subject, $email_contents, NULL, NULL, NULL);

				//Set Message
				$this->session->set_flashdata('success', 'Your enquiry has been submitted successfully and a LUMIX Professional Services representative will be in touch shortly. Thank you.');
			}
			else{
				//Set Message
				$this->session->set_flashdata('error', 'Opps! something went wrong.');
			}
			redirect(base_url('users/enquiry'));
		}
	}

	// Validation callback function for purchase proof.
	public function purchase_proof($model_num) {

	   	$lumix_detail = $this->Member_Model->get_member_lumix_detail($this->session->userdata('member_id'));

	   	foreach ($lumix_detail['lumix'] as $lumix) {
			if($lumix['name'] == $model_num) {
				if(array_key_exists('proof_of_purchase', $lumix)) {
					return TRUE;
				}
				else
				{
					$this->form_validation->set_message('purchase_proof', "No proof of purchase found. Please uploaded proof of purchase for ".$lumix['name']);
					return FALSE;
				}
			}
		}
	}

	// Member general wnquiry form
    public function book_a_repair(){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$member_id = $this->session->userdata('member_id');
		$this->load->model('Db_Model');
		$this->load->model("Member_Model");
		$data['member_id'] = $member_id;

		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('membership_num', 'Membership Number', 'required');
		$this->form_validation->set_rules('streetaddr', 'Street Address', 'required');
		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[members.id !='.$member_id.' and '.'email=]');
		$this->form_validation->set_rules('model_num', 'Model Number', 'required|callback_purchase_proof');
		$this->form_validation->set_rules('serial_num', 'Serial Number', 'required');
		$this->form_validation->set_rules('fault_report', 'Fault Report', 'required');
		$this->form_validation->set_rules('req_terms', 'Terms & Condition', 'required');

		$request_type_array = array(
			array('value' => '1','type' => 'In Warranty'),
			array('value' => '2','type' => 'Out of Warranty'),
			array('value' => '3','type' => 'Extended Warranty'),
			array('value' => '4','type' => 'Non Manufacturing Fault')
		);

		$m_ship = $this->Member_Model->get_member_membership_detail($member_id);
		$data['m_ship'] = $m_ship;

		$lumix_detail = $this->Member_Model->get_member_lumix_detail($member_id);

		if ($this->form_validation->run() === FALSE) {

			$data['request_types'] = $request_type_array;

			$data['p_detail'] = $this->Member_Model->get_member_personal_detail($member_id);

			$this->db->select('*');
			$this->db->where('active', 1);
			$this->db->where('availability', 1);
    		$query = $this->db->get('products');
			$prods = $query->result_array();

			$prod_array = array();
			foreach ($lumix_detail['lumix'] as $lumix) {
				foreach ($prods as $prod) {
					if (in_array($lumix['name'], $prod)) {
						$prod_array[] = $lumix;
					}
				}
			}

			$data['product'] = array_filter($prod_array);

			$this->db->select('*');
			$this->db->where('active', 1);
    		$query = $this->db->get('states');
			$data['states'] = $query->result_array();

			// $query = $this->db->query("select * from stores where active = 1 and availability != 2");
			// $data['stores'] = $query->result_array();

			// echo"<pre>";print_r($data);die();

			$this->load->view('administrator/header-script');
			$this->load->view('templates/new-header');
			$this->load->view('templates/sidebar');
            if($this->Member_Model->is_expired($this->session->userdata('member_email'))) {
                $this->session->set_flashdata('expired', "<a href=\'#renew'>Renew your membership</a> to access this feature.");
            } else {
                $this->load->view('users/forms/repair-form', $data);
            }
			$this->load->view('administrator/footer');
		}
		else {
			$state_id = $this->input->post('state');

			$this->db->select('name');
			$this->db->where('id', $state_id);
			$this->db->where('active', 1);
    		$query = $this->db->get('states');
    		$result = $query->row();
		    $state_name = $result->name;

			$personal_detail = array(
		    	'member_id' => $member_id,
		    	'company' => $this->input->post('company'),
		    	'reference_number' => $this->input->post('ref_number'),
		    	'fname' => $this->input->post('fname'),
		    	'lname' => $this->input->post('lname'),
		    	'membership_number' => $this->input->post('membership_num'),
		    	'street_address' => $this->input->post('streetaddr'),
		    	'suburb' => $this->input->post('suburb'),
				'postcode' => $this->input->post('postcode'),
				'state' => $state_name,
				'state_id' => $state_id
			);

			// echo"<pre>";print_r($personal_detail);die();

			$s_state_id = $this->input->post('shipping_state');

			$this->db->select('name');
			$this->db->where('active', 1);
			$this->db->where('id', $s_state_id);
    		$query1 = $this->db->get('states');
    		$result1 = $query1->row();
		    $s_state_name = $result1->name;

			$return_addr = array(
		    	'shipping_suburb' => $this->input->post('shipping_suburb'),
				'shipping_postcode' => $this->input->post('shipping_postcode'),
				'shipping_state' => $s_state_name,
				'shipping_state_id' => $this->input->post('shipping_state'),
				'shipping_address' => $this->input->post('shipping_addr'),
			);

			// echo"<pre>";print_r($return_addr);die();

			$member_email = $this->input->post('email');
			$request_type = $this->input->post('request_type');

			foreach ($request_type_array as $value) {
				if($value['value'] == $request_type) {
					$request_type_name = $value['type'];
				}
			}
			$repair_detail = array(
		    	'request_type' => $request_type,
		    	'request_type_name' => $request_type_name,
		    	'email' => $member_email,
		    	'mobile' => $this->input->post('mobile'),
		    	'model_num' => $this->input->post('model_num'),
		    	'serial_num' => $this->input->post('serial_num'),
		    	'fault_report' => $this->input->post('fault_report')
			);
			// echo"<pre>";print_r($repair_detail);die();

			$populate_detail_in_email = array(
		    	'personal_detail' => $personal_detail,
		    	'return_addrress' => $return_addr,
		    	'repair_detail' => $repair_detail
			);

			$book_a_repairs = array(
		    	'personal_detail' => serialize($personal_detail),
		    	'return_addrress' => serialize($return_addr),
		    	'repair_detail' => serialize($repair_detail)
			);

			// echo"<pre>";print_r($book_a_repairs);die();

			$enquiry_id = $this->Db_Model->insert($book_a_repairs, 'book_a_repairs');

			if($enquiry_id > 0) {
    			/*===============================================================================*/
				// To Tecworks & LPS Internal
				// $email_to_internal = array($member_email);
				// $internal_subject = "LPS Member Book-A-Repair Submission";
				// $internal_email_template = $this->load->view('templates/email-template/LPS-book-a-repair-for-internal', $populate_detail_in_email, true);
				// PANA_Helpers::pana_send_email($email_to_internal, $internal_subject, $internal_email_template, NULL, NULL, NULL);

    			/*===============================================================================*/
				// To LPS Members
				$email_to_member = array($member_email);
		        $member_subject = "Your LPS repair request is submitted";
		        $member_email_template = $this->load->view('templates/email-template/LPS-book-a-repair-for-member', $populate_detail_in_email, true);
    			PANA_Helpers::pana_send_email($email_to_member, $member_subject, $member_email_template, NULL, NULL, NULL);
    			/*===============================================================================*/

				//Set Message
				$this->session->set_flashdata('success', 'Your repair request has been submitted successfully. For your records, a copy has been sent to your email address. Thank you.');
				redirect(base_url('users/thankyou'));
			}
			else{
				//Set Message
				$this->session->set_flashdata('error', 'Opps! something went wrong.');
				redirect(base_url('users/repair'));
			}
		}
	}

	// a coupon code apply by the loggedin member.
	public function get_lumix_serial_number() {

		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$model_num = $this->input->post();

		if($model_num['model_num'] != '') {
			$member_id = $this->session->userdata('member_id');
			$lumix_detail = $this->Member_Model->get_member_lumix_detail($member_id);
			foreach ($lumix_detail['lumix'] as $lumix) {
				if ($lumix['name'] == $model_num['model_num']) {
					$serial_num = $lumix['serial_num'];
				}
			}
			echo '<option value="'.$serial_num.'" selected>'.$serial_num.'</option>';
		}
		else {
			echo '<option value="" selected>Please Select Serial Number*</option>';
		}
	}

	// Member general wnquiry form
    public function trial_loan(){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$member_id = $this->session->userdata('member_id');
		$this->load->model('Db_Model');
		$this->load->model("Member_Model");
		$data['member_id'] = $member_id;

		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('m_ship_number', 'Membership Number', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[members.id !='.$member_id.' and '.'email=]');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
		$this->form_validation->set_rules('store', 'Store', 'required');
		$this->form_validation->set_rules('equipment_req[]', 'Loan Equipment Request', 'required');
		$data['m_ship'] = $this->Member_Model->get_member_membership_detail($member_id);
		$mp_detail = $this->Member_Model->get_member_personal_detail($member_id);

		$this->db->select('*');
		$this->db->where('active', 1);
		$this->db->where('availability', 1);
		$query = $this->db->get('products');
		$data['products'] = $query->result_array();

		if ($this->form_validation->run() === FALSE) {

			$data['p_detail'] = $mp_detail;

			$query = $this->db->query("select * from stores where active = 1 and availability != 1");
			$data['stores'] = $query->result_array();

			// echo"<pre>";print_r($data['products']);die();

			$this->load->view('administrator/header-script');
			$this->load->view('templates/new-header');
			$this->load->view('templates/sidebar');
            if($this->Member_Model->is_expired($this->session->userdata('member_email'))) {
                $this->session->set_flashdata('expired', "<a href=\'#renew'>Renew your membership</a> to access this feature.");
            } else {
                $this->load->view('users/forms/loan-form', $data);
            }

			// $this->load->view('templates/enquiry_script');
			$this->load->view('administrator/footer');
		}
		else {

			$member_email = $this->input->post('email');
			$store_id = $this->input->post('store');
			$equipment_req = $this->input->post('equipment_req');

			// echo"<pre>";print_r(count($equipment_req));die();
			$ms = substr($data['m_ship']['name'], 0, 1);
			$i = 1;
			foreach ($equipment_req as $value) {

				$tl_voucher_no = ($i == 1 ) ? 'TL01'.$member_id.'500'.$member_id.'-1'. $ms : 'TL02'.$member_id.'500'.$member_id.'-2'. $ms;

				// echo"<pre>";print_r($trail_loans);die();
				$enquiry_id = $this->db->query("UPDATE trail_loans SET store_id = '".$store_id."', lname = '".$this->input->post('lname')."', mobile = '".$this->input->post('mobile')."', equipment_req = '".$value."' WHERE member_id = '".$member_id."' AND loan_voucher_no='".$tl_voucher_no."' AND active = 1");
				$i++;
			}

			// echo"<pre>";print_r($trail_loans);die();
			$rd_password = $this->randomPassword();
			$trail_loans = array(
		    	'member_id' => $member_id,
		    	'store_id' => $store_id,
		    	'membership' => $this->input->post('m_ship_number'),
		    	'fname' => $this->input->post('fname'),
		    	'lname' => $this->input->post('lname'),
		    	'email' => $member_email,
		    	'mobile' => $this->input->post('mobile'),
				'equipment_req' => $value,
				'tl_voucher_pass' => $rd_password
			);

			$this->db->select('name');
			$this->db->where_in('id', $equipment_req);
    		$pd_query = $this->db->get('products');
			$pd_result = $pd_query->result_array();

			foreach ($pd_result as $pd_value) {
				$pd_name[] = $pd_value;
			}

			if($enquiry_id > 0) {

				$mp_detail_update = array(
					'sf_memebr_id' => $mp_detail['sf_memebr_id'],
					'title' => $mp_detail['title'],
					'first_name' => $mp_detail['first_name'],
					'last_name' => $mp_detail['last_name'],
					'email' => $mp_detail['email'],
					'age' => $mp_detail['age'],
					'mobile' => $mp_detail['mobile'],
					'state_id' => $mp_detail['state_id'],
					'state' => $mp_detail['state'],
					'address' => $mp_detail['address'],
					'suburb' => $mp_detail['suburb'],
					'postcode' => $mp_detail['postcode'],
					'website' => $mp_detail['website'],
			    	'facebook' => $mp_detail['facebook'],
			    	'instagram' => $mp_detail['instagram'],
			    	'youtube' => $mp_detail['youtube'],
			    	'v_password' => md5($rd_password)
				);

				$this->db->query("UPDATE members SET personal_detail = '".serialize($mp_detail_update)."' WHERE id = '".$member_id."'");

				$this->db->select('contact_name, email');
				$this->db->where('id', $store_id);
	    		$st_query = $this->db->get('stores');
				$st_result = $st_query->row_array();
				$store_name['store_name'] = $st_result['contact_name'];
				$store_email = 'test5082799@gmail.com';
				$product_name['product'] = $pd_name;

				$populate_trail_loans = array_merge($trail_loans, $store_name, $product_name);

				/*=================================================================================*/
    			// To Tecworks & LPS Internal
				$email_to_internal = array($store_email);
				$internal_subject = "LPS Member Product Evaluation Loan Submission";
				$internal_email_template = $this->load->view('templates/email-template/LPS-trial-loan-for-internal', $populate_trail_loans, true);

				// echo"<pre>";print_r($internal_email_template);die();

				PANA_Helpers::pana_send_email($email_to_internal, $internal_subject, $internal_email_template, NULL, NULL, NULL);

				/*=================================================================================*/
				// To LPS Members
				$email_to_member = array($member_email);
				$member_subject = "Your LPS product evaluation loan request is submitted";
				$member_email_template = $this->load->view('templates/email-template/LPS-trial-loan-for-member', $populate_trail_loans, true);
				PANA_Helpers::pana_send_email($email_to_member, $member_subject, $member_email_template, NULL, NULL, NULL);
				/*=================================================================================*/

				//Set Message
				$this->session->set_flashdata('success', 'Your Product Evaluation Loan Request has been submitted successfully. For your records, a copy has been sent to your email address. Thank you.');
				redirect(base_url('users/loan'));
			}
			else{
				//Set Message
				$this->session->set_flashdata('error', 'Opps! something went wrong.');
				redirect(base_url('users/loan'));
			}
		}
	}

	// support function to aoto generate password
    public function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	// Lists member trial loan vouchers
    public function trial_loan_vouchers(){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}

		$member_id = $this->session->userdata('member_id');
		$this->db->select('*');
		$this->db->where('member_id', $member_id);
		$query = $this->db->get('trail_loans');
		$data['loan_requests'] = $query->result();
		$data['m_ship'] = $this->Member_Model->get_member_membership_detail($member_id);

		// echo"<pre>";print_r($data);die();
		$this->load->view('administrator/header-script');
		$this->load->view('templates/new-header');
		$this->load->view('templates/sidebar');
        if($this->Member_Model->is_expired($this->session->userdata('member_email'))) {
            $this->session->set_flashdata('expired', "<a href=\'#renew'>Renew your membership</a> to access this feature.");
        } else {
            $this->load->view('users/forms/loan-voucher', $data);
        }
		$this->load->view('administrator/footer');
	}

	// Download trial loan voucher
    public function download_loan_voucher($v_no){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}
		//load the download helper
        $this->load->helper('download');

        //set the textfile's name
        $this->db->select('tl_voucher');
		$this->db->where('loan_voucher_no', $v_no);
		$query = $this->db->get('trail_loans');
		$result = $query->row();
		$tl_voucher = $result->tl_voucher;

        //use this function to force the session/browser to download the created file
        force_download($tl_voucher, NULL);
	}

	// Self email trial loan voucher
    public function self_mail_loan_voucher($v_no){
		if(!$this->session->userdata('login')) {
			redirect(base_url('users/login'));
		}
		$to_email = $this->session->userdata('member_email');

        //set the textfile's name
        $this->db->select('tl_voucher');
		$this->db->where('loan_voucher_no', $v_no);
		$query = $this->db->get('trail_loans');
		$result = $query->row();
		$tl_voucher = array($result->tl_voucher);

        $subject = "LPS Product Evaluation Loan Voucher";
		PANA_Helpers::pana_send_email($to_email, $subject, NULL, $tl_voucher, NULL, NULL);

		$this->session->set_flashdata('success', 'The voucher has been sent to your email address. Thank you.');
		redirect(base_url('users/loan-voucher'));
	}

	// Validation callback function for trial loan voucher
	public function _check_voucher_password($voucher_pass, $mem_id) {

        $m_detail = $this->Member_Model->get_member_personal_detail($mem_id);

		if(md5($voucher_pass) == $m_detail['v_password']) {
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_check_voucher_password', "Password does not match. Please enter valid password");
			return FALSE;
		}
	}

	// varify voucher password before submit voucher
	public function voucher_password($mem_id){

        $mem_id = base64_decode($mem_id);

        $this->db->select('tl_voucher_pass');
		$this->db->where('member_id', $mem_id);
		$query = $this->db->get('trail_loans');
		$result = $query->row_array();
		$tl_voucher_pass = $result['tl_voucher_pass'];

		if($tl_voucher_pass == '') {

	        $data['mem_id'] = $mem_id;

	        $this->form_validation->set_rules('voucher_pass', 'voucher number', 'required|callback__check_voucher_password['.$mem_id.']');

			if ($this->form_validation->run() === FALSE) {
		        $this->load->view('templates/header');
				$this->load->view('users/forms/voucher_password', $data);
				$this->load->view('templates/footer');
			}
			else {
				$voucher_pass = $this->input->post('voucher_pass');

				// echo"<pre>";print_r($voucher_pass);die();

				$this->db->query("UPDATE trail_loans SET tl_voucher_pass = '".md5($voucher_pass)."' WHERE member_id = '".$mem_id."'");

				$this->db->query("UPDATE sensor_clean_vouchers SET sc_voucher_pass = '".md5($voucher_pass)."' WHERE member_id = '".$mem_id."'");

				redirect(base_url('users/submit-voucher/'.base64_encode($mem_id)));
			}
		}
		else {
			redirect(base_url('users/submit-voucher/'.base64_encode($mem_id)));
		}

	}

	// Validation callback function for trial loan voucher
	public function _check_tl_voucher($voucher_no, $m_id) {

        $this->db->select('loan_voucher_no');
		$this->db->where('loan_voucher_no', $voucher_no);
		$this->db->where('member_id', $m_id);
		$this->db->where('equipment_req !=', '');
		$query = $this->db->get('trail_loans');
		$result = $query->row_array();
		$vc_no = $result['loan_voucher_no'];

		if($voucher_no == $vc_no) {
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_check_tl_voucher', "Voucher is not valid. please enter valid voucher");
			return FALSE;
		}
	}

	// Validation callback function for sensor clean voucher
	public function _check_sc_voucher($voucher_no, $m_id) {

        $this->db->select('voucher_no');
		$this->db->where('voucher_no', $voucher_no);
		$this->db->where('member_id', $m_id);
		$query = $this->db->get('sensor_clean_vouchers');
		$result = $query->row_array();
		$vc_no = $result['voucher_no'];

		if($voucher_no == $vc_no) {
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_check_sc_voucher', "Voucher is not valid. please enter valid voucher");
			return FALSE;
		}
	}

	public function submit_member_voucher($mem_id){

        $mem_id = base64_decode($mem_id);

        $this->db->select('tl_voucher_pass');
		$this->db->where('member_id', $mem_id);
		$query = $this->db->get('trail_loans');
		$result = $query->row_array();
		$tl_voucher_pass = $result['tl_voucher_pass'];

		// echo"<pre>";print_r($tl_voucher_pass);die();

		if(!'' == $tl_voucher_pass) {
        $data['mem_id'] = $mem_id;

	        $voucher_type = $this->input->post('voucher_type');

	        $this->form_validation->set_rules('voucher_type', 'voucher type', 'required');

	        // echo"<pre>";print_r($voucher_type);die();

	        if($voucher_type == 1) {
	        	$this->form_validation->set_rules('voucher_no', 'voucher number', 'required|callback__check_tl_voucher['.$mem_id.']');
	        }
			if($voucher_type == 2) {
				$this->form_validation->set_rules('voucher_no', 'voucher number', 'required|callback__check_sc_voucher['.$mem_id.']');
			}

			if ($this->form_validation->run() === FALSE) {
		        $this->load->view('templates/header');
				$this->load->view('users/forms/submit_voucher', $data);
				$this->load->view('templates/footer');
			}
			else {

				$voucher_no = $this->input->post('voucher_no');

				// echo"<pre>";print_r($voucher_no);die();

				if($voucher_type == 1) {
					$status = $this->db->query("UPDATE trail_loans SET active = 0 WHERE member_id = '".$mem_id."' AND loan_voucher_no='".$voucher_no."'");
				}
				elseif($voucher_type == 2) {
					$status = $this->db->query("UPDATE sensor_clean_vouchers SET status = 0 WHERE member_id = '".$mem_id."' AND voucher_no='".$voucher_no."'");
				}
				if($status > 0) {
					$this->session->set_flashdata('success', 'The voucher has been submited. Thank you.');
					redirect(base_url('users/thankyou'));
				}
			}
		}
		else {
			redirect(base_url('users/404'));
		}

        // echo"<pre>";print_r($mem_id);die();
	}

	/**
     * Helper function to *ed email.
     *
     * @param $email,
     * @return $email,
	 */
	public function obfuscate_email($email) {
	    $em   = explode("@",$email);
	    $name = implode(array_slice($em, 0, count($em)-1), '@');
	    $len  = floor(strlen($name)/2);

	    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
	}

    /******* Member Provide feedback **********/
    public function feedback() {
        $this->load->view('templates/header');
        $this->load->view('pages/feedback');
        $this->load->view('templates/footer');
    }

    /******* Terms of Use **********/
    public function termsOfUse() {
//        $email_contents = $this->load->view('templates/email-template/sample', ['name' => 'Gab'], true);
//        $subject = 'Sample Email Template';
//        $email = ['john@team.humanpixel.com.au'];
//        $test = PANA_Helpers::pana_send_email($email, $subject, $email_contents, NULL, NULL, NULL);

        $this->load->view('templates/header');
        $this->load->view('pages/terms-of-use');
        $this->load->view('templates/footer');
    }

    /******* Terms of Use **********/
    public function eligibility() {
        $this->db->select('*');
        $this->db->where('active', 1);
        $query = $this->db->get('products');
        $data['products'] = $query->result_array();

        $this->load->view('templates/header');
        $this->load->view('pages/eligibility', $data);
        $this->load->view('templates/footer');
    }

    /******* Terms of Use **********/
    public function get_eligibility_requirements() {
        $this->db->select('*');
        $this->db->where('active', 1);
        $query = $this->db->get('products');
        $data['products'] = $query->result_array();

    }
}
