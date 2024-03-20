<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
  }

  public function index()
  {
    if ($_SESSION[ 'user_role' ] > 1) {
    $values['pageTitle'] = 'ตั้งค่าหอพัก';
    $values['breadcrumb'] = 'ตั้งค่าหอพัก';
    // $values['newBtn'] = 'เพิ่มผู้ใช้ใหม่';
    $values['pageContent'] = $this->load->view('Setting/index', "", TRUE);
    $this->load->view('main', $values);
  } else {
    echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
  }
  }

  public function get()
  {
    $data['getData'] = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id' => $_SESSION['user_a_id']));
    $data['getData_partment'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
    // print_r($data['getData_partment']);
    // var_dump($data['getData_partment']);
    // $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    // $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
    // <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $json['html'] = $this->load->view('setting/setting', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function add()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $Data = array();
    // print_r($formData['data']['formData'][1]['waterRate']);
   
    $data['a_water_cost'] = $formData['data']['formData'][1]['waterRate'];
    $data['a_power_cost'] = $formData['data']['formData'][1]['electricityRate'];
    $data['promptpay_no'] = $formData['data']['formData'][1]['promptpay'];
    $data['a_duedate'] = $formData['data']['formData'][1]['billingCycle'];
    $data['a_lateday'] = $formData['data']['formData'][1]['dueDate'];
    $data['a_id'] = $formData['data']['formData'][1]['ac_a_id'];
    $room['s_room']=$this->genmod->getAll('s_room', '*', array('r_a_id' => $data[ 'a_id' ]));
    $a=$this->genmod->getOne('s_apartment', '*', array('a_id' => $data[ 'a_id' ]));
    foreach ($room['s_room'] as $key => $value) 
    {
      if ($value->r_duedate == $a->a_duedate && $value->r_lateday == $a->a_lateday ) {
        $value->r_duedate = $data[ 'a_duedate' ];
        $value->r_lateday=$data['a_lateday'];
        $this->genmod->update('s_room',array('r_duedate'=>$value->r_duedate,'r_lateday'=>$value->r_lateday), array('r_a_id' => $data['a_id'] ,'r_id'=>$value->r_id));
      }
    }
    $chake['ac_type_id'] = $this->genmod->getAll('s_admin_confit', 'ac_type_id', array('ac_a_id' => $data['a_id']));
    for ($i = 0; $i <= count($formData['data']['formData']); $i++) {
      if (!empty($formData['data']['formData'][$i]['ac_type_id']) && $formData['data']['formData'][$i]['ac_type_id'] != null) {
        $Data['ac_type_cost'] = $formData['data']['formData'][$i]['roomPrice'];
        $Data['ac_type_name'] = $formData['data']['formData'][$i]['roomType'];
        $Data['ac_type_id'] = $i - 1;
        $Data['ac_a_id'] = $data['a_id'];
        if ($Data['ac_type_id'] === ((int) $chake['ac_type_id'][$i - 2]->ac_type_id)) {
          $this->genmod->update('s_admin_confit', $Data, array('ac_a_id' => $data['a_id'], 'ac_type_id' => $Data['ac_type_id']));
          $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
        } else if ($Data['ac_type_id'] > ((int) $chake['ac_type_id'][$i - 2]->ac_type_id)) {
          $this->genmod->add('s_admin_confit', $Data);
          $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
        }
      }
    }
    $this->genmod->update('s_apartment', $data, array('a_id' => $data['a_id']));
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

  public function getEditForm()
  {
    $json['title'] = 'แก้ไขรายละเอียดห้องพัก';
    $data['getData'] = $this->genmod->getOne('s_room', '*', array('r_id' => $this->input->post('r_id')));
    $data['getData_user'] = $this->genmod->getAll('users', '*');
    $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*');
    $json['body'] = $this->load->view('aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(' . $this->input->post('r_id') . ');">บันทึก</button>
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
  public function delete_Type()
  {
    $this->genlib->ajaxOnly();
    $Data = $this->input->post();
    $data = array();
    // var_dump($Data);
    // if ($this->genmod->update('users', array('password' => password_hash($updateData['newPass'], PASSWORD_BCRYPT), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id' => $updateData['user_id']))) {
    //   $json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
    // } else {
    //   $json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
    // }
    $this->db->delete('s_admin_confit', array('ac_type_name' => $Data["ac_type_name"]));
    $chake = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id' => $_SESSION['user_a_id']));
    for ($i  = 0; $i < count($chake); $i++) {
      $data['ac_type_id'] = $i + 1;
      // $data['ac_id'] = $chake[$i]->ac_id;
      // $data['ac_id'] = $chake[$i]->ac_id;
      // $data['ac_id'] = $chake[$i]->ac_id;
      echo "rom";
      var_dump($data['ac_type_id']);
      $this->genmod->update('s_admin_confit', $data, array('ac_a_id' => $_SESSION['user_a_id'], 'ac_type_id' => $chake[$i]->ac_type_id));
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
}
