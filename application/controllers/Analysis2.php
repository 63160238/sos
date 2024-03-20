<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analysis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->genlib->checkLogin();
    }

    public function meter()
    {
        if ($_SESSION[ 'user_role' ] > 1) {
        $values['pageTitle'] = 'Analysis';
        $values['breadcrumb'] = 'Analysis';
        $values['pageContent'] = $this->load->view('analysis/meter/index', "", TRUE);
        $this->load->view('main', $values);
    } else {
        echo "คุณไม่สิทธิ์เข้าถึงข้อมูล";
      }
    }
    public function reveune()
    {
        $values['pageTitle'] = 'Reveune';
        $values['breadcrumb'] = 'Reveune';
        $values['pageContent'] = $this->load->view('analysis/reveune/index', "", TRUE);
        $this->load->view('main', $values);
    }
    public function getMeterList()
    {
        $where = array('r_a_id' => $_SESSION['user_a_id']);
        $getRoom = $this->genmod->getAll('s_room', '*', $where);
        $index = 0;
        foreach ($getRoom as $value) {
            $where = array('bill_a_id' => $value->r_a_id, 'bil_r_id' => $value->r_id, 'bill_mg_status' => 1);
            $getLm = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $where, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
            if ($getLm) {
                foreach ($getLm as $valueLm) {
                    $getMonth[] = $this->genmod->getOne('s_bill', "*", array('bill_updete_at' => $valueLm->date));
                }
            } else {
                $getMonth = [];
            }
            if ($getMonth) {
                $count = count($getMonth);
                $info[]['r_name'] = $value->r_name;
                for ($i = 0; $i < $count; $i++) {
                    if ($i != 0) {
                        $info[$index]['month'][$i]['bill_p_khw'] = $getMonth[$i]->bill_p_khw - $getMonth[$i - 1]->bill_p_khw;
                        $info[$index]['month'][$i]['bill_w_flow'] = $getMonth[$i]->bill_w_flow - $getMonth[$i - 1]->bill_w_flow;
                    } else {
                        $info[$index]['month'][$i]['bill_p_khw'] = $getMonth[$i]->bill_p_khw;
                        $info[$index]['month'][$i]['bill_w_flow'] = $getMonth[$i]->bill_w_flow;
                    }
                    $date = new DateTime($getMonth[$i]->bill_updete_at);
                    $date->modify('+543 years');
                    $info[$index]['month'][$i]['m_y'] = $date->format('m/Y');
                    //  $data[]['month'] =date('m',$getMonth[$i]->bill_updete_at);
                }
                $getCP = $this->genmod->getOne('s_power_meter', "p_kwh", array('p_id' => $value->r_p_id));
                $getCW = $this->genmod->getOne('s_water_meter', "w_flow_sum", array('w_id' => $value->r_w_id));
                $info[$index]['month'][$count]['bill_p_khw'] = $getCP->p_kwh -  $getMonth[$count - 1]->bill_p_khw;
                $info[$index]['month'][$count]['bill_w_flow'] = $getCW->w_flow_sum -   $getMonth[$count - 1]->bill_w_flow;
                $info[$index]['month'][$count]['m_y'] = date('n') . "/" . (date('Y') + 543);
                $index++;
            }
        }
        $data['info'] = $info;
        $json['html'] = $this->load->view('analysis/meter/list', $data, TRUE);
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function getReveuneList()
    {
        $postdata = $this->input->post();
        $getBill = [];
        $getAp = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
        if ($postdata) {
            $month = intval(substr($postdata['filterYear'], 0, strpos($postdata['filterYear'], '/')));
            $year = intval(substr($postdata['filterYear'], strpos($postdata['filterYear'], '/') + 1));
            $data['filterYear']['month'] = $month;
            $data['filterYear']['year'] = $year;
        } else {
            $month = date('n');
            $year = date('Y');
            $data['filterYear']['month'] = $month;
            $data['filterYear']['year'] = $year;
        }
        if ($month == 1) {
            $whereBf = array('bill_a_id' => $_SESSION['user_a_id'], 'YEAR(bill_updete_at)' => $year - 1, 'MONTH(bill_updete_at)' => 12, 'bill_mg_status' => 1);
        } else {
            $whereBf = array('bill_a_id' => $_SESSION['user_a_id'], 'YEAR(bill_updete_at)' => $year, 'MONTH(bill_updete_at)' =>  $month - 1, 'bill_mg_status' => 1);
        }
        $getLb = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $whereBf, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
        if ($getLb) {
            foreach ($getLb as $valueLb) {
                $getBf = $this->genmod->getOne('s_bill', 'bill_p_khw,bill_w_flow,YEAR(bill_updete_at) as year,bill_cost,bill_status,bill_pay_method',  array('bill_updete_at' => $valueLb->date));
            }
        } else {
            $getBf = [];
        }
        $where = array('bill_a_id' => $_SESSION['user_a_id'], 'YEAR(bill_updete_at)' => $year, 'MONTH(bill_updete_at)' => $month, 'bill_mg_status' => 1);
        $getLm = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $where, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
        if ($getLm) {
            foreach ($getLm as $valueLm) {
                $getCb = $this->genmod->getAll('s_bill', 'bill_p_khw,bill_w_flow,YEAR(bill_updete_at) as year,bill_cost,bill_status,bill_pay_method',  array('bill_updete_at' => $valueLm->date));
            }
        } else {
            $getCb = [];
        }
        if ($getCb) {
            if ($getBf) {
                $getBill = array($getBf);
                foreach ($getCb as $key => $valueCb) {
                    $getBill[$key + 1] = $valueCb;
                }
            } else {
                $getBill = $getCb;
            }
        }
        $data['filterList'] = $this->genmod->getAll('s_bill', 'YEAR(bill_updete_at) as year,MONTH(bill_updete_at) as month', array('bill_a_id' => $_SESSION['user_a_id'], 'bill_mg_status' => 1), "YEAR(bill_updete_at) DESC, MONTH(bill_updete_at) DESC", "", 'MONTH(bill_updete_at) ,YEAR(bill_updete_at)');
        $data['u_paid'] = 0;
        $data['u_overdue'] = 0;
        $data['pay']['pay_1'] = 0;
        $data['pay']['pay_2'] = 0;
        $data['pay']['pay_3'] = 0;
        $count = count($getBill);
        foreach ($getBill as $key => $value) {
            if ($value->bill_status == 2) {
                if ($count > 1 && $key > 0) {
                    $data['u_paid'] += $value->bill_cost;
                    // var_dump($value->bill_cost - ((($getBill[$key]->bill_p_khw - $getBill[$key - 1]->bill_p_khw) * $getAp->a_power_cost) + (($getBill[$key]->bill_w_flow - $getBill[$key - 1]->bill_w_flow) * $getAp->a_water_cost)));
                    $data['pay']['pay_1'] += $value->bill_cost - ((($getBill[$key]->bill_p_khw - $getBill[$key - 1]->bill_p_khw) * $getAp->a_power_cost) + (($getBill[$key]->bill_w_flow - $getBill[$key - 1]->bill_w_flow) * $getAp->a_water_cost));
                    $data['pay']['pay_2'] += ($getBill[$key]->bill_p_khw - $getBill[$key - 1]->bill_p_khw) * $getAp->a_power_cost;
                    $data['pay']['pay_3'] += ($getBill[$key]->bill_w_flow - $getBill[$key - 1]->bill_w_flow) * $getAp->a_water_cost;
                }
                if ($count == 1) {
                    if ($getCb) {
                        $data['u_paid'] += $value->bill_cost;
                    }
                    $data['pay']['pay_1'] += $value->bill_cost - ((($getBill[$key]->bill_p_khw) * $getAp->a_power_cost) + (($getBill[$key]->bill_w_flow) * $getAp->a_water_cost));
                    $data['pay']['pay_2'] += ($getBill[$key]->bill_p_khw) * $getAp->a_power_cost;
                    $data['pay']['pay_3'] += ($getBill[$key]->bill_w_flow) * $getAp->a_water_cost;
                }
            } else if ($value->bill_status == 3) {
                $data['u_overdue'] += $value->bill_cost;
            }
        }
        $data['line'] = $this->getLinechart($month, $year);
        $json['html'] = $this->load->view('analysis/reveune/list', $data, TRUE);
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function getLinechart($month, $year)
    {
        $where = array('bill_a_id' => $_SESSION['user_a_id'], 'bill_mg_status' => 1);
        $index = 0;
        $data = [];
        $getMonth = $this->genmod->getAll('s_bill', 'YEAR(bill_updete_at) as year,bill_cost,bill_status,bill_pay_method,MONTH(bill_updete_at) as month', $where);
        for ($i = $month + 1; $i <= 12 + $month; $i++) {
            if ($i > 12) {
                $m = $i - 12;
                $y = $year;
            } else {
                $m = $i;
                $y = $year - 1;
            }
            $filterData = array_filter($getMonth, function ($value) use ($m, $y) {
                return $value->month == $m && $value->year == $y;
            });
            if ($filterData) {
                $data[$index]['cost'] = 0;
                foreach ($filterData as $ft) {
                    $data[$index]['month'] = $m;
                    $data[$index]['year'] = $y;
                    $data[$index]['cost'] += $ft->bill_cost;
                }
                $index++;
            }
        }
        return $data;
    }
}
