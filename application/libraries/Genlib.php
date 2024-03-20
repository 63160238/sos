<?php
defined('BASEPATH') or exit('Access Denied');
// defined('BASEPATH') or exit('No direct script access allowed');

class Genlib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }
    /**
     *
     * @return string
     */
    public function checkLogin()
    {
        if (empty($_SESSION[ 'staff_id' ]) || session_status() !== PHP_SESSION_ACTIVE) {
            //redirect to log in page
            redirect(base_url('login')); //redirects to login page
        } else {
            return "";
        }
    }
    public function updateMeterPower()
    {
        $power_meter = $this->CI->genmod->getAll('s_power_meter', '*', array('emb_id !=' => 0, 'addr !=' => 0,'p_a_id'=>$_SESSION['user_a_id']));
        if ($power_meter) {
            foreach ($power_meter as $power_meter_item) {
                if ($power_meter_item) {
                    // var_dump($power_meter_item);
                    $powerData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=power_display()&emb_id={$power_meter_item->emb_id}&addr={$power_meter_item->addr}");
                    if (isset($powerData) && $powerData !== false) {
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
                            $this->CI->genmod->update('s_power_meter', $data_to_update, $whereCondition);
                            $power_meter = $this->CI->genmod->getOne('s_room', '*', array('r_p_id' => $power_meter_item->p_id));
                            if (isset($power_meter->r_id)) {
                                $data[ 'getData_bill' ] = $this->CI->genmod->getOne(
                                    's_bill',
                                    'bil_r_id, MAX(bill_updete_at) as latest_updete_at, MAX(bill_p_khw) as bill_p_khw, MAX(bill_w_flow) as bill_w_flow ,MAX(bill_cost) as bill_cost,bill_mg_status ',
                                    array(
                                        'bil_r_id' => $power_meter->r_id
                                    ),
                                    'bil_r_id, latest_updete_at DESC',
                                    null,
                                    'bil_r_id'
                                );
                                if (isset($data[ 'getData_bill' ]->bill_p_khw)) {
                                    if ($data[ 'getData_bill' ]->bill_p_khw == 0) {
                                        $data[ 'getData_bill' ]->bill_p_khw = $powerdata[ 'ITEM' ][ 'KWH' ];
                                        $this->CI->genmod->update('s_bill', [ 'bill_p_khw' => $data[ 'getData_bill' ]->bill_p_khw ], [ 'bil_r_id' => $data[ 'getData_bill' ]->bil_r_id, 'bill_updete_at' => $data[ 'getData_bill' ]->latest_updete_at ]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    var_dump($power_meter_item);
                    return 0;
                }
            }
        }
    }
    public function updateMeterWater()
    {
        $water_meter_items = $this->CI->genmod->getAll('s_water_meter', '*', array('emb_id !=' => 0, 'addr !=' => 0,'w_a_id'=>$_SESSION['user_a_id']));
        if ($water_meter_items) {
            foreach ($water_meter_items as $water_meter_item) {
                if (isset($water_meter_item)) {
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

                            $this->CI->genmod->update('s_water_meter', $data_to_update, $whereCondition);

                            $this->CI->genmod->getOne('s_room', '*', array('r_w_id' => $water_meter_item->w_id));
                            $water_meter = $this->CI->genmod->getOne('s_room', '*', array('r_w_id' => $water_meter_item->w_id));
                            if (isset($water_meter->r_id)) {
                                $data[ 'getData_bill' ] = $this->CI->genmod->getOne(
                                    's_bill',
                                    'bil_r_id, MAX(bill_updete_at) as latest_updete_at, MAX(bill_p_khw) as bill_p_khw, MAX(bill_w_flow) as bill_w_flow ,MAX(bill_cost) as bill_cost,bill_mg_status ',
                                    array(
                                        'bil_r_id' => $water_meter->r_id
                                    ),
                                    'bil_r_id, latest_updete_at DESC',
                                    null,
                                    'bil_r_id'
                                );
                                if (isset($data[ 'getData_bill' ]->bill_w_flow)) {
                                    if ($data[ 'getData_bill' ]->bill_w_flow == 0) {
                                        $data[ 'getData_bill' ]->bill_w_flow = $waterdata[ 'ITEM' ][ 'FLOW_SUM' ];
                                        $this->CI->genmod->update('s_bill', [ 'bill_w_flow' => $data[ 'getData_bill' ]->bill_w_flow ], [ 'bil_r_id' => $data[ 'getData_bill' ]->bil_r_id, 'bill_updete_at' => $data[ 'getData_bill' ]->latest_updete_at ]);
                                    }
                                }
                            }



                        }
                    }
                }
            }
        }
    }
    function filterApartment()
    {
        $apartment = $this->CI->genmod->getAll('s_apartment', '*', array('a_status' => 1));
        return $apartment;
    }
    public function bahtThai($num)
    {
        $returnNumWord = "";
        $num = str_replace(",", "", $num);
        $num_decimal = explode(".", $num);
        $num = $num_decimal[ 0 ];
        $returnNumWord;
        $lenNumber = strlen($num);
        $lenNumber2 = $lenNumber - 1;
        $kaGroup = array("", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
        $kaDigit = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ต", "แปด", "เก้า");
        $kaDigitDecimal = array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ต", "แปด", "เก้า");
        $ii = 0;
        for ($i = $lenNumber2; $i >= 0; $i--) {
            $kaNumWord[ $i ] = substr($num, $ii, 1);
            $ii++;
        }
        $ii = 0;
        for ($i = $lenNumber2; $i >= 0; $i--) {
            if (($kaNumWord[ $i ] == 2 && $i == 1) || ($kaNumWord[ $i ] == 2 && $i == 7)) {
                $kaDigit[ $kaNumWord[ $i ] ] = "ยี่";
            } else {
                if ($kaNumWord[ $i ] == 2) {
                    $kaDigit[ $kaNumWord[ $i ] ] = "สอง";
                }
                if (($kaNumWord[ $i ] == 1 && $i <= 2 && $i == 0) || ($kaNumWord[ $i ] == 1 && $lenNumber > 6 && $i == 6)) {
                    if ($kaNumWord[ $i + 1 ] == 0) {
                        $kaDigit[ $kaNumWord[ $i ] ] = "หนึ่ง";
                    } else {
                        $kaDigit[ $kaNumWord[ $i ] ] = "เอ็ด";
                    }
                } elseif (($kaNumWord[ $i ] == 1 && $i <= 2 && $i == 1) || ($kaNumWord[ $i ] == 1 && $lenNumber > 6 && $i == 7)) {
                    $kaDigit[ $kaNumWord[ $i ] ] = "";
                } else {
                    if ($kaNumWord[ $i ] == 1) {
                        $kaDigit[ $kaNumWord[ $i ] ] = "หนึ่ง";
                    }
                }
            }
            if ($kaNumWord[ $i ] == 0) {
                if ($i != 6) {
                    $kaGroup[ $i ] = "";
                }
            }
            $kaNumWord[ $i ] = substr($num, $ii, 1);
            $ii++;

            $returnNumWord .= $kaDigit[ $kaNumWord[ $i ] ] . $kaGroup[ $i ];
        }
        if (isset($num_decimal[ 1 ])) {
            $returnNumWord .= "จุด";
            for ($i = 0; $i < strlen($num_decimal[ 1 ]); $i++) {
                $returnNumWord .= $kaDigitDecimal[ substr($num_decimal[ 1 ], $i, 1) ];
            }
        }
        return $returnNumWord . "บาทถ้วน";
    }
    public function ajaxOnly()
    {
        //display uri error if request is not from AJAX
        if (!$this->CI->input->is_ajax_request()) {
            redirect(base_url());
        } else {
            return "";
        }
    }
    public function update_pay_status()
{
    $room = $this->CI->genmod->getAll('s_room', "*", array('pay_status=' => 1));
    // Check if $room is an array before using foreach
    if (is_array($room)) {
        $date = $this->CI->genmod->getOne('s_apartment', "a_lateday", array('a_id=' => $_SESSION['user_a_id']));
        date_default_timezone_set('Asia/Bangkok');
        $currentDate = date('Y-m-d');

        // Check if it's the 7th day of the month
        if (date('d', strtotime($currentDate)) ==$date->a_lateday){
            foreach ($room as $key => $value) {
                if ($value->pay_status == 1) {
                    // Update pay_status to 4 for this room
                    $data = array('pay_status' => 4);
                    $where = array('r_id' => $value->r_id); // Update only this room
                    $this->CI->genmod->update('s_room', $data, $where);
                    $this->CI->genmod->update('s_bill', array("bill_status"=>3),array('bil_r_id' => $value->r_id) );
                }
            }
        }
    } else {
        // Handle the case where $room is not an array (e.g., database query returned no results)
        // You can log an error, throw an exception, or handle it based on your application's logic
        // For now, let's just log it as an error
        error_log("No rooms found with pay_status = 1");
    }
}


}
