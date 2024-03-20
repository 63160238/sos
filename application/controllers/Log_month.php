<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_month extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
  }

  public function index()
  {
    $values['pageTitle'] = 'ประวัติการใช้น้ำ ใช้ไฟ';
    $values['breadcrumb'] = 'ประวัติการใช้น้ำ ใช้ไฟ';
    $values['pageContent'] = $this->load->view('log_month/index', "", TRUE);
    $this->load->view('main', $values);
  }

  public function get()
  {
    $room = $this->genmod->getOne('s_room', '*', array('r_u_id' => $_SESSION['user_id']));
    $data['config'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
    if ($room) {
      $postData = $this->input->post();
      if ($postData) {
        $filterYear = $postData['filterYear'];
        $data['select'] = $postData['filterYear'];
      } else {
        $filterYear = date('Y');
      }
      $whereWm = array('bil_r_id' => $room->r_id, 'bill_a_id' => $room->r_a_id, 'YEAR(bill_updete_at)' => $filterYear, 'bill_mg_status' => 1);
      $getLm = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $whereWm, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
      if ($getLm) {
        foreach ($getLm as $value) {
          $getBill[] = $this->genmod->getOne('s_bill', "*", array('bill_updete_at' => $value->date));
        }
      }else{
        $getBill = [];
      }
      $count = count($getBill);
      $whereM = array('bil_r_id' => $room->r_id, 'bill_a_id' => $room->r_a_id, 'YEAR(bill_updete_at)' => $filterYear - 1, 'MONTH(bill_updete_at)' => 12, 'bill_mg_status' => 1);
      $getLm = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $whereM, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
      if ($getLm) {
        foreach ($getLm as $value) {
          $getMonth[] = $this->genmod->getOne('s_bill', "*", array('bill_updete_at' => $value->date));
        }
      }else{
        $getMonth = [];
      }
      $whereCp = array('p_id' => $room->r_p_id);
      $getCp = $this->genmod->getOne('s_power_meter', "*", $whereCp);
      $whereCw = array('w_id' => $room->r_w_id);
      $getCw = $this->genmod->getOne('s_water_meter', "*", $whereCw);
      for ($i = 0; $i < $count; $i++) {
        if ($i != 0) {
          $getBill[$i]->bill_p_khw = $getBill[$i]->bill_p_khw -  $getBill[$i - 1]->bill_p_khw;
          $getBill[$i]->bill_w_flow = $getBill[$i]->bill_w_flow - $getBill[$i - 1]->bill_w_flow;
        } {
          if ($getMonth) {
            $getBill[$i]->bill_p_khw = $getBill[$i]->bill_p_khw -  $getMonth->bill_p_khw;
            $getBill[$i]->bill_w_flow = $getBill[$i]->bill_w_flow - $getMonth->bill_w_flow;
          }
        }
      }
      $data['filterYear'] = $this->filterYear($room->r_id);

      $data['history'] = $getBill;
    }
    $json['html'] = $this->load->view('log_month/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function filterYear($r_id)
  {
    $getData = $this->genmod->getAll('s_bill', 'YEAR(bill_updete_at) as year,MONTH(bill_updete_at) as month', array('bil_r_id' => $r_id), "YEAR(bill_updete_at) DESC", "", 'YEAR(bill_updete_at)');
    $result = [];
    if ($getData) {
      foreach ($getData as $value) {
        $result[] = $value->year;
      }
    }
    return $result;
  }
  public function add()
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
    $this->genmod->update('s_room', $formData, array('r_id' => $formData['r_id']));
    $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
    //   }
    // } else {
    //   $json = ['status' => 0, 'msg' => "พบปัญหา ข้อมูลมีความผิดพลาด เพิ่มข้อมูลไม่สำเร็จ ", 'error' => $this->form_validation->error_array()];
    // }

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
}
