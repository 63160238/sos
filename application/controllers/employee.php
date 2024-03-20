<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->genlib->checkLogin();
	}

	public function index()
	{
		if ($_SESSION['user_role'] == 3) {
			$values['pageTitle'] = 'จัดการบุคลกร';
			$values['breadcrumb'] = 'จัดการบุคลกร';
			$values['newBtn'] = 'เพิ่มบุคลากร';
			$data['filterApartment'] = $this->genlib->filterApartment();
			$values['pageContent'] = $this->load->view('employee/index', $data, TRUE);
			$this->load->view('main', $values);
		} else {
			echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
		}
	}

	public function get()
	{
		$filter = $this->input->post();
		if (isset($filter['a_id']) && $filter['a_id'] != 'all') {
			$data['filterAid'] = $filter['a_id'];
			$getData = $this->genmod->getAll('users', '*', array('FIND_IN_SET(' . $filter['a_id'] . ', user_a_id) >' => 0, 'role >' => '1'), 'status asc,created_at asc');
		} else {
			$getData = $this->genmod->getAll('users', '*', array('role >' => '1'), 'status asc,created_at asc');
		}
		if ($getData) {
			$data['getData'] = $getData;
			for ($i = 0; $i < count($data['getData']); $i++) {
				$user_a_id_string = $data['getData'][$i]->user_a_id;
				$data['getData'][$i]->user_a_id = explode(',', $user_a_id_string);
			}
		}else{
			$data['getData'] = [];
		}
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
		$json['html'] = $this->load->view('employee/list', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function add()
	{
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
					$this->genmod->add('users', $formData);
					$json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
				} else {
					$json = ['status' => 0, 'msg' => 'เกิดข้อผิดพลาด รหัสสมาชิกนี้มีอยู่แล้ว', 'sql' => $this->db->last_query()];
				}
			} else {
				$user_id = $formData['user_id'];
				unset($formData['user_id']);
				unset($formData['a_id']);
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

	public function getAddForm()
	{
		$json['title'] = 'แบบฟอร์มการเพิ่มผู้ใช้งานใหม่';
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*', array('a_status' => 1));
		$json['body'] = $this->load->view('employee/formadd', $data, true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getEditForm()
	{
		$json['title'] = 'แบบฟอร์มการแก้ไขข้อมูลสมาชิก';
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*', array('a_status' => 1));
		$data['getData'] = $this->genmod->getOne('users', '*', array('user_id' => $this->input->post('user_id')));
		$user_a_id_string = $data['getData']->user_a_id;
		$data['getData']->user_a_id = explode(',', $user_a_id_string);
		$json['body'] = $this->load->view('employee/formadd', $data, true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(' . $this->input->post('user_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getChangePassForm()
	{
		$json['title'] = 'แบบฟอร์มการแก้ไขรหัสผ่าน';
		$json['body'] = $this->load->view('users/formChangePass', '', true);
		$json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="changePassSubmit(' . $this->input->post('user_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function updateStatus()
	{
		$this->genlib->ajaxOnly();
		$updateData = $this->input->post();
		$user = $this->genmod->getOne('users', '*', array('user_id' => $updateData['user_id']));
		if ($user->user_a_id != "" && $this->genmod->update('users', array('status' => ($updateData['status'] == 0 ? '1' : '0'), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id' => $updateData['user_id']))) {
			$json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
		} else if ($user->user_a_id == "") {
			$json = ['status' => 0, 'msg' => "ไม่ปรับปรุงสถานะการใช้งานได้ เนื่องจากแอดมินคนนี้ไม่มีหอดูแล"];
		} else {
			$json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
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
