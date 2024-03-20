<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function checkLogin()
	{
		$this->genlib->ajaxOnly();
		$arrayErr = array(
			'required' => 'คุณต้องทำการระบุ {field}',
		);
		$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required', $arrayErr);
		$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required', $arrayErr);
		if ($this->form_validation->run() !== FALSE) {

			$givenUsername = strtolower(set_value('username'));
			$givenPassword = set_value('password');

			$passwordInDb = $this->genmod->getTableCol('users', 'password', 'username', $givenUsername);
			$account_status = $this->genmod->getTableCol('users', 'status', 'username', $givenUsername);


			//verify password if $passwordInDb has a value (i.e. is set)
			$verifiedPassword = $passwordInDb ? password_verify($givenPassword, $passwordInDb) : FALSE;

			//allow log in if password and email matches and admin's account has not been suspended or deleted
			// status == 0 user is deleted
			if ($verifiedPassword && $account_status > 0) {
				$this->load->model(array('user_model'));
				//set session details
				// get user information
				$user_info = $this->user_model->get_user_info($givenUsername);
				if ($user_info) {
					foreach ($user_info as $get) {
						$user_id = $get->user_id;
						$_SESSION['user_id'] = $user_id;
						$_SESSION['staff_id'] = $user_id;
						$_SESSION['username'] = $givenUsername;
						$_SESSION['user_role'] = $get->role;
						$_SESSION['user_position'] = $get->position;
						$_SESSION['user_a_id'] = $get->user_a_id;
						$_SESSION['user_prefix'] = $get->prename;
						$_SESSION['a_id'] = 1;
						$_SESSION['user_fullname'] = $get->fname_th . " " . $get->lname_th;
					}

					//update user's last log in time
					$this->user_model->update_last_login($user_id);
					// $this->genmod->update('users',array('current_school_year'=>$_SESSION['school_year']), array('user_id'=>$user_id));
				}

				$json['status'] = 1; //set status to return
			} else { //if password is not correct
				$json['msg'] = "ชื่อผู้ใช้  หรือ รหัสผ่าน  ไม่ถูกต้อง";
				$json['status'] = 0;
			}
		} else { //if form validation fails
			$json['msg'] = "One or more required fields are empty or not correctly filled";
			$json['status'] = 0;
		}
		$_SESSION['a_id'] = explode(',', $_SESSION['user_a_id']);
		for ($i = 0; $i < count($_SESSION['a_id']); $i++) {
			$a_name[$i] = $this->genmod->getOne('s_apartment', 'a_name, a_id', array('a_id' => $_SESSION['a_id'][$i]));
		}
		$_SESSION['a_name'] = $a_name;
		$_SESSION['user_a_id'] = intval($_SESSION['a_id'][0]);
		if ($_SESSION['user_role'] == 1) {
			$room = $this->genmod->getOne('s_room', 'r_name', array('r_a_id' => $_SESSION['user_a_id'], 'r_u_id' => $_SESSION['user_id']));
			// var_dump($room->r_name);
			if ($room) {
				$_SESSION['room'] = $room->r_name;
			}else{
				$_SESSION['room'] = 'ไม่มีห้อง';
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function lond_sec()
	{
		$this->genlib->ajaxOnly();
		$formData = $this->input->post();
		$_SESSION['user_a_id'] = intval($formData['selectedDorm']);
		// var_dump($_SESSION[ 'user_a_id' ]);
		// $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
