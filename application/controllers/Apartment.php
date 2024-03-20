<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apartment extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->genlib->checkLogin();
    $this->genlib->update_pay_status();
  }

  public function index()
  {
    if ($_SESSION['user_role'] > 1) {
      $values['pageTitle'] = 'จัดการห้องพัก';
      $values['breadcrumb'] = 'จัดการห้องพัก';
      $values['newBtn'] = 'เพิ่ม-ลด หอพัก';
      $data['filterApartment'] = $this->genlib->filterApartment();
      $data['floor'] = $this->genmod->getAll('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
      $values['pageContent'] = $this->load->view('aprtment/index', $data, TRUE);
      $this->load->view('main', $values);
    } else {
      echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
    }
  }

  public function get()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    if (isset($formData['a_id'])) {
      $_SESSION['user_a_id'] = $formData['a_id'];
    }
    if (!empty($formData) && $formData['a_floor'] != "0") {
      $data['getData'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id'], 'r_floor' => $formData['a_floor']));
    } else {
      $data['getData'] = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']));
    }
    $data['color'] = ['', 'text-warning', 'text-success', 'text-danger'];
    $data['getData_Apamet'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
    $data['getData_user'] = $this->genmod->getAll('users', '*');
    foreach ($data['getData'] as $key => $value) {
      $data_month = $this->genmod->getOne('s_bill', '*', array('bill_a_id' => $value->r_a_id, 'bil_r_id' => $value->r_id, 'bill_mg_status' => 1), 'bill_updete_at DESC');
      $cp = $this->genmod->getOne('s_power_meter', '*', array('p_id' => $value->r_p_id));
      $cw = $this->genmod->getOne('s_water_meter', '*', array('w_id' => $value->r_w_id));
      if (!isset($data['getData_power_now'][$key])) {
        $data['getData_power_now'][$key] = new stdClass();
      }
      if (!isset($data['getData_water_now'][$key])) {
        $data['getData_water_now'][$key] = new stdClass();
      }
      $data['getData_power_now'][$key]->bil_r_id = $value->r_id;
      $data['getData_water_now'][$key]->bil_r_id = $value->r_id;
      $data['getData_power_now'][$key]->p_kwh = 0;
      $data['getData_water_now'][$key]->w_flow_sum = 0;
      if ($data_month) {
        if ($cp && $cp->p_kwh != 0) {
          $data['getData_power_now'][$key]->p_kwh = round($cp->p_kwh - $data_month->bill_p_khw_moth, 2);
        } else {
          $data['getData_power_now'][$key]->p_kwh = round($data_month->bill_p_khw_moth, 2);
        }
        if ($cw && $cp->p_kwh != 0) {
          $data['getData_water_now'][$key]->w_flow_sum = round($cw->w_flow_sum - $data_month->bill_w_flow_month, 2);
        } else {
          $data['getData_water_now'][$key]->w_flow_sum = round($data_month->bill_w_flow_month, 2);
        }
      } else {
        if ($cp) {
          $data['getData_power_now'][$key]->p_kwh = round($cp->p_kwh, 2);
        }
        if ($cw) {
          $data['getData_water_now'][$key]->w_flow_sum = round($cw->w_flow_sum, 2);
        }
      }
    }
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $json['html'] = $this->load->view('aprtment/list', $data, TRUE);
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function add()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    $formData['r_a_id'] = $_SESSION['user_a_id'];
    unset($formData['r_id']);
    $this->genmod->add('s_room', $formData);
    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function edit_room()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();

    foreach ($formData as $key => $value) {
      foreach ($value as $key => $data) {
        if ($data['r_name'] || $data['r_name']) {
          $this->genmod->update('s_room', array('r_name' => $data['r_name']), array('r_id' => $data['r_id']));
        }
        if ($data['ac_type_id']) {
          $this->genmod->update('s_room', array('r_type' => $data['ac_type_id']), array('r_id' => $data['r_id']));
        }
      }
    }

    $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  // public function update_formroom()
  // {
  //   $this->genlib->ajaxOnly();
  //   $data = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION[ 'user_a_id' ]));
  //   $R = []; // Initialize the array
  //   foreach ($data as $key => $value) {
  //     if (isset($R[ $value->r_floor ])) {
  //       // Increment the count if the key exists
  //       $R[ $value->r_floor ]++;
  //     } else {
  //       // Initialize the count to 1 if the key doesn't exist
  //       $R[ $value->r_floor ] = 1;
  //     }
  //   }
  //   $formData = $this->input->post();
  //   foreach ($formData as $key => $value) {
  //     foreach ($value as $key => $value2) {
  //       for ($i = 1; $i <= $value2[ 'room' ]; $i++) {
  //         $room[ 'r_name' ] = $value2[ 'floor' ] . "" . sprintf("%02d", $i);
  //         $room[ 'r_floor' ] = $value2[ 'floor' ];
  //         $room[ 'r_a_id' ] = $_SESSION[ 'user_a_id' ];
  //         $power[ 'p_a_id' ] = $_SESSION[ 'user_a_id' ];
  //         $water[ 'w_a_id' ] = $_SESSION[ 'user_a_id' ];
  //         $power[ 'P_satatus' ] = 1;
  //         $water[ 'w_status' ] = 1;
  //         $water[ 'w_name' ] = "W" . $value2[ 'floor' ] . "" . sprintf("%02d", $i);
  //         $power[ 'p_name' ] = "P" . $value2[ 'floor' ] . "" . sprintf("%02d", $i);
  //         $room[ 'r_type' ] = 1;
  //         if ($room[ 'r_floor' ] > count($R)) {
  //           $this->genmod->add('s_room', $room);
  //           $this->genmod->add('s_power_meter', $power);
  //           $this->genmod->add('s_water_meter', $water);
  //           $Pdata = $this->genmod->getOne('s_power_meter', '*', array('p_name' => $power[ 'p_name' ], 'p_a_id' => $power[ 'p_a_id' ]));
  //           $Wdata = $this->genmod->getOne(
  //             's_water_meter',
  //             '*',
  //             array(
  //               'w_a_id' => $water[ 'w_a_id' ],
  //               'w_name' => $water[ 'w_name' ]
  //             )
  //           );
  //           $first_P = substr($Pdata->p_name, 0, 1);
  //           $first_w = substr($Wdata->w_name, 0, 1);
  //           $this->genmod->update('s_room', array('r_p_id' => $Pdata->p_id), array('r_a_id' => $room[ 'r_a_id' ], 'r_name' => $first_P));
  //           $this->genmod->update('s_room', array('r_w_id' => $Wdata->w_id), array('r_a_id' => $room[ 'r_a_id' ], 'r_name' => $first_w));
  //         } else {
  //           if ($value2[ 'room' ] > $R[ $room[ 'r_floor' ] ]) {

  //             if ($i > $R[ $room[ 'r_floor' ] ]) {
  //               $room[ 'r_name' ] = $value2[ 'floor' ] . "" . sprintf("%02d", $i);
  //               $this->genmod->add('s_room', $room);
  //               $this->genmod->add('s_power_meter', $power);
  //               $this->genmod->add('s_water_meter', $water);
  //               $Pdata = $this->genmod->getOne('s_power_meter', '*', array('p_name' => $power[ 'p_name' ], 'p_a_id' => $power[ 'p_a_id' ]));
  //               $Wdata = $this->genmod->getOne(
  //                 's_water_meter',
  //                 '*',
  //                 array(
  //                   'w_a_id' => $water[ 'w_a_id' ],
  //                   'w_name' => $water[ 'w_name' ]
  //                 )
  //               );
  //               $first_P = substr($Pdata->p_name, 0, 1);
  //               $first_w = substr($Wdata->w_name, 0, 1);
  //               $this->genmod->update('s_room', array('r_p_id' => $Pdata->p_id), array('r_a_id' => $room[ 'r_a_id' ], 'r_name' => $first_P));
  //               $this->genmod->update('s_room', array('r_w_id' => $Wdata->w_id), array('r_a_id' => $room[ 'r_a_id' ], 'r_name' => $first_w));
  //             }
  //           } elseif ($value2[ 'room' ] < $R[ $room[ 'r_floor' ] ]) {
  //             for ($j = $value2[ 'room' ]; $j <= $R[ $room[ 'r_floor' ] ]; $j++) {
  //               if ($j > $value2[ 'room' ]) {
  //                 $room[ 'r_name' ] = $value2[ 'floor' ] . "" . sprintf("%02d", $j);
  //                 $water[ 'w_name' ] = "W" . $value2[ 'floor' ] . "" . sprintf("%02d", $i);
  //                 $power[ 'p_name' ] = "P" . $value2[ 'floor' ] . "" . sprintf("%02d", $i);
  //                 $this->db->query("DELETE FROM s_power_meter WHERE p_a_id = '{$_SESSION[ 'user_a_id' ]}' AND p_name = '{$power[ 'p_name' ]}'");
  //                 $this->db->query("DELETE FROM s_water_meter WHERE w_a_id = '{$_SESSION[ 'user_a_id' ]}' AND w_name = '{$water[ 'w_name' ]}'");
  //                 $this->db->query("DELETE FROM s_room WHERE r_a_id = '{$_SESSION[ 'user_a_id' ]}' AND r_name = '{$room[ 'r_name' ]}'");
  //               }
  //             }
  //           }
  //         }
  //       }
  //     }
  //   }
  //   $room[ 'a_floor' ] = $room[ 'r_floor' ];
  //   $this->genmod->update(
  //     's_apartment',
  //     array('a_floor' => $room[ 'a_floor' ]),
  //     array('a_id' => $_SESSION[ 'user_a_id' ])
  //   );
  //   // print_r($formData['floor']); 
  //   // $formData['r_a_id'] = $_SESSION['user_a_id'];
  //   // unset($formData['r_id']);
  //   // $this->genmod->add('s_room', $formData);
  //   $json = [ 'status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ' ];
  //   $this->output->set_content_type('application/json')->set_output(json_encode($json));
  // }

  public function update_formroom()
  {
    $this->genlib->ajaxOnly();
    $data = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']), 'r_id ASC');
    $R = []; // Initialize the array
    foreach ($data as $key => $value) {
      if (isset($R[$value->r_floor])) {
        // Increment the count if the key exists
        $R[$value->r_floor]++;
      } else {
        // Initialize the count to 1 if the key doesn't exist
        $R[$value->r_floor] = 1;
      }
    }
    $formData = $this->input->post();
    $room = [];
    //เพิ่มชั่น
    if (count($R) < count($formData['tableData'])) {
      for ($i = count($R); $i <= count($formData['tableData']); $i++) {
        if ($i > count($R)) {
          for ($j = 0; $j < $formData['tableData'][$i - 1]['room']; $j++) {
            $room['r_name'] = $i . "" . sprintf("%02d", $j + 1);
            $room['r_floor'] = $i;
            $room['r_a_id'] = $_SESSION['user_a_id'];
            $power['p_a_id'] = $_SESSION['user_a_id'];
            $water['w_a_id'] = $_SESSION['user_a_id'];
            $power['P_satatus'] = 1;
            $water['w_status'] = 1;
            $water['w_name'] = "W" . $i . "" . sprintf("%02d", $j + 1);
            $power['p_name'] = "P" . $i . "" . sprintf("%02d", $j + 1);
            $room['r_type'] = 1;
            $this->genmod->add('s_power_meter', $power);
            $this->genmod->add('s_water_meter', $water);
            $room['r_p_id'] = $this->genmod->getOne('s_power_meter', 'p_id', array('p_name' => $power['p_name'], 'p_a_id' => $power['p_a_id']));
            $room['r_w_id'] = $this->genmod->getOne('s_water_meter', 'w_id', array('w_name' => $water['w_name'], 'w_a_id' => $water['w_a_id']));
            $room['r_p_id'] = $room['r_p_id']->p_id;
            $room['r_w_id'] = $room['r_w_id']->w_id;
            // $room[ 'r_p_id' ] =$p_id->$p_id;
            // $room[ 'r_w_id' ] =$w_id->$w_id;
            $this->genmod->add('s_room', $room);
            $R_data = $this->genmod->getOne('s_room', 'r_id', array('r_name' => $room['r_name'], 'r_a_id' => $room['r_a_id']));
            $bill['bil_r_id'] = $R_data->r_id;
            $bill['bil_r_id'] = $R_data->r_id;
            $bill['bill_a_id'] = $room['r_a_id'];
            $bill['bill_mg_status'] = 1;
            $this->genmod->add('s_bill', $bill);
          }
        }
      }
      $this->genmod->update('s_apartment', array('a_floor' => $room['r_floor']), array('a_id' => $room['r_a_id']));
    } else if (count($R) == count($formData['tableData'])) {
      for ($i = 1; $i <= count($R); $i++) {
        if (isset($formData['tableData'][$i - 1]['room']) && isset($R[$i]) && $formData['tableData'][$i - 1]['room'] > $R[$i]) {
          // echo $formData[ 'tableData' ][ $i - 1 ][ 'room' ];
          for ($j = $R[$i]; $j <= $formData['tableData'][$i - 1]['room']; $j++) {
            if ($j != $R[$i]) {
              $room['r_name'] = $i . "" . sprintf("%02d", $j);
              $room['r_floor'] = $i;
              $room['r_a_id'] = $_SESSION['user_a_id'];
              $power['p_a_id'] = $_SESSION['user_a_id'];
              $water['w_a_id'] = $_SESSION['user_a_id'];
              $power['P_satatus'] = 1;
              $water['w_status'] = 1;
              $water['w_name'] = "W" . $i . "" . sprintf("%02d", $j);
              $power['p_name'] = "P" . $i . "" . sprintf("%02d", $j);
              $room['r_type'] = 1;
              $this->genmod->add('s_power_meter', $power);
              $this->genmod->add('s_water_meter', $water);
              $room['r_p_id'] = $this->genmod->getOne('s_power_meter', 'p_id', array('p_name' => $power['p_name'], 'p_a_id' => $power['p_a_id']));
              $room['r_w_id'] = $this->genmod->getOne('s_water_meter', 'w_id', array('w_name' => $water['w_name'], 'w_a_id' => $water['w_a_id']));
              $room['r_p_id'] = $room['r_p_id']->p_id;
              $room['r_w_id'] = $room['r_w_id']->w_id;
              // $room[ 'r_p_id' ] =$p_id->$p_id;
              // $room[ 'r_w_id' ] =$w_id->$w_id;
              $this->genmod->add('s_room', $room);
              $R_data = $this->genmod->getOne('s_room', 'r_id', array('r_name' => $room['r_name'], 'r_a_id' => $room['r_a_id']));
              $bill['bil_r_id'] = $R_data->r_id;
              $bill['bill_a_id'] = $room['r_a_id'];
              $bill['bill_mg_status'] = 1;
              $this->genmod->add('s_bill', $bill);
            }
            //เพิ่มห้อง
          }
          //ลดห้อง
        } else if (isset($formData['tableData'][$i - 1]['room']) && isset($R[$i]) && $formData['tableData'][$i - 1]['room'] < $R[$i]) {
          for ($j = $formData['tableData'][$i - 1]['room']; $j <= $R[$i]; $j++) {
            if ($j > $formData['tableData'][$i - 1]['room']) {
              $room['r_name'] = $i . "" . sprintf("%02d", $j);
              $water['w_name'] = "W" . $i . "" . sprintf("%02d", $j);
              $power['p_name'] = "P" . $i . "" . sprintf("%02d", $j);
              $this->db->query("DELETE FROM s_room WHERE r_a_id = '{$_SESSION['user_a_id']}' AND r_name = '{$room['r_name']}'");
              $this->db->query("DELETE FROM s_power_meter WHERE p_a_id = '{$_SESSION['user_a_id']}' AND p_name = '{$power['p_name']}'");
              $this->db->query("DELETE FROM s_water_meter WHERE w_a_id = '{$_SESSION['user_a_id']}' AND w_name = '{$water['w_name']}'");
            }
          }
        };
        //ลดห้อง
      }
    }
    if (count($R) > count($formData['tableData'])) {
      $index = 0;
      for ($i = count($formData['tableData']); $i <= count($R); $i++) {
        if ($i > count($formData['tableData'])) {
          for ($j = 0; $j < $R[$i]; $j++) {
            $room['r_name'] = $i . "" . sprintf("%02d", $j + 1);
            $room['r_a_id'] = $_SESSION['user_a_id'];
            $water['w_name'] = "W" . $i . "" . sprintf("%02d", $j);
            $power['p_name'] = "P" . $i . "" . sprintf("%02d", $j);
            $this->db->query("DELETE FROM s_room WHERE r_a_id = '{$_SESSION['user_a_id']}' AND r_name = '{$room['r_name']}'");
            $this->db->query("DELETE FROM s_power_meter WHERE p_a_id = '{$_SESSION['user_a_id']}' AND p_name = '{$power['p_name']}'");
            $this->db->query("DELETE FROM s_water_meter WHERE w_a_id = '{$_SESSION['user_a_id']}' AND w_name = '{$water['w_name']}'");
            $count[$index] = $i;
            $index++;
          }
        }
      }
      if($index > 1){
        $room['r_floor'] = $count[$index-1] - ($count[$index-2]-1) ;
      }else{
        $room['r_floor'] = $count[$index-1] - 1;
      }
      $this->genmod->update('s_apartment', array('a_floor' => $room['r_floor']), array('a_id' => $room['r_a_id']));
    }
    $json = ['status' => 1, 'msg' => 'แก้ไขข้อมูลสำเร็จ'];
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function update()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
    if (isset($formData['r_u_id']) && $formData['r_u_id'] == "") {
      $formData['r_u_id'] = null;
    }
    unset($formData['a_id']);
    unset($formData['bill_id']);
    if ($this->genmod->update('s_room', $formData, array('r_id' => $formData['r_id']))) {
      if (isset($formData['pay_status'])) {
        $lastbill = $this->genmod->getOne('s_bill','MAX(bill_updete_at) as max', array('bil_r_id' => $formData['r_id'],'bill_mg_status'=>1));
        $this->genmod->update('s_bill', array('bill_status' => $formData['pay_status']), array('bil_r_id' => $formData['r_id'],'bill_updete_at'=>$lastbill->max));
      }
      $json = ['status' => 1, 'msg' => "ปรับปรุงรายละเอียดห้องพัก เรียบร้อย"];
    } else {
      $json = ['status' => 0, 'msg' => "พบปัญหาบางอย่าง ไม่สามารถปรับปรุงรายละเอียดห้องพัก ได้"];
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function getAddForm()
  {
    $json['title'] = 'แบบฟอร์มการเพิ่มห้องพักใหม่';
    $data['apartment_name'] = $this->genmod->getAll('s_apartment', '*');
    $data['getData_user'] = $this->selectUser();
    $data['getData_Power'] = $this->selectMeter(0);
    $data['getData_Water'] = $this->selectMeter(1);
    $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*');
    $json['body'] = $this->load->view('aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormSubmit(\'new\');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function selectUser()
  {
    $result = [];
    $getRoom = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']));
    $getUser = $this->genmod->getAll('users', '*', array('user_a_id' => $_SESSION['user_a_id'], 'role' => 1));
    if ($getUser) {
      foreach ($getUser as $value) {
        $filter = array_filter($getRoom, function ($room) use ($value) {
          return $room->r_u_id == $value->user_id;
        });
        if (!$filter) {
          $result[] = $value;
        }
      }
    }
    return $result;
  }
  public function selectMeter($type)
  {
    if ($type == 0) {
      $mb = 's_power_meter';
      $ma = 'p_a_id';
      $ms = 'P_satatus';
    } else {
      $mb = 's_water_meter';
      $ma = 'w_a_id';
      $ms = 'w_status';
    }
    $result = [];
    $getRoom = $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']));
    $getMeter = $this->genmod->getAll($mb, '*', array($ma => $_SESSION['user_a_id'], $ms => 1));
    foreach ($getMeter as $value) {
      $filter = array_filter($getRoom, function ($room) use ($value, $type) {
        if ($type == 0) {
          return $room->r_p_id == $value->p_id;
        } else {
          return $room->r_w_id == $value->w_id;
        }
      });
      if (!$filter) {
        $result[] = $value;
      }
    }
    return $result;
  }
  public function getEditForm()
  {
    $json['title'] = 'แก้ไขรายละเอียดห้องพัก';
    $data['getData'] = $this->genmod->getOne('s_room', '*', array('r_id' => $this->input->post('r_id')));
    $data['getData_A'] = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
    $getOwnRoom = $this->genmod->getOne('users', '*', array('user_id' => $data['getData']->r_u_id));
    $getPm = $this->genmod->getOne('s_power_meter', '*', array('p_id' => $data['getData']->r_p_id));
    $getWm = $this->genmod->getOne('s_water_meter', '*', array('w_id' => $data['getData']->r_w_id));
    if($getOwnRoom){
      $data['getData_user'] = (object) array_merge(array($getOwnRoom), (array) $this->selectUser());
    }else{
      $data['getData_user'] = $this->selectUser();
    }
    // $data['getData_user'] = array_filter((array) $data['getData_user'], function ($value) {
    //   return $value != false;
    // });
    $data['getData_Power'] = (object) array_merge(array($getPm), (array) $this->selectMeter(0));
    $data['getData_Water'] = (object) array_merge(array($getWm), (array) $this->selectMeter(1));
    $data['getData_type'] = $this->genmod->getAll('s_admin_confit', '*');
    $json['body'] = $this->load->view('aprtment/formadd', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormUpdate(' . $this->input->post('r_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
  public function getEdit_slip_Form()
  {
    $json['title'] = 'ตรวจสอบยอดโอนเงิน';
    $data['getData'] = $this->genmod->getOne('s_room', '*', array('r_id' => $this->input->post('r_id')));
    $data['getData_bill1'] = $this->genmod->getOne(
      's_bill',
      'MAX(bill_updete_at) as latest_updete_at, ',
      array(
        'bil_r_id' => $this->input->post('r_id'),
        // 'bill_updete_at'=> 'latest_updete_at'
      ),
    );
    $data['getData_bill'] = $this->genmod->getOne(
      's_bill',
      '*,MAX(bill_updete_at) as latest_updete_at, ',
      array(
        'bil_r_id' => $this->input->post('r_id'),
        'bill_updete_at' => $data['getData_bill1']->latest_updete_at,
        'bill_mg_status' => 1
      ),
    );
    // var_dump($data['getData_bill']);
    $json['body'] = $this->load->view('aprtment/formslip', $data, true);
    $json['footer'] = '<span id="fMsg"></span><button type="button" class="btn btn-sm btn-primary" onclick="saveFormUpdate(' . $this->input->post('r_id') . ');">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

  public function getForm()
  {
    $json['title'] = 'รายละเอียดห้องพัก';
    $data['getData'] = $this->genmod->getOne('s_room', '*', array('r_id' => $this->input->post('r_id')));
    $getOwnRoom = $this->genmod->getOne('users', '*', array('user_id' => $data['getData']->r_u_id));
    $getPm = $this->genmod->getOne('s_power_meter', '*', array('p_id' => $data['getData']->r_p_id));
    $getWm = $this->genmod->getOne('s_water_meter', '*', array('w_id' => $data['getData']->r_w_id));
    $data['getData_user'] = (object) array_merge(array($getOwnRoom), (array) $this->selectUser());
    $data['getData_user'] = array_filter((array) $data['getData_user'], function ($value) {
      return $value != false;
    });
    $data['getData_Power'] = (object) array_merge(array($getPm), (array) $this->selectMeter(0));
    $data['getData_Water'] = (object) array_merge(array($getWm), (array) $this->selectMeter(1));
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
    if ($this->genmod->update('s_room', array('status' => ($updateData['status'] == 0 ? '1' : '0'), 'updated_by' => $_SESSION['user_id'], 'updated_ip' => getClientIp()), array('r_id' => $updateData['r_id']))) {
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
