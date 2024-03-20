<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smart_apartment_system/vendor/autoload.php';
define('PROMPT_REGULAR', TCPDF_FONTS::addTTFfont($_SERVER['DOCUMENT_ROOT'] . '/smart_apartment_system/application/third_party/tcpdf/fonts/Prompt-Regular.ttf', 'TrueTypeUnicode'));
define('PROMPT_BOLD', TCPDF_FONTS::addTTFfont($_SERVER['DOCUMENT_ROOT'] . '/smart_apartment_system/application/third_party/tcpdf/fonts/Prompt-Bold.ttf', 'TrueTypeUnicode'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$html = '<bookmark content="Start of the Document" /><div>Section 1 text</div>';
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Title');
$pdf->SetSubject('Subject');
$pdf->SetKeywords('Keywords');
$pdf->SetFont(PROMPT_REGULAR, '', 14);
// ตั้งค่าฟอนต์ที่รองรับภาษาไทย
// Add a page
function thaiDigit($num)
{
    return str_replace(
        array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
        array("o", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"),
        $num
    );
}
function numberToThaiWord($number)
{
    // ตัวเลขต่อไปนี้
    $digit = array(
        'ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'
    );
    // หลักต่าง ๆ
    $units = array(
        '', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน'
    );

    $result = '';

    // กำจัดเลข 0 หน้าที่ไม่จำเป็น
    $number = intval($number);
    // กำจัดช่องว่างที่ขึ้นต้น
    $number = trim($number);

    // หากเป็น 0 ก็คืนค่าเป็น "ศูนย์"
    if ($number == 0) {
        return $digit[0];
    }

    // แปลงตัวเลขเป็นตัวอักษร
    $i = 0;
    while ($number > 0) {
        $digit_num = $number % 10;
        if ($digit_num > 0) {
            $result = $digit[$digit_num] . $units[$i] . $result;
        }
        $number = floor($number / 10);
        $i++;
    }

    return $result;
}
function thaiDate($dateTime){
    $date =strtotime($dateTime);
    return date('j',$date);
  }
function thaiMonthFull($month)
{
    $thaiMonthFull = array(
        "1" => "มกราคม",
        "2" => "กุมภาพันธ์",
        "3" => "มีนาคม",
        "4" => "เมษายน",
        "5" => "พฤษภาคม",
        "6" => "มิถุนายน",
        "7" => "กรกฎาคม",
        "8" => "สิงหาคม",
        "9" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    );
    return $thaiMonthFull[$month];
}
function thaiDate_Full($dateTime)
{
    $dateTime = strtotime($dateTime);
    return  thaiMonthFull(date('n', $dateTime)) . ' พ.ศ. ' . (date('Y', $dateTime) + 543);
}
$pdf->AddPage();
$data = $_POST['data'];
if ($data) {
    $data = json_decode($data);
}
$t_detail =  '<h2 style="text-align: center;">บิลค่าเช่า</h2>
<p style="text-align: center;">ห้องที่&nbsp;'.$data->s_room->r_name.'</p>
<p style="text-align: center;">ประจำเดือน '. thaiDate_Full($data->getData_bill->bill_updete_at).'</p>
<table style="border-collapse: collapse; width: 105.407%; height: 151px; margin-left: auto; margin-right: auto;" border="1">
<tbody>
<tr style="height: 18px;">
<td style="width: 20.314%; height: 18px; text-align: center;"><strong>ลำดับ / NO.</strong></td>
<td style="width: 23.6007%; height: 18px; text-align: center;">
<p><strong>รายการ</strong></p>
</td>
<td style="width: 18.6716%; height: 18px; text-align: center;"><strong>จำนวนหน่วยที่ใช้</strong></td>
<td style="width: 19.6493%; height: 18px; text-align: center;"><strong>ราคาหน่วยละ</strong></td>
<td style="width: 11.9759%; height: 18px; text-align: center;"><strong>จำนวนเงิน</strong></td>
</tr>
<tr style="height: 18px;">
<td style="width: 20.314%; height: 18px; text-align: center;">
<p>1</p>
<p>&nbsp;</p>
</td>
<td style="width: 23.6007%; height: 18px; text-align: center;"><span style="text-align: center;">ค่าเช่าห้อง</span></td>
<td style="width: 18.6716%; height: 18px; text-align: center;"><span style="text-align: center;"> 1 หน่วย</span></td>
<td style="width: 19.6493%; height: 18px; text-align: center;"><span style="text-align: center;">'.$data->getData->ac_type_cost .' หน่วย</span></td>
<td style="width: 11.9759%; height: 18px; text-align: center;"><span style="text-align: center;">'.$data->getData->ac_type_cost.' บาท</span></td>
</tr>
<tr style="height: 18px;">
<td style="width: 20.314%; height: 18px; text-align: center;">
<p>2</p>
<p>&nbsp;</p>
</td>
<td style="width: 23.6007%; height: 18px; text-align: center;"><span style="text-align: center;">ค่าไฟ</span></td>
<td style="width: 18.6716%; height: 18px; text-align: center;"><span style="text-align: center;">'.$data->getData_bill->bill_p_khw_moth .'</span></td>
<td style="width: 19.6493%; height: 18px; text-align: center;"><span style="text-align: center;">'.$data->getData_partment->a_power_cost.' หน่วย</span></td>
<td style="width: 11.9759%; height: 18px; text-align: center;"><span style="text-align: center;">'.($data->getData_bill->bill_p_khw_moth*$data->getData_partment->a_power_cost).' บาท</span></td>
</tr>
<tr style="height: 19px;">
<td style="width: 20.314%; height: 19px; text-align: center;">
<p>3</p>
<p>&nbsp;</p>
</td>
<td style="width: 23.6007%; height: 19px; text-align: center;">ค่าน้ำ</td>
<td style="width: 18.6716%; height: 19px; text-align: center;">'.$data->getData_bill->bill_w_flow_month .' หน่วย</td>
<td style="width: 19.6493%; height: 19px; text-align: center;">'.$data->getData_partment->a_water_cost .' บาท</td>
<td style="width: 11.9759%; height: 19px; text-align: center;">'.($data->getData_bill->bill_w_flow_month*$data->getData_partment->a_water_cost).' บาท</td>
</tr>
<tr style="height: 18px;">
<td style="width: 20.314%; height: 18px;">
<p>รวม</p>
<p>&nbsp;</p>
</td>
<td style="width: 61.9216%; height: 18px;" colspan="3">&nbsp;</td>
<td style="width: 11.9759%; height: 18px; text-align: right;">'.($data->getData->ac_type_cost+($data->getData_bill->bill_p_khw_moth*$data->getData_partment->a_power_cost)+($data->getData_bill->bill_w_flow_month*$data->getData_partment->a_water_cost)).' บาท</td>
</tr>
</tbody>
</table>
<p style="text-align: left;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ชำระเงินทุกวันที่ '.thaiDate($data->getData_partment->a_lateday) .' ของเดือน ที่เบอร์พร้อมเพย์: '.$data->getData_partment->promptpay_no.'</p>';
$pdf->writeHTML($t_detail, true, false, true, false, '');
$pdf->Output('','D');
