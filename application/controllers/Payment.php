<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->genlib->checkLogin();
	}

	public function index()
	{
		$values['pageTitle'] = 'รายการชำระเงิน';
		$values['breadcrumb'] = 'รายการชำระเงิน';
		$values['newBtn'] = 'ชำระเงิน';
		$values['pageContent'] = $this->load->view('Payments/index', "", TRUE);
		$this->load->view('main', $values);
	}

	public function get()
	{
		$uid = $this->input->post();
		$data['getData'] = $this->genmod->getOne('s_admin_confit', '*', array('ac_a_id' => $_SESSION['user_a_id']));
		$data['getData_partment'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
		$data['s_room'] = $this->genmod->getOne('s_room', '*', array('r_u_id' => isset($uid['u_id']) ? $uid['u_id'] : $_SESSION['user_id']));
		$data['getData_user'] = $this->genmod->getOne('users', '*', array('user_id' => isset($uid['u_id']) ? $uid['u_id'] : $_SESSION['user_id']));
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
		$data['getData_bill1'] = $this->genmod->getOne(
			's_bill',
			'MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data['s_room']->r_id,
				// 'bill_updete_at'=> 'latest_updete_at'
			),
		);
		$data['getData_bill'] = $this->genmod->getOne(
			's_bill',
			'*,MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data['s_room']->r_id,
				'bill_updete_at' => $data['getData_bill1']->latest_updete_at,
				'bill_mg_status' => 1
			),
		);
		date_default_timezone_set('Asia/Bangkok');
		$current_date = date("Y-m-d");
		$data['color'] =['text-warning','text-success','text-danger'];
		$data['getData_partment']->a_lateday = date("Y-m-") . $data['getData_partment']->a_lateday;
        
		$json[ 'data' ] = $data;
		
		// var_dump($data);
		$json['html'] = $this->load->view('payments/payment', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function add()
	{
		$this->genlib->ajaxOnly();
		$formData = $this->input->post();
		var_dump($formData); 
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function uploadFile()
	{
		$data['getData'] = $this->genmod->getOne('s_admin_confit', '*', array('ac_a_id' => $_SESSION['user_a_id']));
		$data['getData_partment'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
		$data['s_room'] = $this->genmod->getOne('s_room', '*', array('r_u_id' => $_SESSION['user_id']));
		$data['getData_user'] = $this->genmod->getOne('users', '*', array('user_id' => $_SESSION['user_id']));
		$data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
		$data['getData_bill1'] = $this->genmod->getOne(
			's_bill',
			'MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data['s_room']->r_id,
				// 'bill_updete_at'=> 'latest_updete_at'
			),
		);
		$data['getData_bill'] = $this->genmod->getOne(
			's_bill',
			'*,MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data['s_room']->r_id,
				'bill_updete_at' => $data['getData_bill1']->latest_updete_at,
				'bill_mg_status' => 1
			),
		);
		$bill=$data[ 'getData_bill' ]->bill_id;
		$room_id=$data[ 'getData_bill' ]->bil_r_id;
		if ($_FILES['slip']) {

			$date1 = 'slip';
			$upload = $_FILES['slip'];
			if ($upload != '') {
				//ตัดขื่อเอาเฉพาะนามสกุล
				$typefile = strrchr($_FILES['slip']['name'], ".");
				date_default_timezone_set('Asia/Bangkok');
				$currentDateTime = date("Y_m_d H_i_s");
				$path = "assets/slips/";
				$newname = $date1."_" . $currentDateTime .'_'. $room_id.$typefile;
				$formData['slip'] = $newname;
				$path_copy = $path . $newname;
				$pay_status=2;
				move_uploaded_file($_FILES['slip']['tmp_name'], $path_copy);
				$this->genmod->update("s_bill",array('bill_status'=>2,'bill_slip_file'=>$newname),array('bill_id'=>$bill) );
				$this->genmod->update("s_room",array('pay_status'=>$pay_status),array('r_u_id' => $_SESSION['user_id']) );
			}
		}
		// $this->genmod->add('s_register_info',$formData);
		$json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function getAddForm()
	{
		$json[ 'title' ] = 'การชำระเงิน';
		$data[ 's_room' ] = $this->genmod->getOne('s_room', '*', array('r_u_id' => $_SESSION[ 'user_id' ]));
		$data[ 'getData' ] = $this->genmod->getAll('s_apartment', 'promptpay_no', array('a_id' => $_SESSION[ 'user_a_id' ]));
		$data[ 'getData_bill1' ] = $this->genmod->getOne(
			's_bill',
			'MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data[ 's_room' ]->r_id,
				// 'bill_updete_at'=> 'latest_updete_at'
			),
		);
		$data[ 'getData_bill' ] = $this->genmod->getOne(
			's_bill',
			'*,MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data[ 's_room' ]->r_id,
				'bill_updete_at' => $data[ 'getData_bill1' ]->latest_updete_at,
				'bill_mg_status' => 1
			),
		);
		$json[ 'data' ] = $data;
		// var_dump($data['apartment']);
		// var_dump($data);
		$json[ 'body' ] = $this->load->view('payments/formadd', $data, true);
		$json[ 'footer' ] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'' . $data[ 's_room' ]->r_id . '\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}		
	public function getAddFormdata()
	{
		// $json['title'] = 'การชำระเงิน';
		$data['s_room'] = $this->genmod->getOne('s_room', '*', array('r_u_id' => $_SESSION['user_id']));
		$data['getData'] = $this->genmod->getAll('s_apartment', 'promptpay_no', array('a_id' => $_SESSION['user_a_id']));
		$data['getData_bill1'] = $this->genmod->getOne(
			's_bill',
			'MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data['s_room']->r_id,
				// 'bill_updete_at'=> 'latest_updete_at'
			),
		);
		$data['getData_bill'] = $this->genmod->getOne(
			's_bill',
			'*,MAX(bill_updete_at) as latest_updete_at, ',
			array(
				'bil_r_id' => $data['s_room']->r_id,
				'bill_updete_at' => $data['getData_bill1']->latest_updete_at,
				'bill_mg_status' => 1
			),
		);
		// $json[ 'data' ] = $data;
		echo json_encode($data);
		// var_dump($data['apartment']);
		// var_dump($data);
		// $json['body'] = $this->load->view('payments/formadd', $data, true);
		// $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		// <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
		// $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}


	public function getEditForm()
	{
		$json['title'] = 'แบบฟอร์มการแก้ไขข้อมูลสมาชิก';
		$data['getData_partment'] = $this->genmod->getOne('s_apartment', 'promptpay_no', array('a_id' => $_SESSION['user_a_id']));
		$json['body'] = $this->load->view('users/formadd', $data, true);
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
		if ($this->genmod->update('users', array('status' => ($updateData['status'] == 0 ? '1' : '0'), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id' => $updateData['user_id']))) {
			$json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
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
