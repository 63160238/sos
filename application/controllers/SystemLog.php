<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemLog extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->genlib->checkLogin();
	}

	public function index()	{
		if ($_SESSION[ 'user_role' ] > 1) {
		$values['pageTitle'] = 'System log';
		$values['breadcrumb'] = 'System log';
		$values['pageContent'] = $this->load->view('systemLog/index', "", TRUE);
		$this->load->view('main', $values);
	} else {
    echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
  }
	}
	public function get(){
		$formData = $this->input->post();
		$this->db->where("DATE(date) BETWEEN '".$formData['startDate']."' AND '".$formData['endDate']."'");
		if($formData['action'] != 'all'){
			$this->db->where('action',$formData['action']);
		}
		$data['getData'] = $this->genmod->getAll('system_log', 'system_log.*, concat(users.fname_th," ",users.lname_th) as user_name', '','date',array('users'=>'user_id = user'));
		$json['html'] = $this->load->view('systemLog/list', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}
