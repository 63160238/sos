<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_register extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->genlib->checkLogin();
	}

	public function index()
	{
		$values['pageTitle'] = 'Users';
		$values['breadcrumb'] = 'Users';
		$values['pageContent'] = $this->load->view('register/index', '', TRUE);
		$this->load->view('main', $values);
	}
	public function getEmptyRoom(){
		$getRoom = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id'], 'r_u_id' => NULL));
		$apartment = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id'],'a_status' =>1));
		$num = $apartment->a_floor;
		$getData = [];
		$index = 0;
		if ($getRoom) {
			for ($i = 1; $i <= $num; $i++) {
				foreach ($getRoom as $value) {
					if ($value->r_floor == $i) {
						$getData[$i - 1]['floor'] = $i;
						$getData[$i - 1]['room'][$index]['room_id'] = $value->r_id;
						$getData[$i - 1]['room'][$index]['room_name'] = $value->r_name;
						$index++;
					}
				}
			}
		}
		$json = ['getData' => $getData];
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function list()
	{
		$values['pageTitle'] = 'Users';
		$values['breadcrumb'] = 'Users';
		$values['newBtn'] = 'เพิ่มผู้ใช้ใหม่';
		$data['filterApartment'] = $this->genlib->filterApartment();
		$values['pageContent'] = $this->load->view('register/indexList', $data, TRUE);
		$this->load->view('main', $values);
	}
	public function get()
	{
		$this->genlib->ajaxOnly();
		$postData = $this->input->post();
		if ($postData && $postData['a_id']) {
			$_SESSION['user_a_id'] = intval($postData['a_id']);
		}
		$data['getData'] = $this->genmod->getAll('users', '*', array('role'  => '1', 'user_a_id' => $_SESSION['user_a_id']), 'created_at desc');
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
		$json['html'] = $this->load->view('register/list', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function get_Register()
	{
		// $data['getData'] = $this->genmod->getAll('users', '*', array('role'  => '1'), 'created_at desc');
		$json['body'] = $this->load->view('register/register', '', TRUE);
		// $json['footer'] = '<span id="fMsg"></span><button type="submit" class="btn btn-success mr-auto" onclick="saveFormSubmit(\'new\');">ยืนยัน</button>'
		// 	. '<button type="button" class="btn btn-danger" onclick="selectRoom()">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function uploadFile()
	{
		if ($_FILES['regis_doc']) {
			$date1 = 'regis';
			$upload = $_FILES['regis_doc'];
			if ($upload != '') {
				//ตัดขื่อเอาเฉพาะนามสกุล
				$typefile = strrchr($_FILES['regis_doc']['name'], ".");
				$path = "assets/docs/regis/";
				$newname = $date1 . $_POST['regis_u_id'] . $typefile;
				$formData['regis_doc'] = $newname;
				$path_copy = $path . $newname;
				move_uploaded_file($_FILES['regis_doc']['tmp_name'], $path_copy);
			}
		}
		// $this->genmod->add('s_register_info',$formData);
		$json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function add_Register()
	{
		$formData =  $this->input->post();
		if (array_key_exists('typefile', $formData)) {
			$formData['regis_doc'] = 'regis' . $formData['regis_u_id'] . "." . $formData['typefile'];
			unset($formData['typefile']);
		}
		$formData['regis_status'] = 1;
		$formData['regis_a_id'] = $_SESSION['user_a_id'];
		$this->genmod->add('s_register_info', $formData);
		$json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function add()
	{
		$this->genlib->ajaxOnly();
		$formData = $this->input->post();
		$formData['user_a_id'] = $_SESSION['user_a_id'];
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
		if ($formData['user_id'] == 'new') {
			$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required', $arrayErr);
		}
		if ($this->form_validation->run() !== FALSE) {
			if ($formData['user_id'] == 'new') {
				$checkSame = $this->genmod->getOne('users', 'user_id', array('id_card' => $formData['id_card']));
				if (!$checkSame) {
					$formData['password'] = password_hash(set_value('password'), PASSWORD_BCRYPT);
					$formData['created_by'] = $_SESSION['user_id'];
					$formData['created_ip'] = getClientIp();
					$formData['role'] = 1;
					$this->genmod->add('users', $formData);
					$inserted_id = $this->genmod->getOne('users', 'user_id', array('id_card' => $formData['id_card']));
					$json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ', 'nu_id' => $inserted_id->user_id];
				} else {
					$json = ['status' => 0, 'msg' => 'เกิดข้อผิดพลาด รหัสสมาชิกนี้มีอยู่แล้ว', 'sql' => $this->db->last_query()];
				}
			} else {
				$user_id = $formData['user_id'];
				unset($formData['user_id']);
				$formData['updated_by'] = $_SESSION['user_id'];
				$formData['updated_ip'] = getClientIp();
				$this->genmod->update('users', $formData, array('user_id' => $user_id));
				$json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
			}
		} else {
			$json = ['status' => 0, 'msg' => "พบปัญหา ข้อมูลมีความผิดพลาด เพิ่มข้อมูลไม่สำเร็จ ", 'error' => $this->form_validation->error_array()];
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function update()
	{
		$formData = $this->input->post();

		if ($this->genmod->update('users', $formData, array('user_id' => $formData['user_id']))) {
			$json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
		} else {
			$json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function updateRoom()
	{
		$formData = $this->input->post();
		if ($this->genmod->update('s_room', array('r_u_id' => $formData['nu_id']), array('r_id' => $formData['r_id']))) {
			$where = array('regis_u_id' => $formData['nu_id']);
			$this->genmod->update('s_register_info', array('regis_status' => 1), $where);
			$json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
		} else {
			$json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getEditForm()
	{
		$json['title'] = 'แบบฟอร์มการแก้ไขข้อมูลสมาชิก';
		$data['getData'] = $this->genmod->getOne('users', '*', array('user_id' => $this->input->post('user_id')));
		$json['body'] = $this->load->view('register/formadd', $data, true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="update(' . $this->input->post('user_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function getViewForm()
	{
		$json['title'] = 'แบบฟอร์มการแก้ไขข้อมูลสมาชิก';
		$data['getData'] = $this->genmod->getOne('users', '*', array('user_id' => $this->input->post('user_id')));
		$json['body'] = $this->load->view('register/formadd', $data, true);
		$json['footer'] = '<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}


	public function getChangePassForm()
	{
		$json['title'] = 'แบบฟอร์มการแก้ไขรหัสผ่าน';
		$json['body'] = $this->load->view('register/formChangePass', '', true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="changePassSubmit(' . $this->input->post('user_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function updateStatus()
	{
		$this->genlib->ajaxOnly();
		$updateData = $this->input->post();
		if ($this->genmod->getAll('s_room', '*', array('r_u_id' => $updateData['user_id']))) {
			$json = ['status' => 0, 'msg' => "ไม่สามารถระงับการใช้งานได้ เนื่องจากผู้ใช้ยังใช้งานห้องพัก"];
		} else {
			if ($this->genmod->update('users', array('status' => ($updateData['status'] == 0 ? '1' : '0'), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id' => $updateData['user_id']))) {
				$json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
			} else {
				$json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function changePass()
	{
		$this->genlib->ajaxOnly();
		$updateData = $this->input->post();
		if ($this->genmod->update('users', array('password' => password_hash($updateData['newPass'], PASSWORD_BCRYPT), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id' => $updateData['user_id']))) {
			$json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
		} else {
			$json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
}
