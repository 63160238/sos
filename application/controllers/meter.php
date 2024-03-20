<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meter extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
  }

  public function power_meter()
  {
    if ($_SESSION['user_role'] > 1) {
      $values['pageTitle'] = 'จัดการมิเตอร์ไฟฟ้า';
      $values['breadcrumb'] = 'จัดการมิเตอร์ไฟฟ้า';
      $values['newBtn'] = 'เพิ่มมิเตอร์ไฟฟ้า';
      $data['filterApartment'] = $this->genlib->filterApartment();
      $data['floor'] = $this->genmod->getAll('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
      $values['pageContent'] = $this->load->view('meter_a/p_meter/index', $data, TRUE);
      $this->load->view('main', $values);
    } else {
      echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
    }
  }
  public function water_meter()
  {
    if ($_SESSION['user_role'] > 1) {
      $values['pageTitle'] = 'จัดการมิเตอร์นำ้';
      $values['breadcrumb'] = 'จัดการมิเตอร์นำ้';
      $values['newBtn'] = 'เพิ่มมิเตอร์นำ้';
      $data['filterApartment'] = $this->genlib->filterApartment();
      $data['floor'] = $this->genmod->getAll('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
      $values['pageContent'] = $this->load->view('meter_a/w_meter/index', $data, TRUE);
      $this->load->view('main', $values);
    } else {
      echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
    }
  }
  public function get_power()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    if (isset($formData['a_id'])) {
      $_SESSION['user_a_id'] = $formData['a_id'];
    }
    if (!empty($formData) && $formData['a_floor'] != "0") {
      $data['getData_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id'], 'r_floor' => $formData['a_floor']));
    } else {
      $data['getData_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']));
    }
    if (isset($formData['status']) && $formData['status'] != "all") {
      $data['getData'] = $this->genmod->getAll('s_power_meter', '*', array('p_a_id' => $_SESSION['user_a_id'], 'P_satatus' => $formData['status']));
    } else {
      $data['getData'] = $this->genmod->getAll('s_power_meter', '*', array('p_a_id' => $_SESSION['user_a_id']));
    }

    $json['html'] = $this->load->view('meter_a/p_meter/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function get_water()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    if (isset($formData['a_id'])) {
      $_SESSION['user_a_id'] = $formData['a_id'];
    }
    if (!empty($formData) && $formData['a_floor'] != "0") {
      $data['getData_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id'], 'r_floor' => $formData['a_floor']));
    } else {
      $data['getData_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']));
    }
    if (isset($formData['status']) && $formData['status'] != "all") {
      $data['getData'] = $this->genmod->getAll('s_water_meter', '*', array('w_a_id' => $_SESSION['user_a_id'], 'w_status' => $formData['status']));
    } else {
      $data['getData'] = $this->genmod->getAll('s_water_meter',  '*', array('w_a_id' => $_SESSION['user_a_id']));
    }
    $json['html'] = $this->load->view('meter_a/w_meter/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function add_power()
  {
    $this->genlib->ajaxOnly();
    $Data = $this->input->post();
    // var_dump($Data);
    $Data['formData']['p_a_id'] = $_SESSION['user_a_id'];
    $this->genmod->add('s_power_meter', $Data['formData']);
    $meter = $this->genmod->getOne('s_power_meter', "p_id", array('p_name' => $Data['formData']['p_name']));
    $this->genmod->update('s_room', array('r_p_id' => $meter->p_id), array('r_id' => $Data['r_id']));
    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function add_water()
  {
    $this->genlib->ajaxOnly();
    $Data = $this->input->post();
    $this->genmod->add('s_water_meter', $Data['formData']);
    $meter = $this->genmod->getOne('s_water_meter', "w_id", array('w_name' => $Data['formData']['w_name']));
    $this->genmod->update('s_room', array('r_w_id' => $meter->w_id), array('r_id' => $Data['r_id']));
    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function edit_power()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $this->genmod->update('s_power_meter', $formData, array('p_id' => $formData['p_id']));
    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function edit_water()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $this->genmod->update('s_water_meter', $formData, array('w_id' => $formData['w_id']));
    $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  // public function getAddForm()
  // {
  //   $json['title'] = 'แบบฟอร์มการเพิ่มผู้ใช้งานใหม่';
  //   $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
  //   $json['body'] = $this->load->view('aprtment/formadd', $data, true);
  //   $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
  // 	<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
  //   $this->output->set_content_type('application/json')->set_output(json_encode($json));
  // }
  public function getForm_power()
  {
    $json['title'] = 'ข้อมูลการมิเตอร์ไฟฟ้า';
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $data['getData'] = $this->genmod->getOne('s_power_meter', '*', array('p_id' => $formData['p_id']));
    $data['apartment_room'] = $this->genmod->getAll(
      's_room',
      '*',
      array(
        'r_a_id' => $_SESSION['user_a_id'],
        'r_p_id' => $data['getData']->p_id
      )
    );
    $json['body'] = $this->load->view('meter_a/p_meter/formadd', $data, true);
    $json['footer'] = '<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function getForm_water()
  {
    $json['title'] = 'ข้อมูลการมิเตอร์นำ้';
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $data['getData'] = $this->genmod->getOne('s_water_meter', '*', array('w_id' => $formData['w_id']));
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $data['apartment_room'] = $this->genmod->getAll(
      's_room',
      '*',
      array(
        'r_a_id' => $_SESSION['user_a_id'],
        'r_w_id' => $data['getData']->w_id
      )
    );
    $json['body'] = $this->load->view('meter_a/w_meter/formadd', $data, true);
    $json['footer'] = '<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function getAddForm_power()
  {
    $json['title'] = 'แบบฟอร์มการเพิ่มมิเตอร์ไฟฟ้าใหม่';
    $data['apartment_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id'], 'r_p_id' => null));
    $json['body'] = $this->load->view('meter_a/p_meter/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function getAddForm_water()
  {
    $json['title'] = 'แบบฟอร์มการเพิ่มมิเตอร์นำ้ใหม่';
    $data['apartment_room'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id'], 'r_w_id' => null));
    $json['body'] = $this->load->view('meter_a/w_meter/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function getEditForm_power()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $json['title'] = 'แก้ไขรายละเอียดมิเตอร์ไฟ';
    $data['getData'] = $this->genmod->getOne('s_power_meter', '*', array('p_id' => $formData['p_id']));
    // $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    // $data[ 'apartment_room' ] = $this->genmod->getAll(
    //   's_room',
    //   '*',
    //   array(
    //     'r_a_id' => $_SESSION[ 'user_a_id' ],
    //     'r_p_id' => null
    //   )
    // );
    $data['apartment_room'] = $this->genmod->getAll(
      's_room',
      '*',
      "r_a_id = '{$_SESSION['user_a_id']}' AND (r_p_id IS NULL OR r_p_id = '{$data['getData']->p_id}')"
    );
    // $data['room'] = $this->genmod->getOne(
    //   's_room',
    //   '*',
    //   array(
    //       'r_a_id' => $_SESSION['user_a_id'],
    //       'r_p_id' => $data['getData']->p_id
    //   )
    // );
    $json['body'] = $this->load->view('meter_a/p_meter/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormEditSubmit(' . $this->input->post('p_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function getEditForm_water()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $json['title'] = 'แก้ไขรายละเอียดมิเตอร์นำ้';
    $data['getData'] = $this->genmod->getOne('s_water_meter', '*', array('w_id' => $formData['w_id']));
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $data['apartment_room'] = $this->genmod->getAll(
      's_room',
      '*',
      "r_a_id = '{$_SESSION['user_a_id']}' AND (r_p_id IS NULL OR r_p_id = '{$data['getData']->w_id}')"
    );
    $json['body'] = $this->load->view('meter_a/w_meter/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormEditSubmit(' . $this->input->post('w_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function updateStatus_power()
  {
    // Ensure the request is an AJAX request
    $this->genlib->ajaxOnly();

    // Get the data from the POST request
    $updateData = $this->input->post();
    if ($this->genmod->getAll('s_room', '*', array('r_p_id' => $updateData['p_id']))) {
      $json = ['status' => 0, 'msg' => "ไม่สามารถระงับการใช้งานได้ เนื่องจากมีการใช้งานมิเตอร์ตัวนี้อยู่"];
    } else {
      // Update the 'p_status' field in the 's_power_meter' table based on the received data
      if ($this->genmod->getAll('s_power_meter', '*', array('P_status !=' => 0,'p_id'=>$updateData['p_id'])) && $this->genmod->update('s_power_meter', array('P_satatus' => ($updateData['p_status'] == 0 ? '1' : '0')), array('p_id' => $updateData['p_id']))) {
        // If the update was successful, prepare a success message
        $json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
      } else {
        // If there was an issue with the update, prepare an error message
        $json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
      }
      // Set the content type to JSON and output the result
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function updateStatus_water()
  {
    // Ensure the request is an AJAX request
    $this->genlib->ajaxOnly();

    // Get the data from the POST request
    $updateData = $this->input->post();

    if ($this->genmod->getAll('s_water_meter', '*', array('w_status !=' => 0,'w_id'=>$updateData['w_id'])) && $this->genmod->getAll('s_room', '*', array('r_w_id' => $updateData['w_id']))) {
      $json = ['status' => 0, 'msg' => "ไม่สามารถระงับการใช้งานได้ เนื่องจากมีการใช้งานมิเตอร์ตัวนี้อยู่"];
    } else {
      // Update the 'p_status' field in the 's_power_meter' table based on the received data
      if ($this->genmod->update('s_water_meter', array('w_status' => ($updateData['w_status'] == 0 ? '1' : '0')), array('w_id' => $updateData['w_id']))) {
        // If the update was successful, prepare a success message
        $json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
      } else {
        // If there was an issue with the update, prepare an error message
        $json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่ปรับปรุงสถานะการใช้งาน ได้"];
      }
    }
    // Set the content type to JSON and output the result
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
