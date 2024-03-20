<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analysis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->genlib->checkLogin();
        $this->genlib->update_pay_status();
    }

    public function meter()
    {
        $values['pageTitle'] = 'Analysis';
        $values['breadcrumb'] = 'Analysis';
        $data['filterApartment'] = $this->genlib->filterApartment();
        $values['pageContent'] = $this->load->view('analysis/meter/index', $data, TRUE);
        $this->load->view('main', $values);
    }
    public function getFloor()
    {
        $getFloor = $this->genmod->getAll('s_room', 'r_floor', array('r_a_id' => $_SESSION['user_a_id']), '', '', 'r_floor');
        echo json_encode($getFloor);
    }
    public function reveune()
    {
        $values['pageTitle'] = 'Reveune';
        $values['breadcrumb'] = 'Reveune';
        $data['filterApartment'] = $this->genlib->filterApartment();
        $values['pageContent'] = $this->load->view('analysis/reveune/index', $data, TRUE);
        $this->load->view('main', $values);
    }
    public function getMeterList()
    {
        $postdata = $this->input->post();
        $info = [];
        $floor = 1;
        $data['getFloor'] = $this->genmod->getAll('s_room', 'r_floor', array('r_a_id' => $_SESSION['user_a_id']), '', '', 'r_floor');
        if ($postdata) {
            if (isset($postdata['filterFloor'])) {
                $floor =  $postdata['filterFloor'];
            }
            if (isset($postdata['apartment'])) {
                $_SESSION['user_a_id'] = $postdata['apartment'];
            }
        }
        $where = array('r_a_id' => $_SESSION['user_a_id'], 'r_floor' => $floor);
        $getRoom = $this->genmod->getAll('s_room', '*', $where);
        $index = 0;
        if ($getRoom) {
            foreach ($getRoom as $value) {
                $getMonth = [];
                $where = array('bill_a_id' => $value->r_a_id, 'bil_r_id' => $value->r_id, 'bill_mg_status' => 1, 'bill_User_id' => $value->r_u_id);
                $getLm = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $where, 'date ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
                if ($getLm) {
                    foreach ($getLm as $valueLm) {
                        $getMonth[] = $this->genmod->getOne('s_bill', "*", array('bil_r_id' => $value->r_id, 'bill_updete_at' => $valueLm->date));
                    }
                } else {
                    $getMonth = [];
                }
                if ($value->r_u_id == NULL) {
                    $info[$index]['user'] = 'ห้องว่าง';
                } else {
                    $info[$index]['user'] = '';
                }
                if ($getMonth && $value->r_u_id != NULL) {
                    $count = count($getMonth);
                    $info[$index]['r_name'] = $value->r_name;

                    for ($i = 0; $i < $count; $i++) {
                        $info[$index]['month'][$i]['bill_p_khw'] = $getMonth[$i]->bill_p_khw_moth;
                        $info[$index]['month'][$i]['bill_w_flow'] = $getMonth[$i]->bill_w_flow_month;
                        $date = new DateTime($getMonth[$i]->bill_updete_at);
                        $date->modify('+543 years');
                        $info[$index]['month'][$i]['m_y'] = $date->format('m/Y');
                        //  $data[]['month'] =date('m',$getMonth[$i]->bill_updete_at);
                    }
                    $getCP = $this->genmod->getOne('s_power_meter', "p_kwh", array('p_id' => $value->r_p_id));
                    $getCW = $this->genmod->getOne('s_water_meter', "w_flow_sum", array('w_id' => $value->r_w_id));
                    $lastmonth = date('m', strtotime($getMonth[$count - 1]->bill_updete_at));
                    if (date('m') != $lastmonth) {
                        if ($getCP) {
                            $info[$index]['month'][$count]['bill_p_khw'] = $getCP->p_kwh -  $getMonth[$count - 1]->bill_p_khw;
                            $info[$index]['month'][$count]['m_y'] = date('m') . "/" . (date('Y') + 543);
                        }
                        if ($getCW) {
                            $info[$index]['month'][$count]['bill_w_flow'] = $getCW->w_flow_sum -   $getMonth[$count - 1]->bill_w_flow;
                            $info[$index]['month'][$count]['m_y'] = date('m') . "/" . (date('Y') + 543);
                        }
                    }
                } else {
                    $info[$index]['r_name'] = $value->r_name;
                    $getCP = $this->genmod->getOne('s_power_meter', "p_kwh", array('p_id' => $value->r_p_id));
                    $getCW = $this->genmod->getOne('s_water_meter', "w_flow_sum", array('w_id' => $value->r_w_id));
                    if ($getCP && $getCW && $value->r_u_id != NULL) {
                        $info[$index]['month'][0]['bill_p_khw'] = $getCP->p_kwh;
                        $info[$index]['month'][0]['bill_w_flow'] = $getCW->w_flow_sum;
                        $info[$index]['month'][0]['m_y'] = date('m') . "/" . (date('Y') + 543);
                    } else {
                        $info[$index]['month'][0]['bill_p_khw'] = 0;
                        $info[$index]['month'][0]['bill_w_flow'] = 0;
                        $info[$index]['month'][0]['m_y'] = date('m') . "/" . (date('Y') + 543);
                    }
                }
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
        if (isset($postdata['a_id'])) {
            $_SESSION['user_a_id'] = $postdata['a_id'];
        }
        $getBill = [];
        $data['u_paid'] = 0;
        $data['line'] = [];
        $data['u_overdue'] = 0;
        $data['pay']['pay_1'] = 0;
        $data['pay']['pay_2'] = 0;
        $data['pay']['pay_3'] = 0;
        $getAp = $this->genmod->getOne('s_apartment', '*', array('a_id' => $_SESSION['user_a_id']));
        if (isset($postdata['filterYear'])) {
            $month = intval(substr($postdata['filterYear'], 0, strpos($postdata['filterYear'], 'พ.ศ.')));
            $year = intval(substr($postdata['filterYear'], strpos($postdata['filterYear'], 'พ.ศ.') + 9));
            $data['filterYear']['month'] = $month;
            $data['filterYear']['year'] = $year;
            $data['filterList'] = $this->genmod->getAll('s_bill', 'YEAR(bill_updete_at) as year,MONTH(bill_updete_at) as month', array('bill_a_id' => $_SESSION['user_a_id'], 'bill_mg_status' => 1), "YEAR(bill_updete_at) DESC, MONTH(bill_updete_at) DESC", "", 'MONTH(bill_updete_at) ,YEAR(bill_updete_at)');
        } else {
            $data['filterList'] = $this->genmod->getAll('s_bill', 'YEAR(bill_updete_at) as year,MONTH(bill_updete_at) as month', array('bill_a_id' => $_SESSION['user_a_id'], 'bill_mg_status' => 1), "YEAR(bill_updete_at) DESC, MONTH(bill_updete_at) DESC", "", 'MONTH(bill_updete_at) ,YEAR(bill_updete_at)');
            if ($data['filterList']) {
                $data['filterList'] = array_filter($data['filterList'], function ($value) {
                    return $value->month != 0 && $value->year != 0;
                });
                $countFl = count($data['filterList']);
                $month = $data['filterList'][$countFl - 1]->month;
                $year = $data['filterList'][$countFl - 1]->year;
                $data['filterYear']['month'] = $month;
                $data['filterYear']['year'] = $year;
            } else {
                $month = null;
            }
        }
        if ($month != null) {
            $where = array('bill_a_id' => $_SESSION['user_a_id'], 'YEAR(bill_updete_at)' => $year, 'MONTH(bill_updete_at)' => $month, 'bill_mg_status' => 1);
            $getLm = $this->genmod->getAll('s_bill', 'bil_r_id,MAX(bill_updete_at) as date', $where, 'date ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at),bil_r_id');
            if ($getLm) {
                foreach ($getLm as $valueLm) {
                    $getBill[] = $this->genmod->getOne('s_bill', 'bill_p_khw_moth,bill_w_flow_month,bill_p_khw,bill_w_flow,YEAR(bill_updete_at) as year,bill_cost,bill_status,bill_pay_method',  array('bill_a_id' => $_SESSION['user_a_id'], 'bil_r_id' => $valueLm->bil_r_id, 'bill_updete_at' => $valueLm->date));
                }
            } else {
                $getBill = [];
            }
            $count = count($getBill);
            foreach ($getBill as $key => $value) {
                if ($value->bill_status == 3) {
                    if ($count > 1) {
                        $data['u_paid'] += $value->bill_cost;
                        // var_dump($value->bill_cost - ((($getBill[$key]->bill_p_khw - $getBill[$key - 1]->bill_p_khw) * $getAp->a_power_cost) + (($getBill[$key]->bill_w_flow - $getBill[$key - 1]->bill_w_flow) * $getAp->a_water_cost)));
                        $data['pay']['pay_1'] += $value->bill_cost - ((($getBill[$key]->bill_p_khw_moth) * $getAp->a_power_cost) + (($getBill[$key]->bill_w_flow_month) * $getAp->a_water_cost));
                        $data['pay']['pay_2'] += ($getBill[$key]->bill_p_khw_moth) * $getAp->a_power_cost;
                        $data['pay']['pay_3'] += ($getBill[$key]->bill_w_flow_month) * $getAp->a_water_cost;
                    }
                    if ($count == 1) {
                        $data['u_paid'] += $value->bill_cost;
                        $data['pay']['pay_1'] += $value->bill_cost - ((($getBill[$key]->bill_p_khw_moth) * $getAp->a_power_cost) + (($getBill[$key]->bill_w_flow_month) * $getAp->a_water_cost));
                        $data['pay']['pay_2'] += ($getBill[$key]->bill_p_khw_moth) * $getAp->a_power_cost;
                        $data['pay']['pay_3'] += ($getBill[$key]->bill_w_flow_month) * $getAp->a_water_cost;
                    }
                } else if ($value->bill_status == 4) {
                    $data['u_overdue'] += $value->bill_cost;
                }
            }
            $data['line'] = $this->getLinechart($month, $year);
        }

        // var_dump( $data);
        $data = array_filter($data, function ($value) {
            return $value !== false;
        });
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
