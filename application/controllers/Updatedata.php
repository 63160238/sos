<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Updatedata extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->genlib->checkLogin();
	}
  public function Updata_meter()
	{
		// $powerData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=power_display()&emb_id=3&addr=3");
    // $waterData = file_get_contents("http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=water_display()&emb_id=3&addr=1");
		// $PowerXml = simplexml_load_string($powerData) or die("Error: Cannot create encode data to xml object");
    // $PowerXml = simplexml_load_string($waterData) or die("Error: Cannot create encode data to xml object");
    // $PowerJsonData = json_encode($PowerXml) or die("Error: Cannot encode record to json");
    // $waterJsonData = json_encode($PowerXml) or die("Error: Cannot encode record to json");
		// $powerdata = json_decode($PowerJsonData, true);
    // $waterdata = json_decode($waterJsonData, true);
    $this->genlib->ajaxOnly();
		$postData = $this->input->post();
    $whereCondition = array('p_id' => 1);
		// var_dump($data['ITEM'][0]['SS_LABEL']);
		// $this->genlib->ajaxOnly();
		// $postData = $this->input->post();
		// var_dump($postData);

		$this->genmod->update('s_power_meter', $postData,$whereCondition);
	}

}



