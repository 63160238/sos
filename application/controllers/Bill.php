<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bill extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
    $this->genlib->updateMeterPower();
		$this->genlib->updateMeterWater();
  }

  public function index()
  {
    if ($_SESSION[ 'user_role' ] > 1) {
    $values['pageTitle'] = 'คำนวนบิล';
    $values['breadcrumb'] = 'คำนวนบิล';
    // $values['MsgBtn'] = 'ส่งบิลทั้งหมด';
    $data['filterApartment'] = $this->genlib->filterApartment();
    $data['floor'] = $this->genmod->getAll('s_apartment', '*', array('a_id'  => $_SESSION['user_a_id']));
    $values['pageContent'] = $this->load->view('Bill/index', $data, TRUE);
    $this->load->view('main', $values);
  } else {
    echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
  }
  }

  public function get()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    if(isset($formData['a_id'])){
      $_SESSION['user_a_id'] = $formData['a_id'];
    }
    if (!empty($formData)&&$formData['a_floor']!="0") {
      $data['getData_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id'], 'r_floor' => $formData['a_floor']));
    } else {
      $data['getData_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id']));
    }
    $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id' => $_SESSION['user_a_id']));
    $data['getData_Apamet'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
    $data['getData_bill1'] = $this->genmod->getAll(
      's_bill',
      'bil_r_id, MAX(bill_updete_at) as latest_updete_at', 
      array(
        'bill_a_id' => $_SESSION['user_a_id']
      ),
      'bil_r_id, latest_updete_at DESC',
      null,
      'bil_r_id'
    );

  // สร้างอาร์เรย์เพื่อเก็บข้อมูลที่ได้จากการทำซ้ำ
$data['getData_bill'] = array();

// วนลูปผ่าน $data['getData_bill1']
for ($i = 0; $i < count($data['getData_bill1']); $i++) { 
    // ดึงข้อมูลจากฐานข้อมูลโดยใช้ข้อมูลจาก $data['getData_bill1']
    $result = $this->genmod->getAll(
        's_bill',
        '*', 
        array(
            'bil_r_id' => $data['getData_bill1'][$i]->bil_r_id,
            'bill_updete_at' => $data['getData_bill1'][$i]->latest_updete_at
        ),
    );
    // เพิ่มข้อมูลที่ได้ลงในอาร์เรย์ $data['getData_bill']
    if (!empty($result)) {
        $data['getData_bill'][] = $result;
    }else{
    }
}
    $data[ 'meter' ] = $this->genmod->getAll('s_power_meter', "emb_id ,p_id", array('p_a_id' => $_SESSION[ 'user_a_id' ]));
    $json['html'] = $this->load->view('bill/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function get_meter()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $data['getData'] = $this->genmod->getOne('s_room', 'r_w_id ,r_p_id', array('r_id' => $formData['r_id']));
    $data['getData_w'] = $this->genmod->getOne('s_water_meter', 'w_flow_sum', array('w_id' => $data['getData']->r_w_id));
    $data['getData_p'] = $this->genmod->getOne('s_power_meter','p_kwh', array('p_id' => $data['getData']->r_p_id));
    $json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
    $json['data'] = $this->load->view('bill/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
  }
  public function edit()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $data['getData_edit1'] = $this->genmod->getOne(
      's_bill', // Table name
      'bil_r_id, MAX(bill_updete_at) as latest_updete_at', // Columns to retrieve
      array(
        'bil_r_id' => $formData['bil_r_id'] // Condition for WHERE clause
      ),
      'bil_r_id', // GROUP BY clause
      null, // No need for ORDER BY, as you are using aggregate functions
      null // No need for LIMIT
    );

    // Check if data was found before using it in the second query
    if ($data['getData_edit1']) {
      // Access properties using arrow notation
      $latest_updete_at = $data['getData_edit1']->latest_updete_at;
      $data['getData_edit'] = $this->genmod->getAll('s_bill', '*', array(
        'bil_r_id' => $formData['bil_r_id'],
        'bill_updete_at <' => $latest_updete_at,
      ), 'bill_updete_at DESC');
    } else {
      $data['getData_edit2'] = array(); 
    }
    // var_dump($data);
    $json['title'] = 'แก้ไขข้อมูลการคำนวน';
    $data['getData_room'] = $this->genmod->getOne('s_room', '*', array('r_id' => $formData['bil_r_id']));
    // $data['getData_user'] = $this->genmod->getAll('users', '*');
    $data['getData_type'] = $this->genmod->getOne('s_admin_confit', '*', array('ac_type_id' =>  $data['getData_room']->r_type, 'ac_a_id' =>  $data['getData_room']->r_a_id));
    $data['getData_Apamet'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
    $json['body'] = $this->load->view('Bill/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(' . $this->input->post('bil_r_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function add()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $u_id = $this->genmod->getOne('s_room', 'r_u_id', array('r_id' => $formData['bil_r_id']));
    $formData['bill_User_id'] =  $u_id->r_u_id;
    if($formData['bill_User_id'] == null){
      $json = ['status' => 0, 'msg' => 'ไม่สามารถส่งบิลได้ เนื่องจากห้องพักไม่มีผู้เช่า'];
    }else{
      $formData['bill_status'] =  1;
      $this->genmod->add('s_bill', $formData, array('bil_r_id' => $formData['bil_r_id']));
      $json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function update_Edit()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $data['getData_bill'] = $this->genmod->getOne(
      's_bill',
      'bil_r_id, MAX(bill_updete_at) as latest_updete_at, MAX(bill_p_khw) as bill_p_khw, MAX(bill_w_flow) as bill_w_flow ,MAX(bill_cost) as bill_cost,bill_mg_status ',
      array(
        'bil_r_id' => $formData['bil_r_id']
      ),
      'bil_r_id, latest_updete_at DESC',
      null,
      'bil_r_id'
    );
    $this->genmod->update('s_bill', $formData, array('bil_r_id' => $formData['bil_r_id'],'bill_updete_at' => $data['getData_bill']->latest_updete_at));
    // var_dump($test);
    $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function getAddForm()
  {
    $json['title'] = 'แบบฟอร์มการเพิ่มผู้ใช้งานใหม่';
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $json['body'] = $this->load->view('aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }


  public function getForm()
  {
    $json['title'] = 'รายละเอียดห้องพัก';
    $data['getData'] = $this->genmod->getOne('s_room', '*', array('r_id' => $this->input->post('r_id')));
    $data['getData_user'] = $this->genmod->getAll('users', '*');
    $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*');
    $json['body'] = $this->load->view('aprtment/formadd', $data, true);
    $json['footer'] = '<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>';
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
    if ($this->genmod->update('s_bill',$updateData,array('bil_r_id' =>$updateData['bil_r_id']) )) {
      $u_id = $this->genmod->getOne('s_bill','bill_User_id',array('bil_r_id' =>$updateData['bil_r_id']),'bill_id desc' );
      $json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย",'u_id'=>$u_id->bill_User_id];
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
