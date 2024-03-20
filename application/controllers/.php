<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->genlib->checkLogin();
	}

	public function index()	{
		$values['pageTitle'] = 'Users';
		$values['breadcrumb'] = 'Users';
		$values['newBtn'] = 'เพิ่มผู้ใช้ใหม่';
		$values['pageContent'] = $this->load->view('users/index', "", TRUE);
		$this->load->view('main', $values);
	}

	public function get(){
		$data['getData'] = $this->genmod->getAll('users', '*', array('role'  => '1'), 'created_at desc');
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
		$json['html'] = $this->load->view('users/list', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function add(){
		$this->genlib->ajaxOnly();
		$formData = $this->input->post();
		$arrayErr = array(
      'required' => 'คุณต้องทำการระบุ  {field} ',
			'numeric' => 'กรุณาระบุ {field} เป็นตัวเลขเท่านั้น',
			'min_length' => 'กรุณาระบุ {field} เป็นตัวเลขอย่างน้อย {param} หลัก',
			'max_length' => 'กรุณาระบุ {field} เป็นตัวเลขไม่เกิน {param} หลัก'

    );
		$this->form_validation->set_rules('id_card', 'เลขบัตรประจำตัวประชาชน', 'required|numeric', $arrayErr);
		$this->form_validation->set_rules('prename', 'คำนำหน้า', 'required', $arrayErr);
		$this->form_validation->set_rules('fname_th', 'ชื่อ', 'required', $arrayErr);
		$this->form_validation->set_rules('lname_th', 'นามสกุล', 'required', $arrayErr);
		$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required', $arrayErr);
		if($formData['user_id'] == 'new'){
			$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required', $arrayErr);
		}
		if($this->form_validation->run() !== FALSE){
			if($formData['user_id'] == 'new'){
				$checkSame = $this->genmod->getOne('users', 'user_id',array('id_card'=>$formData['id_card']));
				if(!$checkSame){
					$formData['password'] = password_hash(set_value('password'), PASSWORD_BCRYPT);
					$formData['created_by'] = $_SESSION['user_id'];
					$formData['created_ip'] = getClientIp();
					$this->genmod->add('users',$formData);
					$json = ['status'=> 1, 'msg'=>'บันทึกข้อมูลสำเร็จ'];
				}else{
					$json = ['status'=> 0, 'msg'=>'เกิดข้อผิดพลาด รหัสสมาชิกนี้มีอยู่แล้ว', 'sql'=> $this->db->last_query()];
				}
			}else{
				$user_id = $formData['user_id'];
				unset($formData['user_id']);
				$formData['updated_by'] = $_SESSION['user_id'];
				$formData['updated_ip'] = getClientIp();
				$this->genmod->update('users', $formData, array('user_id'=>$user_id));
				$json = ['status'=> 1, 'msg'=>'แก้ไขข้อมูลสำเร็จ'];
			}

		}else{
			$json = ['status'=> 0, 'msg'=>"พบปัญหา ข้อมูลมีความผิดพลาด เพิ่มข้อมูลไม่สำเร็จ ",'error'=>$this->form_validation->error_array()];
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getAddForm(){
		$json['title'] = 'แบบฟอร์มการเพิ่มผู้ใช้งานใหม่';
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
		$json['body'] = $this->load->view('users/formadd', $data ,true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getEditForm(){
		$json['title'] = 'แบบฟอร์มการแก้ไขข้อมูลสมาชิก';
		$data['getData'] = $this->genmod->getOne('users', '*', array('user_id'=>$this->input->post('user_id')));
		$json['body'] = $this->load->view('users/formadd', $data ,true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit('.$this->input->post('user_id').');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getChangePassForm(){
		$json['title'] = 'แบบฟอร์มการแก้ไขรหัสผ่าน';
		$json['body'] = $this->load->view('users/formChangePass', '' ,true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="changePassSubmit('.$this->input->post('user_id').');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function updateStatus(){
		$this->genlib->ajaxOnly();
		$updateData = $this->input->post();
		if($this->genmod->update('users', array('status'=> ($updateData['status'] == 0? '1':'0'), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id'=>$updateData['user_id']))){
			$json = ['status'=> 1, 'msg'=>"ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
		}else{
			$json = ['status'=> 0, 'msg'=>"พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function changePass(){
		$this->genlib->ajaxOnly();
		$updateData = $this->input->post();
		if($this->genmod->update('users', array('password'=> password_hash($updateData['newPass'], PASSWORD_BCRYPT), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id'=>$updateData['user_id']))){
			$json = ['status'=> 1, 'msg'=>"ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
		}else{
			$json = ['status'=> 0, 'msg'=>"พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}