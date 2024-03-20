<?php

use function PHPSTORM_META\type;

defined('BASEPATH') or exit('No direct script access allowed');


class Manege_Apartment extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
  }
  public function index()
  {
    if ($_SESSION['user_role'] == 3) {
      $values['pageTitle'] = 'จัดการหอพัก';
      $values['breadcrumb'] = 'จัดการหอพัก';
      $values['newBtn'] = 'เพิ่มหอพักใหม่';
      $values['pageContent'] = $this->load->view('manage_aprtment/index', "", TRUE);
      $this->load->view('main', $values);
    } else {
      echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
    }
  }

  public function get()
  {
    $data['getData'] = $this->genmod->getAll('s_apartment', '*', array('a_status' => '1'), 'a_id desc');
    $data['room_sum'] = $this->genmod->getAll('s_room', 'count(r_id)');
    $data['apartment_room'] = $this->genmod->getAll('s_room', '*');
    // ตัวแปรเก็บค่า r_a_id ที่ซ้ำกัน
    $r_a_id_counts = array();
    if ($data['apartment_room']) {
      foreach ($data['apartment_room'] as $record) {
        $r_a_id = $record->r_a_id;
        if (!isset($r_a_id_counts[$r_a_id])) {
          $r_a_id_counts[$r_a_id] = 1;
        } else {
          $r_a_id_counts[$r_a_id]++;
        }
      }
    }
    if ($data['getData']) {
      foreach ($data['getData'] as $a) {
        $found = false;
        foreach ($r_a_id_counts as $r_a_id => $count) {
          if ($a->a_id == $r_a_id) {
            $data['room'][] = array(
              'r_a_id' => $r_a_id,
              'count' => $count
            );
            $found = true;
            break; // พบข้อมูลที่ตรงกัน จึงไม่ต้องทำการวนลูปต่อ
          }
        }
        if (!$found) {
          // หากไม่พบข้อมูลที่ตรงกันใน $r_a_id_counts ให้กำหนด count เป็น 0
          $data['room'][] = array(
            'r_a_id' => $a->a_id,
            'count' => 0
          );
        }
        $apartment_admin = $this->genmod->getAll('users', '*', array('FIND_IN_SET(' . $a->a_id . ', user_a_id) >' => 0, 'status' => 1, 'role' => 2));
        if ($apartment_admin) {
          foreach ($apartment_admin as $admin) {
            $a->admin[] = $admin->prename . " " . $admin->fname_th . " " . $admin->lname_th . "    " . $admin->position;
          }
        }
      }
    }
    // นับจำนวน r_a_id ที่ซ้ำกัน
    $json['html'] = $this->load->view('manage_aprtment/list', $data, TRUE);
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

    for ($i = 1; $i <= $formData['a_floor']; $i++) {
      for ($j = 1; $j <= $formData['a_room']; $j++) {
        $power['p_name'] = "P" . $i . "" . sprintf("%02d", $j);
        $water['w_name'] = "w" . $i . "" . sprintf("%02d", $j);
        $power['p_a_id'] = $formData['id']['a_id'];
        $water['w_a_id'] = $formData['id']['a_id'];
        $power['P_satatus'] = 1;
        $water['w_status'] = 1;
        // $room['r_id'] = uniqid();
        $this->genmod->add('s_power_meter', $power);
        $this->genmod->add('s_water_meter', $water);
      }
    }
    $Pdata = $this->genmod->getAll('s_power_meter', 'p_id', array('p_a_id' => $power['p_a_id']));
    $Wdata = $this->genmod->getAll('s_water_meter', 'w_id', array('w_a_id' => $water['w_a_id']));
    $PnewData = array(); // สร้างอาเรย์ใหม่สำหรับเก็บข้อมูลที่จัดรูปแบบใหม่
    $WnewData = array(); // สร้างอาเรย์ใหม่สำหรับเก็บข้อมูลที่จัดรูปแบบใหม่
    $floorCount = $formData['a_floor']; // จำนวนชั้น
    $roomCount = $formData['a_room']; // จำนวนห้องในแต่ละชั้น
    for ($i = 1; $i <= $floorCount; $i++) {
      $powerData = array(); // สร้างอาเรย์สำหรับเก็บข้อมูลของมิเตอร์ไฟฟ้าในแต่ละชั้น
      $waterData = array(); // สร้างอาเรย์สำหรับเก็บข้อมูลของมิเตอร์น้ำในแต่ละชั้น
      for ($j = 1; $j <= $roomCount; $j++) {
        // เข้าถึงค่า r_p_id และ r_w_id จากอาเรย์ $Pdata และ $Wdata
        $r_p_id = $Pdata[($i - 1) * $roomCount + $j - 1]->p_id;
        $r_w_id = $Wdata[($i - 1) * $roomCount + $j - 1]->w_id;
        $powerData[] = $r_p_id; // เพิ่มค่า r_p_id ลงในอาเรย์ของชั้น
        $waterData[] = $r_w_id; // เพิ่มค่า r_w_id ลงในอาเรย์ของชั้น
      }
      $PnewData[$i] = $powerData; // เพิ่มข้อมูลของแต่ละชั้นลงในอาเรย์ใหม่
      $WnewData[$i] = $waterData; // เพิ่มข้อมูลของแต่ละชั้นลงในอาเรย์ใหม่
    }
    for ($i = 1; $i <= $formData['a_floor']; $i++) {
      for ($j = 1; $j <= $formData['a_room']; $j++) {
        $room['r_name'] = $i . "" . sprintf("%02d", $j);
        $room['r_floor'] = $i;
        $room['r_a_id'] = $formData['id']['a_id'];
        $room['r_type'] = 1;
        $room['r_duedate'] = 0;
        $room['r_lateday'] = 0;
        $room['r_p_id'] = $PnewData[$i][$j - 1];
        $room['r_w_id'] = $WnewData[$i][$j - 1];
        $this->genmod->add('s_room', $room);
      }
    }
    $type['ac_a_id'] = $room['r_a_id'];
    $type['ac_type_cost'] = 0;
    $type['ac_type_id'] = $room['r_type'];
    $type['ac_type_name'] = "default_type";
    $this->genmod->add('s_admin_confit', $type);
    $R_data = $this->genmod->getAll('s_room', 'r_id', array('r_a_id' => $room['r_a_id']));
    for ($i = 0; $i < count($R_data); $i++) {
      $bill['bil_r_id'] = $R_data[$i]->r_id;
      $bill['bill_a_id'] = $room['r_a_id'];
      $bill['bill_mg_status'] = 1;
      $this->genmod->add('s_bill', $bill);
    }
    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  // public function add_power()
  // {
  //   $this->genlib->ajaxOnly();
  //   $formData = $this->input->post();
  //   // for ($i=1; $i <=$formData['a_floor'] ; $i++) { 
  //   //   for ($j=1; $j <=$formData['a_room'] ; $j++) {
  //   //     $room['r_name']= $i . "" . sprintf("%02d",$j);
  //   //     $room[ 'r_floor' ] = $i;
  //   //     $room[ 'r_a_id' ] = $formData['id']['a_id'];
  //   //     $room[ 'r_type' ] = 1;
  //   //     // $room['r_id'] = uniqid();
  //   //     $this->genmod->add('s_room',$room);  
  //   //   }
  //   // }
  //   for ($i = 1; $i < $formData['a_floor']; $i++) {
  //     for ($j = 1; $j <= $formData['a_room']; $j++) {
  //       $power['p_name'] = "P".$i . "" . sprintf("%02d", $j);
  //       // $room['r_floor'] = $i;
  //       $power['p_a_id'] = $formData['id']['a_id'];
  //       $power['P_satatus'] = 1;
  //       // $room['r_id'] = uniqid();
  //       $this->genmod->add('s_power_meter', $power);
  //     }
  //   } 
  //   // $data=$this->genmod->getAll('s_power_meter','p_id',array('p_a_id'=>$_SESSION['user_a_id']));
  //   // var_dump($data);
  //   // for ($i=1; $i <=$formData['a_floor'] ; $i++) { 
  //   //   for ($j=1; $j <=$formData['a_room'] ; $j++) {
  //   //     $room['r_name']= $i . "" . sprintf("%02d",$j);
  //   //     $room[ 'r_floor' ] = $i;
  //   //     $room[ 'r_a_id' ] = $formData['id']['a_id'];
  //   //     $room[ 'r_type' ] = 1;
  //   //     // $room['r_id'] = uniqid();
  //   //     $this->genmod->add('s_room',$room);  
  //   //   }
  //   // }
  //   $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
  //   $this->output->set_content_type('application/json')->set_output(json_encode($json));
  // }
  public function edit()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $this->genmod->update('s_apartment', $formData, array('a_id' => $formData['a_id']));
    $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function getAddForm()
  {
    $json['title'] = 'แบบฟอร์มการเพิ่มหอพักใหม่';
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $json['body'] = $this->load->view('manage_aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function get_amphures()
  {
    // $json['title'] = 'แบบฟอร์มการเพิ่มหอพักใหม่';
    // $data['provinces'] = $this->genmod->getAll('provinces', '*');
    $this->genlib->ajaxOnly();
    $formdata = $this->input->post();
    // print_r$provinceId;
    $data['amphures'] = $this->genmod->getAll('amphures', '*', array('province_id' => $formdata['provinceId']));
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
    $data['districts'] = $this->genmod->getAll('districts', '*', array('amphure_id' => $formdata['amphure_id']));
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
    // $data['provinces'] = $this->genmod->getAll('provinces', '*');
    // $data['amphures'] = $this->genmod->getOne('amphures', '*', array('province_id' => $data['getData']->a_povince_id, 'id' => $data['getData']->a_amphure_id));
    // // $data['districts'] = $this->genmod->getAll('districts', '*', array('amphure_id'  => $formdata['amphure_id']));
    // $data['districts'] = $this->genmod->getOne('districts', '*', array('amphure_id' => $data['getData']->a_amphure_id, 'id' => $data['getData']->a_district_id));
    // // $data['getData_user'] = $this->genmod->getAll('users', '*');
    // // $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*');
    // // $data[ 'getData' ]->iframe = addslashes($data[ 'getData' ]->iframe);
    // // var_dump($data);
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
    if ($this->genmod->getAll('users', '*', array('status' => 1, 'role' => 2, 'FIND_IN_SET(' .  $updateData['a_id'] . ', user_a_id) >' => 0)) || $this->genmod->getAll('s_room', '*', array('r_a_id' => $updateData['a_id'], 'r_u_id !=' => null))) {
      $json = ['status' => 0, 'msg' => "ไม่สามารถลบหอพักได้ เนื่องจากหอพักมีการใช้งานอยู่"];
    } else {
      if ($updateData['a_status'] == 0) {
        $user = $this->genmod->getAll('users', '*', array('role' => 2, 'FIND_IN_SET(' . $updateData['a_id'] . ',user_a_id) >' => 0));
        if ($user) {
          foreach ($user as $u) {
            $user_a_id_string = $u->user_a_id;
            $explode_a_id[] = explode(',', $user_a_id_string);
            foreach ($explode_a_id as $key => $id) {
              if ($id[$key] !== $updateData['a_id']) {
                $a_id[] = $id[$key];
              }
            }
            $user_a_id = implode(",", $a_id);
            $this->genmod->update('users', array('user_a_id'=>$user_a_id), array('user_id' =>$u->user_id));
          }
        }
        $this->genmod->update('s_apartment', $updateData, array('a_id' => ($updateData['a_id'])));
        $json = ['status' => 1, 'msg' => "ปรับปรุงสถานะการใช้งาน เรียบร้อย"];
      }
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
