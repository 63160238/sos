<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Document extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->genlib->checkLogin();
    }
    public function index()
    {
        $values['pageTitle'] = 'Document';
        $values['breadcrumb'] = 'Document';
        $values['newBtn'] = 'เพิ่มสัญญาเช่า';
        $data['filterApartment'] = $this->genlib->filterApartment();
        $values['pageContent'] = $this->load->view('document/index', $data, TRUE);
        $this->load->view('main', $values);
    }
    public function tesx()
    {
        var_dump('เข้า');
    }
    public function receipt()
    {
        $values['pageTitle'] = 'Document';
        $values['breadcrumb'] = 'Document';
        $data['filterApartment'] = $this->genlib->filterApartment();
        $values['pageContent'] = $this->load->view('document/receiptBill/index', $data, TRUE);
        $this->load->view('main', $values);
    }
    public function template()
    {
        $values['pageTitle'] = 'Document';
        $values['breadcrumb'] = 'Document';
        $values['pageContent'] = $this->load->view('document/indexTemplate', '', TRUE);
        $this->load->view('main', $values);
    }
    public function printReceipt()
    {
        $this->genlib->ajaxOnly();
        $id = $this->input->post();
        $receiptData = [];
        $bill = $this->genmod->getOne('s_bill', '*', array('bill_id' => $id['bill_id']));
        $date = new DateTime($bill->bill_updete_at);
        $month = $date->format('n');
        $year = $date->format('Y');
        $apartment = $this->genmod->getOne('s_apartment', 'a_name,a_adds,a_water_cost,a_power_cost', array('a_id' => $_SESSION['user_a_id']));
        $user = $this->genmod->getOne('users', 'CONCAT_WS(" ", prename,fname_th, lname_th) as fullname', array('user_id' => $bill->bill_User_id));
        $u_regis = $this->genmod->getOne('s_register_info', 'regis_addr', array('regis_u_id' => $bill->bill_User_id));
        $room = $this->genmod->getOne('s_room', 'r_name', array('r_id' => $bill->bil_r_id));
        // $template = $this->genmod->getOne('s_bill','*',array('r_id'=>$bill->bil_r_id));
        if($apartment){
            foreach ($apartment as $key => $value) {
                $receiptData[$key] = $value;
            }
        }
        if ($u_regis) {
            foreach ($u_regis as $key => $value) {
                $receiptData[$key] = $value;
            }
        }
        if ($user) {
            foreach ($user as $key => $value) {
                $receiptData[$key] = $value;
            }
        }
        if ($room) {
            foreach ($room as $key => $value) {
                $receiptData[$key] = $value;
            }
        }
        if ($bill) {
            foreach ($bill as $key => $value) {
                $receiptData[$key] = $value;
            }
        }
        if(!$apartment || !$u_regis || !$user || !$room || !$bill){
            $json = ['status' => 0];
        }else{
            $json = ['receiptData' => $receiptData,'status'=>1];
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function getReceipt()
    {
        $this->genlib->ajaxOnly();
        $filter = $this->input->post();
        if ($filter && $filter['a_id']) {
            $_SESSION['user_a_id'] = intval($filter['a_id']);
        }
        $where = array('bill_a_id' => $_SESSION['user_a_id'], 'bill_status' => 3);
        $config = $this->genmod->getOne('s_apartment', 'a_power_cost,a_water_cost', array('a_id' => $_SESSION['user_a_id']));
        $getReceipt = $this->genmod->getAll('s_bill', '*', $where);
        $index = 0;
        if ($getReceipt) {
            foreach ($getReceipt as $value) {
                $user = $this->genmod->getOne('users', '*', array('user_id' => $value->bill_User_id));
                $receipt[$index] = new stdClass();
                if ($user) {
                    $receipt[$index]->u_name = $user->fname_th . ' ' . $user->lname_th;
                } else {
                    $receipt[$index]->u_name = 'ไม่มี';
                }
                $receipt[$index]->bill_id = $value->bill_id;
                $receipt[$index]->date = thaiMonthFull(date('n', strtotime($value->bill_updete_at))) . ' พ.ศ. ' . (date('Y', strtotime($value->bill_updete_at)) + 543);
                $receipt[$index]->receipt_id = 'RC' . (date('Y', strtotime($value->bill_updete_at)) + 543) . '0' . date('n', strtotime($value->bill_updete_at)) . $value->bil_r_id;
                $roomName =  $this->genmod->getOne('s_room', 'r_name', array('r_id' => $value->bil_r_id));
                $receipt[$index]->r_id = $roomName->r_name;
                $receipt[$index]->bill_cost = $value->bill_cost;
                $receipt[$index]->bill_slip = $value->bill_slip_file;
                $index++;
            }
            $data['receipt'] = $receipt;
        } else {
            $data['receipt'] = new stdClass();
        }
        $json['html'] = $this->load->view('document/receiptBill/list', $data, TRUE);
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function getContract()
    {
        $this->genlib->ajaxOnly();
        $filter = $this->input->post();
        $regis_status = 'regis_status >=';
        $filter_status = 1;
        $regis_period = 'regis_period >=';
        $filter_period = 1;
        if (isset($filter['a_id'])) {
            // if (isset($filter['contract_status']) && $filter['contract_status'] != "all") {
            //     $regis_status = 'regis_status';
            //     $filter_status = intval($filter['contract_status']);
            // }
                $_SESSION['user_a_id'] = intval($filter['a_id']);
        }
        $getUser = $this->genmod->getAll('users', '*', array('user_a_id' => $_SESSION['user_a_id']));
        $doc = [];
        if ($getUser) {
            foreach ($getUser as $key => $value) {
                $getRoom = $this->genmod->getOne('s_room', 'r_name', array('r_u_id' => $value->user_id));
                $getRegis = $this->genmod->getOne('s_register_info', '*', array('regis_u_id' => $value->user_id, $regis_period => $filter_period, $regis_status => $filter_status));
                if ($getRoom && $getRegis) {
                    $doc[$key] = new stdClass();
                    $r_name = 'u_name';
                    $doc[$key]->$r_name = $value->fname_th . " " . $value->lname_th;
                    foreach ($getRoom as $key2 => $value) {
                        $doc[$key]->$key2 = $value;
                    }
                    // เพิ่มค่าจาก object2 ไปยัง object3
                    foreach ($getRegis as $key3 => $value) {
                        $doc[$key]->$key3 = $value;
                    }
                }
            }
        }
        $data['doc_data'] = $doc;
        $json['html'] = $this->load->view('document/list', $data, TRUE);
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function generate_pdf()
    {
        $json['html'] = $this->load->view('document/generate_pdf', '', TRUE);
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function addTemplate()
    {
        $default = $this->genmod->getAll('s_doc_template', '*', array('t_id' => 6));
        $template = $this->genmod->getAll('s_doc_template', '*', array('a_id' => $_SESSION['user_a_id']));
        $data['template'] = new stdClass();
        if ($template) {
            $data['template'] = (object) array_merge(
                (array) $default,
                (array) $template
            );
        }else{
            $data['template'] =$default;
        }
        $json['html'] = $this->load->view('document/addContract', $data, TRUE);
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function editTemplate()
    {
        $this->genlib->ajaxOnly();
        $editData = $this->input->post();
        $json = $this->genmod->getOne('s_doc_template', '*', array('t_id' => $editData['t_id']));
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function saveTemplate()
    {
        $this->genlib->ajaxOnly();
        $formData = $this->input->post();
        $formData['a_id'] = $_SESSION['user_a_id'];
        if ($formData['choose'] == 0 || $formData['choose'] == 6) {
            unset($formData['choose']);
            $this->genmod->add('s_doc_template', $formData);
        } else {
            $t_id =  $formData['choose'];
            unset($formData['choose']);
            $this->genmod->update('s_doc_template', $formData, array('t_id' => $t_id));
        }
        $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function getAddForm()
    {
        $json['title'] = 'แบบฟอร์มการเพิ่มผู้ใช้งานใหม่';
        $data['getU'] = $this->selectUser();
        $default = $this->genmod->getAll('s_doc_template', '*', array('t_id' => 6));
        if ($data['getU']) {
            $data['getRU'] = $this->genmod->getAll('s_register_info', '*', array('regis_a_id' => $_SESSION['user_a_id'], 'regis_status' => 0));
            $template = $this->genmod->getAll('s_doc_template', '*', array('a_id' => $_SESSION['user_a_id']));
        } else {
            $data['getRU'] = [];
            $template = [];
        }
        if ($template) {
            $data['getTemplate'] = (object) array_merge(
                (array) $default,
                (array) $template
            );
        }else{
            $data['getTemplate'] =$default;
        }
        $json['body'] = $this->load->view('document/formadd', $data, true);
        $json['footer'] = '<span id="fMsg"></span><button id="print" type="button" class="btn btn-sm btn-secondary mr-auto" disabled >พิมพ์ตัวอย่างเอกสาร</button><button disabled id="save" type="button" class="btn btn-sm btn-primary">บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function getEditForm()
    {
        $this->genlib->ajaxOnly();
        $data = $this->input->post();
        $json['title'] = 'แบบฟอร์มการเพิ่มผู้ใช้งานใหม่';
        $data['getAp'] = $this->genmod->getOne('s_apartment', '*', array('a_id' =>  $_SESSION['user_a_id']));
        $data['getRU'] = $this->genmod->getOne('s_register_info', '*', array('regis_id' => $data['id']));
        $data['getRoom'] =  $this->genmod->getOne('s_room', '*', array('r_u_id' => $data['getRU']->regis_u_id));
        $data['getTem'] = $this->genmod->getOne('s_doc_template', '*', array('t_id' => $data['getRU']->regis_doc_tem));
        $data['getU'] = $this->genmod->getOne('users', '*', array('user_id' => $data['getRU']->regis_u_id));
        $default = $this->genmod->getAll('s_doc_template', '*', array('t_id' => 6));
        $template = $this->genmod->getAll('s_doc_template', '*', array('a_id' => $_SESSION['user_a_id']));
        if ($template) {
            $data['getTemplate'] = (object) array_merge(
                (array) $default,
                (array) $template
            );
        }else{
            $data['getTemplate'] =$default;
        }
        $json['body'] = $this->load->view('document/formadd', $data, true);
        $json['footer'] = '<span id="fMsg"></span><button id="print" type="button" class="btn btn-sm btn-secondary mr-auto" disabled >พิมพ์ตัวอย่างเอกสาร</button><button id="save" type="button" class="btn btn-sm btn-primary"> บันทึก</button>
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function selectUser()
    {
        $result = [];
        $getRoom =  $this->genmod->getAll('s_room', '*', array('r_a_id' => $_SESSION['user_a_id']));
        $getRU = $this->genmod->getAll('s_register_info', '*', array('regis_a_id' => $_SESSION['user_a_id'], 'regis_status' => 0));
        $getUser = $this->genmod->getAll('users', '*', array('user_a_id' => $_SESSION['user_a_id'], 'role' => 1));
        if ($getUser) {
            foreach ($getUser as $value) {
                $filter = array_filter($getRoom, function ($room) use ($value) {
                    return $room->r_u_id == $value->user_id;
                });
                if ($filter && $getRU) {
                    $filter2 = array_filter($getRU, function ($regis) use ($value) {
                        return $regis->regis_u_id == $value->user_id && $regis->regis_status == 0;
                    });
                    if ($filter2) {
                        $result[] = $value;
                    }
                }
            }
        }
        return $result;
    }
    public function changeUser()
    {
        $this->genlib->ajaxOnly();
        $user = $this->input->post();
        $getRoom =  $this->genmod->getOne('s_room', '*', array('r_u_id' => $user['u_id']));
        $getRU = $this->genmod->getOne('s_register_info', '*', array('regis_u_id' => $user['u_id']));
        if ($getRoom) {
            $getAp = $this->genmod->getOne('s_apartment', 'a_name,a_adds', array('a_id' => $getRoom->r_a_id));
        }
        $data['regisInfo'] = new stdClass();
        if ($user['u_id'] != 0) {
            foreach ($getAp as $key => $value) {
                $data['regisInfo']->$key = $value;
            }
            foreach ($getRoom as $key2 => $value) {
                $data['regisInfo']->$key2 = $value;
            }
            // เพิ่มค่าจาก object2 ไปยัง object3
            foreach ($getRU as $key3 => $value) {
                $data['regisInfo']->$key3 = $value;
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function addContract()
    {
        $this->genlib->ajaxOnly();
        $formData = $this->input->post();
        $u_id = $formData['u_id'];
        $a_id = $formData['regis_a_id'];
        $formData['regis_status'] = 1;
        unset($formData['u_id']);
        unset($formData['regis_a_id']);
        $this->genmod->update('s_register_info', $formData, array('regis_a_id' => $a_id, 'regis_u_id' => $u_id));
        $json = ['status' => 1, 'msg' => 'เพิ่มข้อมูลสำเร็จ'];
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function changeTemplate()
    {
        $this->genlib->ajaxOnly();
        $template = $this->input->post();
        $data['getTemplate'] =  $this->genmod->getOne('s_doc_template', '*', array('t_id' => $template['t_id']));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function cancelContract()
    {
        $this->genlib->ajaxOnly();
        $id = $this->input->post();
        $data['regis_status'] = 1;
        $data['sign_contract'] = "";
        $this->genmod->update('s_register_info', $data, array('regis_id' => $id['regis_id']));
    }
    public function uploadFile()
    {
        $index = 'upload-' . $_POST['rid'];
        if ($_FILES['contract']) {
            $data1 = 'contract';
            $upload = $_FILES['contract'];
            if ($upload != '') {
                //ตัดขื่อเอาเฉพาะนามสกุล
                $typefile = strrchr($_FILES['contract']['name'], ".");
                $path = "assets/docs/contract/";
                $newname = $data1 . $_POST['uid'] . '-' . $_POST['rid'] . $typefile;
                $data['sign_contract'] = $newname;
                $path_copy = $path . $newname;
                move_uploaded_file($_FILES['contract']['tmp_name'], $path_copy);
            }
        }
        $data['regis_status'] = 2;
        $getRoom = $this->genmod->getOne('s_room', '*', array('r_u_id' => $_POST['uid'], 'r_name' => $_POST['rid']));
        $where = array('regis_u_id' => $_POST['uid'], 'regis_a_id' => $getRoom->r_a_id);
        $this->genmod->update('s_register_info', $data, $where);
        // $this->genmod->add('s_register_info',$formData);
        $json = ['status' => 1, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
