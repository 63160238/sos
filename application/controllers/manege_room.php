<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manege_room extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
  }

  public function index()
  {
    if ($_SESSION[ 'user_role' ] > 1) {
    $values['pageTitle'] = 'จัดการหอพัก';
    $values['breadcrumb'] = 'จัดการหอพัก';
    $values['newBtn'] = 'เพิ่มหอพักใหม่';
    $data['floor'] = $this->genmod->getAll('s_apartment', '*', array('a_id'  => $_SESSION['user_a_id']));
    $values['pageContent'] = $this->load->view('manage_room/index', $data, TRUE);
    $this->load->view('main', $values);
  } else {
    echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
  }
  }

  public function get()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    if (!empty($formData)&&$formData['a_floor']!="0") {
      $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id'], 'r_floor' => $formData['a_floor']));
    } else {
      $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id']));
    }
    $data['type'] = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id'  => $_SESSION['user_a_id']));
    $json['html'] = $this->load->view('manage_room/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  // public function get_filter()
  // {
  //   $this->genlib->ajaxOnly();
  //   $formData = $this->input->post();
  //   if (!empty($formData)) {
  //     $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id'], 'r_floor' => $formData['a_floor']));
  //   } else {
  //     $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id'], 'r_floor' => 1));
  //   }
  //   $data['type'] = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id'  => $_SESSION['user_a_id']));
  //   $json['html'] = $this->load->view('manage_room/list', $data, TRUE);
  //   $this->output->set_content_type('application/json')->set_output(json_encode($json));
  // }
  public function get_edit()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $json['title'] = 'แก้ไขหอพัก';
    if (!empty($formData)&&$formData['floor']!="0") {
      $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id'], 'r_floor' => $formData['floor']));
    } else {
      $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id']));
    }
    $data['type'] = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id'  => $_SESSION['user_a_id']));
    $json[ 'body' ] = $this->load->view('manage_room/formedit', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';;
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function get_add()
  {
    $json['title'] = 'แก้ไขขนาดหอพัก';
    $data['floor'] = $this->genmod->getAll('s_apartment', '*', array('a_id'  => $_SESSION['user_a_id']));
    $data['room'] = $this->genmod->getAll('s_room', '*', array('r_a_id'  => $_SESSION['user_a_id']));
    $json['body'] = $this->load->view('manage_room/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormRoom(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';;
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function add()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $this->genmod->add('s_apartment', $formData);
    $formData['id'] = $this->genmod->getOne('s_apartment', 'a_id', array('a_name' => $formData['a_name']));
    // $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($formData));
  }
  public function add_room()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    var_dump($formData); 
    for ($i = 1; $i < $formData['a_floor']; $i++) {
      for ($j = 1; $j <= $formData['a_room']; $j++) {
        $power['p_name'] = "P".$i . "" . sprintf("%02d", $j);
        // $room['r_floor'] = $i;
        $power['p_a_id'] = $formData['id']['a_id'];
        $power['P_satatus'] = 1;
        // $room['r_id'] = uniqid();
        $this->genmod->add('s_power_meter', $power);
      }
    } 
    // for ($i = 1; $i < $formData['a_floor']; $i++) {
    //   for ($j = 1; $j <= $formData['a_room']; $j++) {
    //     $room['r_name'] = $i . "" . sprintf("%02d", $j);
    //     $room['r_floor'] = $i;
    //     $room['r_a_id'] = $formData['id']['a_id'];
    //     $room['r_type'] = 1;
    //     // $room['r_id'] = uniqid();
    //     $this->genmod->add('s_room', $room);
    //   }
    // }
    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function edit()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    // $arrayErr = array(
    //   'required' => 'คุณต้องทำการระบุ  {field} ',
    //   'numeric' => 'กรุณาระบุ {field} เป็นตัวเลขเท่านั้น',
    //   'min_length' => 'กรุณาระบุ {field} เป็นตัวเลขอย่างน้อย {param} หลัก',
    //   'max_length' => 'กรุณาระบุ {field} เป็นตัวเลขไม่เกิน {param} หลัก'

    // );
    // $this->form_validation->set_rules('id_card', 'เลขบัตรประจำตัวประชาชน', 'required|numeric', $arrayErr);
    // $this->form_validation->set_rules('prename', 'คำนำหน้า', 'required', $arrayErr);
    // $this->form_validation->set_rules('fname_th', 'ชื่อ', 'required', $arrayErr);
    // $this->form_validation->set_rules('lname_th', 'นามสกุล', 'required', $arrayErr);
    // $this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required', $arrayErr);
    // if ($formData['user_id'] == 'new') {
    //   $this->form_validation->set_rules('password', 'รหัสผ่าน', 'required', $arrayErr);
    // }
    // if ($this->form_validation->run() !== FALSE) {
    //   if ($formData['user_id'] == 'new') {
    //     $checkSame = $this->genmod->getOne('users', 'user_id', array('id_card' => $formData['id_card']));
    //     if (!$checkSame) {
    //       $formData['password'] = password_hash(set_value('password'), PASSWORD_BCRYPT);
    //       $formData['created_by'] = $_SESSION['user_id'];
    //       $formData['created_ip'] = getClientIp();
    //       $this->genmod->add('users', $formData);
    //       $json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
    //     } else {
    //       $json = ['status' => 0, 'msg' => 'เกิดข้อผิดพลาด รหัสสมาชิกนี้มีอยู่แล้ว', 'sql' => $this->db->last_query()];
    //     }
    //   } else {
    //     $user_id = $formData['user_id'];
    //     unset($formData['user_id']);
    //     $formData['updated_by'] = $_SESSION['user_id'];
    //     $formData['updated_ip'] = getClientIp();
    // $this->genmod->update('s_apartment', $formData);
    $this->genmod->update('s_apartment', $formData, array('a_id' => $formData['a_id']));
    $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
    //   }
    // } else {
    //   $json = ['status' => 0, 'msg' => "พบปัญหา ข้อมูลมีความผิดพลาด เพิ่มข้อมูลไม่สำเร็จ ", 'error' => $this->form_validation->error_array()];
    // }

    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function getAddForm()
  {
    $json['title'] = 'แบบฟอร์มการเพิ่มหอพักใหม่';
    $data['provinces'] = $this->genmod->getAll('provinces', '*');
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $json['body'] = $this->load->view('manage_aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function get_amphures()
  {
    // $json['title'] = 'แบบฟอร์มการเพิ่มหอพักใหม่';
    // $data['provinces'] = $this->genmod->getAll('provinces', '*');
    $this->genlib->ajaxOnly();
    $formdata = $this->input->post();
    // print_r$provinceId;
    $data['amphures'] = $this->genmod->getAll('amphures', '*', array('province_id'  => $formdata['provinceId']));
    // var_dump($formdata);
    // $json['body'] = $this->load->view('manage_aprtment/formadd', $data, true);
    // $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
    // <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
  }
  public function get_districts()
  {
    // $json['title'] = 'แบบฟอร์มการเพิ่มหอพักใหม่';
    // $data['provinces'] = $this->genmod->getAll('provinces', '*');
    $this->genlib->ajaxOnly();
    $formdata = $this->input->post();
    // print_r$provinceId;
    $data['districts'] = $this->genmod->getAll('districts', '*', array('amphure_id'  => $formdata['amphure_id']));
    // var_dump($formdata);
    // $json['body'] = $this->load->view('manage_aprtment/formadd', $data, true);
    // $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
    // <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
  }
  public function getSetForm()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $json['title'] = 'การตั้งค่าหอพัก';
    $data['getData'] = $this->genmod->getAll('s_admin_confit', '*', array('ac_a_id' => $formData['a_id']));
    $data['getData_partment'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $formData['a_id']));
    $json['body'] = $this->load->view('setting/setting', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveForm(' . $formData['a_id'] . ');">บันทึก</button>' .
      '<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function getEditForm()
  {
    $json['title'] = 'แก้ไขรายละเอียดหอพัก';
    $data['getData'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $this->input->post('a_id')));
    $data['provinces'] = $this->genmod->getAll('provinces', '*');
    $data['amphures'] = $this->genmod->getOne('amphures', '*', array('province_id'  => $data['getData']->a_povince_id, 'id' => $data['getData']->a_amphure_id));
    // $data['districts'] = $this->genmod->getAll('districts', '*', array('amphure_id'  => $formdata['amphure_id']));
    $data['districts'] = $this->genmod->getOne('districts', '*', array('amphure_id'  => $data['getData']->a_amphure_id, 'id' => $data['getData']->a_district_id));
    // $data['getData_user'] = $this->genmod->getAll('users', '*');
    // $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*');
    // $data[ 'getData' ]->iframe = addslashes($data[ 'getData' ]->iframe);
    // var_dump($data);
    $json['body'] = $this->load->view('manage_aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveeEditFormSubmit(' . $this->input->post('a_id') . ');">บันทึก</button>
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
    if ($this->genmod->update('s_apartment', $updateData, array('a_id' => ($updateData['a_id'])))) {
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
    // if ($this->genmod->update('users', array('password' => password_hash($updateData['newPass'], PASSWORD_BCRYPT), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('user_id' => $updateData['user_id']))) {

    $json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
    // } else {
    //   $json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
    // }
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
}
