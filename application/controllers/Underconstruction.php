<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Underconstruction extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->genlib->checkLogin();
	}

	public function index()	{
		$values['pageTitle'] = 'Under construction';
		$values['breadcrumb'] = 'Under construction';
		// $values['newBtn'] = 'เพิ่มร้านค้า';
		$values['pageContent'] = $this->load->view('undercon', "", TRUE);
		$this->load->view('main', $values);
	}


}
