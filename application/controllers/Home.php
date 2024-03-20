<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->genlib->checkLogin();
		$this->genlib->update_pay_status();
	}

	public function index()
	{
		$values[ 'pageTitle' ] = 'หน้าหลัก';
		$values[ 'breadcrumb' ] = 'Home'; 
		$data['filterApartment'] = $this->genlib->filterApartment();
		if ($_SESSION['user_role']==1) {
			$values[ 'pageContent' ] = $this->load->view('home/index', "", TRUE);
		}else{
			$values[ 'pageContent' ] = $this->load->view('analysis/reveune/index', $data, TRUE);
		}
		
		$this->load->view('main', $values);
	}
	public function getA_SetForm()
  {
    // $this->genlib->ajaxOnly();
    // $formData = $this->input->post();
		for ($i = 0; $i < count($_SESSION['a_id']); $i++) {
			$a_name[$i] = $this->genmod->getOne('s_apartment', 'a_name, a_id', array('a_id' => $_SESSION['a_id'][$i]));
		}
    $json[ 'title' ] = 'เลือกหอพัก';
		$data[ 'a_name' ] = $a_name;
    $json[ 'body' ] = $this->load->view('home/From_SESSION',$data, true);
		$json[ 'footer' ] = "";
      // '<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ยกเลิก</button>';
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }
	public function Set_a()
  {
    $this->genlib->ajaxOnly();
    $formData = $this->input->post();
		$keys = array_keys($formData);
		$_SESSION['user_a_id'] = intval($keys[0]);
		$_SESSION[ 'a_ses' ] = intval($keys[ 0 ]);
		$json['msg'] = "ยินดีตอนรับ";
		$json['status'] = 1;
    $this->output->set_content_type('application/json')->set_output(json_encode($json));
  }

	public function getDashboard()
	{
		$data[ 'pmConfig' ] = $this->genmod->getOne('s_apartment', "*", array('a_id' => $_SESSION[ 'user_a_id' ]));
		$data[ 'chart_data' ] = null;
		$data[ 'filter_year' ] = null;
		$data[ 'type' ] = null;
		$data[ 'power_month' ] = 0;
		$data[ 'water_month' ] = 0;
		$data[ 'water_meter' ] = 0;
		$data[ 'power_meter' ] = 0;
		$data[ 'chart_data' ] = [];
		$data[ 'start_year' ] = null;
		$postData = $this->input->post();
		$where = array('r_u_id' => $_SESSION[ 'user_id' ]);
		$room = $this->genmod->getOne('s_room', "*", $where);
		if ($room) {
			$p_id = $room->r_p_id;
			$w_id = $room->r_w_id;
			$a_id = $room->r_a_id;
			$data[ 'power_month' ] = $this->getMeterMonth(0);
			$data[ 'water_month' ] = $this->getMeterMonth(1);
			$data[ 'water_meter' ] = $this->getWaterMeter($a_id);
			$data[ 'power_meter' ] = $this->getPowerMeter($a_id);
			if ($postData) {
				$data[ 'start_year' ] = intval($postData[ 'start_year' ]);
				$data[ 'type' ] = $postData[ 'type' ];
				$data[ 'filter_year' ] = $this->filterYear();
				$data[ 'chart_data' ] = $this->getPowerLineChart($data[ 'type' ], $p_id, $w_id, $a_id, $data[ 'start_year' ]);
			} else {
				$data[ 'filter_year' ] = $this->filterYear(0, $p_id, $w_id, $a_id);
				$data[ 'start_year' ] = date('Y');
				$data[ 'chart_data' ] = $this->getPowerLineChart(0, $p_id, $w_id, $a_id, $data[ 'start_year' ]);
			}
		}
		// $data['line_chart_data'] = $this->getPowerLineChart($a_id);
		$ttd = $this->getTodayThai();

		$data[ 'ttd' ] = $ttd;
		$json[ 'html' ] = $this->load->view('home/dashboard', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	// public function getLineChart(){
	//   $postData = $this->input->post();
	//   $data['start_year'] = $postData['start_year'];
	//   $json['html'] = $this->load->view('home/dashboard', $data, TRUE);
	//   $this->output->set_content_type('application/json')->set_output(json_encode($json));
	// }
	public function filterYear()
	{
		$where = array('r_u_id' => $_SESSION[ 'user_id' ]);
		$room = $this->genmod->getOne('s_room', "*", $where);
		$whereD = array('bil_r_id' => $room->r_id, 'bill_mg_status' => 1);
		$getData = $this->genmod->getAll('s_bill', 'YEAR(bill_updete_at) as year', $whereD, "", "", 'YEAR(bill_updete_at)');
		$result = [];
		if ($getData) {
			foreach ($getData as $value) {
				$result[] = $value->year;
			}
		}
		return $result;
	}
	public function getPowerLineChart($type, $p_id, $w_id, $a_id, $start_year)
	{
		// if($type == 'p'){
		$getMonth = [];
		$chartData = [];
		$where = array('r_u_id' => $_SESSION[ 'user_id' ]);
		$room = $this->genmod->getOne('s_room', "*", $where);
		if ($type == 0) {
			$db_meter = 's_power_meter';
			$cm_id = 'p_id';
			$m_id = $room->r_p_id;
		} else {
			$db_meter = 's_water_meter';
			$cm_id = 'w_id';
			$m_id = $room->r_w_id;
		}
		$where = array('YEAR(bill_updete_at)' => $start_year - 1, 'MONTH(bill_updete_at)' => 12, 'bil_r_id' => $room->r_id, 'bill_mg_status' => 1);
		$getLm = $this->genmod->getOne('s_bill', 'MAX(bill_updete_at) as date', $where, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at)');
		if ($getLm) {
			$getMonth[] = $this->genmod->getOne('s_bill', "*", array('bill_updete_at' => $getLm->date));
		} else {
			$getMonth = [];
		}
		$whereM = array('YEAR(bill_updete_at)' => $start_year, 'bil_r_id' => $room->r_id, 'bill_mg_status' => 1);
		$getLm = $this->genmod->getAll('s_bill', 'MAX(bill_updete_at) as date', $whereM, 'YEAR(bill_updete_at) ASC,MONTH(bill_updete_at) ASC', '', 'MONTH(bill_updete_at),YEAR(bill_updete_at)');
		if ($getLm) {
			foreach ($getLm as $value) {
				$getData[] = $this->genmod->getOne('s_bill', "bill_p_khw,bill_w_flow,MONTH(bill_updete_at) as month,YEAR(bill_updete_at) as year", array('bill_updete_at' => $value->date));
			}
		} else {
			$getData = [];
		}
		$whereCP = array($cm_id => $m_id);
		$currentP = $this->genmod->getOne($db_meter, "*", $whereCP);
		$count = count($getData);
		$index = 0;
		if ($getData) {
			for ($i = 1; $i <= 12; $i++) {
				if ($index <= $count) {
					$filterData = array_filter($getData, function ($value) use ($i, $start_year) {
						return $value->month == $i && $value->year == $start_year;
					});
					if ($filterData) {
						foreach ($filterData as $filterData) {
							if ($i == 1) {
								if ($type == 0) {
									if ($getMonth) {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_p_khw - $getMonth->bill_p_khw, 'year' => $start_year ];
									} else {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_p_khw, 'year' => $start_year ];
									}
								} else {
									if ($getMonth) {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_w_flow - $getMonth->bill_w_flow, 'year' => $start_year ];
									} else {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_w_flow, 'year' => $start_year ];
									}
								}
							} else {
								if ($type == 0) {
									if ($index == 0) {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_p_khw, 'year' => $start_year ];
									} else {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_p_khw - $getData[ $index - 1 ]->bill_p_khw, 'year' => $start_year ];
									}
								} else {
									if ($index == 0) {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_w_flow, 'year' => $start_year ];
									} else {
										$chartData[] = [ 'month' => $i, 'pkw' => $filterData->bill_w_flow - $getData[ $index - 1 ]->bill_w_flow, 'year' => $start_year ];
									}
								}
							}
						}
						$index++;
					}
				}
			}
		}
		return $chartData;
	}
	public function getWaterMeter($postdata)
	{
		$result = 0;
		$water_meter = $this->genmod->getAll('s_water_meter');
		if ($_SESSION[ 'user_role' ] == 1) {
			$where = array('r_u_id' => intval($_SESSION[ 'user_id' ]));
			$room = $this->genmod->getOne('s_room', "", $where);
			foreach ($water_meter as $key) {
				if ($key->w_id == $room->r_w_id) {
					$result = $key->w_flow_sum_day;
				}
			}
		} else {
			foreach ($water_meter as $key) {
				if ($key->w_a_id == $postdata) {
					$result += $key->w_flow_sum_day;
				}
			}
		}
		return $result;
	}
	// public function getWaterMonth($postdata)
	// {
	// 	$water_meter = $this->genmod->getAll('s_water_meter');
	// 	if ($_SESSION['user_role'] == 1) {
	// 		$where = array('r_u_id' => intval($_SESSION['user_id']));
	// 		$room = $this->genmod->getOne('s_room', "", $where);
	// 		$whereWmCondition = array('wm_w_id' => $room->r_w_id);
	// 		$wm_id = $this->genmod->getOne('s_water_month', 'Max(wm_id) As max_wm_id', $whereWmCondition, '', '', 'wm_w_id');
	// 		$water_meter_month = $this->genmod->getAll('s_water_month', "*", $whereWmCondition);
	// 		$result = null;
	// 		if (is_array($water_meter_month)) {
	// 			foreach ($water_meter_month as $key) {
	// 				if ($wm_id->max_wm_id == $key->wm_id) {
	// 					$result = $water_meter[$key->wm_w_id - 1]->w_flow_sum - $key->wm_flow_sum;
	// 				}
	// 			}
	// 		} else {
	// 			$result = null;
	// 		}
	// 	} else {
	// 		$whereWmCondition = array('wm_a_id' => $postdata);
	// 		$wm_id = $this->genmod->getAll('s_water_month', 'Max(wm_id) As max_wm_id', $whereWmCondition, '', '', 'wm_w_id');
	// 		$water_meter_month = $this->genmod->getAll('s_water_month', "*", $whereWmCondition);
	// 		$result = null;
	// 		if (is_array($water_meter_month)) {
	// 			foreach ($wm_id as $wm_id) {
	// 				foreach ($water_meter_month as $key) {
	// 					if ($wm_id->max_wm_id == $key->wm_id) {
	// 						$result += $water_meter[$key->wm_w_id - 1]->w_flow_sum - $key->wm_flow_sum;
	// 					}
	// 				}
	// 			}
	// 		} else {
	// 			$result = null;
	// 		}
	// 	}
	// 	return $result;
	// }
	public function getPowerMeter($postdata)
	{
		$result = 0;
		$power_meter = $this->genmod->getAll('s_power_meter');
		if ($_SESSION[ 'user_role' ] == 1) {
			$where = array('r_u_id' => intval($_SESSION[ 'user_id' ]));
			$room = $this->genmod->getOne('s_room', "", $where);
			foreach ($power_meter as $key) {
				if ($key->p_id == $room->r_p_id) {
					$result = $key->p_khw_day;
				}
			}
		} else {
			foreach ($power_meter as $key) {
				if ($key->p_a_id == $postdata) {
					$result += $key->p_khw_day;
				}
			}
		}
		return $result;
	}
	public function getMeterMonth($type)
	{
		$result = null;
		if ($_SESSION[ 'user_role' ] == 1) {
			$where = array('r_u_id' => intval($_SESSION[ 'user_id' ]));
			$room = $this->genmod->getOne('s_room', "", $where);
			$whereM = array('bil_r_id' => $room->r_id, 'bill_mg_status' => 1);
			$meter_month = $this->genmod->getAll('s_bill', "*", $whereM);
			$power_meter = [];
			$water_meter = [];
			if ($type == 0) {
				$where = array('p_id' => $room->r_p_id);
				$power_meter = $this->genmod->getOne('s_power_meter', "*", $where);
			} else {
				$where = array('w_id' => $room->r_w_id);
				$water_meter = $this->genmod->getOne('s_water_meter', "*", $where);
			}
			$count = count($meter_month);
			$index = 0;
			if (is_array($meter_month)) {
				foreach ($meter_month as $key => $value) {
					$index++;
					if ($index == $count) {
						if ($type == 0) {
							if( $power_meter->emb_id != 0 &&  $power_meter->addr != 0){
								$result = $power_meter->p_kwh - $value->bill_p_khw;
							}
						} else {
							if( $water_meter->emb_id != 0 &&  $water_meter->addr != 0){
							$result = $water_meter->w_flow_sum - $value->bill_w_flow;
							}
						}
					}
				}
			} else {
				$result = null;
			}
			// } else {
			// 	$wherePmCondition = array('pm_a_id' => $postdata);
			// 	$pm_id = $this->genmod->getAll('s_power_month', 'Max(pm_id) As max_pm_id', $wherePmCondition, '', '', 'pm_p_id');
			// 	$power_meter_month = $this->genmod->getAll('s_power_month', "*", $wherePmCondition);
			// 	$result = 0;
			// 	if (is_array($power_meter_month)) {
			// 		foreach ($pm_id as $pm_id) {
			// 			foreach ($power_meter_month as $key) {
			// 				if ($pm_id->max_pm_id == $key->pm_id) {
			// 					$result += $power_meter[$key->pm_p_id - 1]->p_kwh - $key->pm_kw;
			// 				}
			// 			}
			// 		}
			// 	} else {
			// 		$result = null;
			// 	}
		}
		return $result;
	}
	// public function add()
	// {
	// 	$mapIdData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=get_map_id()");
	// 	$mapIdXml = simplexml_load_string($mapIdData) or die("Error: Cannot create encode data to xml object");
	// 	$mapIdJsonData = json_encode($mapIdXml) or die("Error: Cannot encode record to json");
	// 	$data = json_decode($mapIdJsonData, true);
	// 	// var_dump($data['ITEM'][0]['SS_LABEL']);
	// 	$this->genlib->ajaxOnly();
	// 	$postData = $this->input->post();
	// 	// var_dump($postData);
	// 	$this->genmod->add('map_info', $postData);
	// 	$this->genmod->add('power_display', $postData);
	// }
	public function add_pow()
	{
		$mapIdData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=get_map_id()");
		$mapIdXml = simplexml_load_string($mapIdData) or die("Error: Cannot create encode data to xml object");
		$mapIdJsonData = json_encode($mapIdXml) or die("Error: Cannot encode record to json");
		$data = json_decode($mapIdJsonData, true);
		// var_dump($data['ITEM'][0]['SS_LABEL']);
		$this->genlib->ajaxOnly();
		$postData = $this->input->post();
		// var_dump($postData);
		$this->genmod->add('power_display', $postData);
	}
	public function updateMeterPower()
	{
		$power_meter = $this->genmod->getAll('s_power_meter', '*', array('emb_id !=' => 0, 'addr !=' => 0));

		foreach ($power_meter as $power_meter_item) {
			if ($power_meter_item) {
				// var_dump($power_meter_item);
				$powerData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=power_display()&emb_id={$power_meter_item->emb_id}&addr={$power_meter_item->addr}");
				if (isset($powerData)&&$powerData !== false) {
					$PowerXml = simplexml_load_string($powerData) or die("Error: Cannot create encode data to xml object");
					$PowerJsonData = json_encode($PowerXml) or die("Error: Cannot encode record to json");
					$powerdata = json_decode($PowerJsonData, true);
					if (isset($powerdata[ 'ITEM' ])) {
						date_default_timezone_set('Asia/Bangkok');
						$kwhValue = $powerdata[ 'ITEM' ][ 'KWH' ];
						$p_kwh_value = $power_meter_item->p_kwh;
						$stored_date = $power_meter_item->updated_date;
						$current_date = date('Y-m-d');
						$date_parts = date_parse($stored_date);
						$check_month = $date_parts[ 'month' ];
						$today_month = date('n') + 1;
						// if ($check_month != $today_month) {
						// 	$this->addMeterPowerMonth();
						// }
						if ($current_date > $stored_date) {
							$p_Kwh_day = $kwhValue - $p_kwh_value;
						} else {
							$p_Kwh_day = $power_meter_item->p_khw_day + ($kwhValue - $p_kwh_value);
						}

						$data_to_update = array(
							'p_kwh' => $powerdata[ 'ITEM' ][ 'KWH' ],
							'p_pf' => $powerdata[ 'ITEM' ][ 'PF' ],
							'p_khw_day' => $p_Kwh_day,
							'updated_date' => date('Y-m-d'),
						);

						$whereCondition = array('p_a_id' => $power_meter_item->p_a_id, 'p_id' => $power_meter_item->p_id);
						$this->genmod->update('s_power_meter', $data_to_update, $whereCondition);
					}else{
						// var_dump($power_meter_item);
					}
				}
			}else{
				var_dump($power_meter_item);
				return 0;
			}
		}
	}
	public function addMeterPowerMonth()
	{
		$powerData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=power_display()&emb_id=3&addr=3");
		$PowerXml = simplexml_load_string($powerData) or die("Error: Cannot create encode data to xml object");
		$PowerJsonData = json_encode($PowerXml) or die("Error: Cannot encode record to json");
		$powerdata = json_decode($PowerJsonData, true);
		$pm_month = $this->genmod->getAll('s_power_month');
		$check = 0;
		foreach ($pm_month as $item) {
			if ($item->pm_month == date('n') && $item->pm_year == date('Y') + 543) {
				$check++;
			}
		}
		if ($check == 0) {
			$power_month[ 'pm_p_id' ] = $_SESSION[ 'user_a_id' ];
			$power_month[ 'pm_month' ] = date('n');
			$power_month[ 'pm_year' ] = date("Y") + 543;
			$power_month[ 'pm_cost' ] = 0;
			$power_month[ 'pm_status_payment' ] = 1;
			$power_month[ 'pm_kw' ] = $powerdata[ 'ITEM' ][ 'KWH' ];
			$this->genmod->add('s_power_month', $power_month);
		}
	}
	public function addMeterWaterMonth()
	{
		$waterData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=water_display()&emb_id=3&addr=1");
		$waterXml = simplexml_load_string($waterData) or die("Error: Cannot create encode data to xml object");
		$waterJsonData = json_encode($waterXml) or die("Error: Cannot encode record to json");
		$waterdata = json_decode($waterJsonData, true);
		$wm_month = $this->genmod->getAll('s_water_month');
		$check = 0;
		foreach ($wm_month as $item) {
			if ($item->wm_month == date('n') && $item->wm_year == date('Y') + 543) {
				$check++;
			}
		}
		if ($check == 0) {
			$water_month[ 'wm_w_id' ] = $_SESSION[ 'user_a_id' ];
			$water_month[ 'wm_month' ] = date('n');
			$water_month[ 'wm_year' ] = date("Y") + 543;
			$water_month[ 'wm_cost' ] = 0;
			$water_month[ 'wm_payment' ] = 1;
			$water_month[ 'wm_flow_sum' ] = $waterdata[ 'ITEM' ][ 'FLOW_SUM' ];
			$this->genmod->add('s_water_month', $water_month);
		}
	}
	public function updateMeterWater()
	{
		$water_meter_items = $this->genmod->getAll('s_water_meter', '*', array('emb_id !=' => 0, 'addr !=' => 0));

		foreach ($water_meter_items as $water_meter_item) {
			$waterData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=water_display()&emb_id={$water_meter_item->emb_id}&addr={$water_meter_item->addr}");

			if ($waterData !== false) {
				$waterXml = simplexml_load_string($waterData) or die("Error: Cannot create encode data to xml object");
				$waterJsonData = json_encode($waterXml) or die("Error: Cannot encode record to json");
				$waterdata = json_decode($waterJsonData, true);

				if (isset($waterdata[ 'ITEM' ])) { // ตรวจสอบว่ามีคีย์ 'ITEM' อยู่ใน $waterdata หรือไม่
					date_default_timezone_set('Asia/Bangkok');
					$flowValue = $waterdata[ 'ITEM' ][ 'FLOW_SUM' ];
					$stored_date = $water_meter_item->updated_date;
					$w_flow_value = $water_meter_item->w_flow_sum;
					$current_date = date('Y-m-d');
					$date_parts = date_parse($stored_date);
					$check_month = $date_parts[ 'month' ];
					$today_month = date('n');

					if ($check_month != $today_month) {
						$this->addMeterWaterMonth();
					}

					if ($current_date > $stored_date) {
						if ($flowValue > 0) {
							$w_flow_sum_day = $flowValue - $w_flow_value;
						} else {
							$w_flow_sum_day = $w_flow_value;
						}
					} else {
						$w_flow_sum_day = $water_meter_item->w_flow_sum_day + ($flowValue - $w_flow_value);
					}

					$data_to_update = array(
						'w_flow_sum' => $flowValue,
						'w_flow_rate' => $waterdata[ 'ITEM' ][ 'FLOW_RATE' ],
						'w_vbatt' => $waterdata[ 'ITEM' ][ 'VBATT' ],
						'w_flow_sum_day' => $w_flow_sum_day,
						'updated_date' => date('Y-m-d')
					);

					$whereCondition = array(
						'w_id' => $water_meter_item->w_id,
						'w_a_id' => $water_meter_item->w_a_id
					);

					$this->genmod->update('s_water_meter', $data_to_update, $whereCondition);
				}
			}
		}
	}
	public function getTodayThai()
	{
		$daysOfWeek = [ "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" ];
		$months = [ "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" ];
		date_default_timezone_set('Asia/Bangkok');
		$today = new DateTime();
		$dayOfWeek = $daysOfWeek[ $today->format('w') ];
		$dayOfMonth = $today->format('d');
		$month = $months[ $today->format('n') - 1 ];
		$year = $today->format('Y') + 543;
		$ttd = "วัน" . $dayOfWeek . "ที่ " . $dayOfMonth . " " . $month . " พ.ศ. " . $year;
		return $ttd;
	}
}
