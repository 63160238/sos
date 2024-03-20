<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  require_once APPPATH."/third_party/tcpdf/tcpdf.php";

  class Pdf extends TCPDF {

      public function __construct() {
          parent::__construct();

      }

      // สร้าง function ชื่อ Header สำหรับปรับแต่งการแสดงผลในส่วนหัวของเอกสาร
    public function Header()
    {
        // $image_file = K_PATH_IMAGES.'logo-icon.png';
        $image_file = FCPATH.'logo-icon.png';
        // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

       $this->Image($image_file, 15, 3, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
       // Set font
       $this->SetFont('thsarabunnew', 'B', 16);
       // Title
       //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
       $this->setY(5);
       $headerX = 20;
       // $this->Cell($headerX, 0, '', 0, 0, 'L', 0, '', 0);
       $this->Cell(0, 10, 'Nice Store App', 0, 1, 'L', 0, '', 0, false);
       // $this->SetFont('thsarabunnew', '', 12);
       // $this->Cell($headerX, 0, '', 0, 0, 'L', 0, '', 0);
       // $this->Cell(0, 0, '333/3 หมู่ 3 ตำบลเสม็ด อำเภอเมืองชลบุรี จังหวัดชลบุรี 20000', 0, 1, 'L', 0, '', 0, false, 'C', 'C');
       // $this->SetFont('thsarabunnew', 'B', 14);
       // $this->Cell($headerX, 0, '', 0, 0, 'L', 0, '', 0);
       // $this->Cell(0, 0, 'สอนให้คิดเป็น เน้นพหุภาษา พัฒนาคุณธรรม ก้าวนำ ICT', 0, 1, 'L', 0, '', 0, false, 'T', 'T');

       // $this->setXY(30,25);
       // $this->Cell(0, 50, 'โรงเรียนอนุบาลเมืองใหม่ชลบุรี', 0, 1, 'R', 0, '', 0, false, 'B', 'B');
       $this->writeHTML("<hr>", true, false, false, false, '');
       // $this->Cell(0, 0, 'TEST CELL STRETCH: no stretch', 1, 1, 'C', 0, '', 0);
       // $this->Cell(0, 15, 'โรงเรียนอนุบาลเมืองใหม่ชลบุรี', 0, false, 'C', 0, '', 0, false, 'B', 'B');
    }

    // สร้าง function ชื่อ Footer สำหรับปรับแต่งการแสดงผลในส่วนท้ายของเอกสาร
    public function Footer()
    {
        // กำหนดตำแหน่งที่จะแสดงรูปภาพและข้อความ 15mm นับจากท้ายเอกสาร
        $this->SetY(-15);
        // คำสั่งสำหรับแทรกรูปภาพ กำหนดที่อยู่ไฟล์รูปภาพในเครื่องของเรา
        // $this->Image('mmc_logo.png');
        $this->writeHTML("<hr>", true, false, false, false, '');
        // สำหรับตัวอักษรที่จะใช้คือ helvetica เป็นตัวหนา และขนาดอักษรคือ 10
        $this->SetFont('thsarabunnew', '', 10);

        $this->Cell(30, '',	$_SESSION['user_fullname']. ' พิมพ์ ณ. วันที่ '.thaiDate(date('Y-m-d')) .' เวลา '.date('G:i'), 0, false, 'L');

        $this->SetFont('thsarabunnew', 'B', 10);
        // คำสั่งสำหรับแสดงข้อความ โดยกำหนด ความกว้าง และ ความสูงของข้อความได้ใน 2 ช่องแรก
        // ช่องที่ 3 คือข้อความที่แสดง ส่วนค่า C คือ กำหนดให้แสดงข้อความตรงกลาง
        // $this->Cell('', '', 'By IV Soft CO.,LTD', 0, false, 'C');

        // สำหรับตัวอักษรที่จะใช้คือ helvetica เป็นตัวเอียง และขนาดอักษรคือ 8
        $this->SetFont('thsarabunnew', 'I', 8);
        // คำสั่งสำหรับแสดงข้อความ โดยกำหนด ความกว้าง และ ความสูงของข้อความได้ใน 2 ช่องแรก
        // ช่องที่ 3 คือข้อความที่แสดง $this->getAliasNumPage() คือ หมายเลขหน้าปัจจุบัน และ $this->getAliasNbPages() จำนวนหน้าทั้งหมด
        // ส่วนค่า R คือ กำหนดให้แสดงข้อความชิดขวา
          $this->Cell('', '', 'หน้า ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R');
    }
  }

?>
