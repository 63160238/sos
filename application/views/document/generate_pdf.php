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
function numberToThaiWord($number) {
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
    return date('d', $dateTime) . ' ' . thaiMonthFull(date('n', $dateTime)) . ' ' . (date('Y', $dateTime) + 543);
}
$pdf->AddPage();
$data = $_POST['content'];
if (isset($_POST['receiptData'])) {
    $receiptData = $_POST['receiptData'];
    $receiptData = json_decode($receiptData);
}
$outputDir = $_SERVER['DOCUMENT_ROOT'] . '/smart_apartment_system/assets/docs/regis';
$content = json_decode($data);
if ($content !== null) {
    if (isset($content->receipt)) {
        $t_detail =  '<p style="text-align: center;">' . $receiptData->a_name . '</p>
        <p style="text-align: center;">' . $receiptData->a_adds . '</p>
        <p style="text-align: center;">ใบเสร็จรับเงิน / Receipt</p>
        <table style="border-collapse: collapse; width: 100%;" border="1">
        <tbody>
        <tr style="height: 10px;">
        <td style="height: 20px; width: 62.4698%; text-align: left;" colspan="3" rowspan="3">
        <span style="text-align: center; ">ข้อมูลผู้เช่า</span>
        <p>&nbsp; ชื่อ Name: '.$receiptData->fullname.'</p>
        <p>&nbsp; ที่อยู่ Address:&nbsp;'.$receiptData->regis_addr.'</p>
        </td>
        <td style="width: 14.0834%; height: 10px; text-align: center;">
        <span style="font-size: 9.38px;">หมายเลขใบเสร็จ</span>
        </td>
        <td style="width: 20.9968%; height: 10px; text-align: center;">
        <span style="font-size: 9.38px;">' . $content->receipt . '</span></td>
        </tr>
        <tr style="height: 18px;">
        <td style="width: 14.0834%; height: 10px; text-align: center;">
        <span style="font-size: 9.38px;">วันที่ Date</span>
        </td>
        <td style="width: 20.9968%; height: 10px; text-align: center;">
        <span style="font-size: 9.38px;">' . thaiDate_Full($receiptData->bill_updete_at) . '</span>
        </td>
        </tr>
        <tr style="height: 18px;">
        <td style="width: 14.0834%; height: 19px; text-align: center;">
        <span style="font-size: 9.38px;">ห้อง Room</span>
        </td>
        <td style="width: 20.9968%; height: 19px; text-align: center;">
        <span style="font-size: 9.38px;">' . $receiptData->r_name . '</span>
        </td>
        </tr>
        <tr style="height: 18px;">
        <td style="text-align: center; width: 9.81331%; height: 18px;">
        <h6>ลำดับ</h6>
        </td>
        <td style="text-align: center; width: 40.1565%; height: 18px;">
        <h6>รายการ</h6>
        </td>
        <td style="width: 12.5%; text-align: center; height: 18px;">
        <h6>จำนวนหน่วย</h6>
        </td>
        <td style="width: 14.0834%; text-align: center; height: 18px;">
        <h6>ราคาต่อหน่วย</h6>
        </td>
        <td style="width: 20.9968%; height: 18px; text-align: center;">
        <h6>จำนวนเงิน&nbsp;</h6>
        </td>
        </tr>
        <tr style="height: 110px;">
        <td style="text-align: center; width: 9.81331%; height: 44px;">
        <p><span style="font-size: 9.38px;">1</span></p>
        <p><span style="font-size: 9.38px;">2</span></p>
        <p><span style="font-size: 9.38px;">3</span></p>
        </td>
        <td style="text-align: center; width: 40.1565%; height: 44px;">
        <p><span style="font-size: 9.38px;">ค่าห้อง</span></p>
        <p><span style="font-size: 9.38px;">ค่าไฟ</span></p>
        <p><span style="font-size: 9.38px;"><span style="font-size: 9.38px;">ค่าน้ำ</span></span></p>
        <p>&nbsp;</p>
        </td>
        <td style="width: 12.5%; text-align: center; height: 44px;">
        <p><span style="font-size: 9.38px;">' . ($receiptData->bill_cost - ((($receiptData->bill_p_khw_moth)*$receiptData->a_power_cost) + (($receiptData->bill_w_flow_month)*$receiptData->a_water_cost))) . '</span></p>
        <p><span style="font-size: 9.38px;">' . $receiptData->bill_p_khw_moth . '</span></p>
        <p><span style="font-size: 9.38px;">' . $receiptData->bill_w_flow_month . '</span></p>
        </td>
        <td style="width: 14.0834%; text-align: center; height: 44px;">
        <p><span style="font-size: 9.38px;">1</span></p>
        <p><span style="font-size: 9.38px;">' . $receiptData->a_power_cost . '</span></p>
        <p><span style="font-size: 9.38px;">' . $receiptData->a_water_cost . '</span></p>
        </td>
        <td style="width: 20.9968%; text-align: center; height: 44px;">
        <p><span style="font-size: 9.38px;">' . ($receiptData->bill_cost - ((($receiptData->bill_p_khw_moth)*$receiptData->a_power_cost) + (($receiptData->bill_w_flow_month)*$receiptData->a_water_cost))) . ' บาท</span></p>
        <p><span style="font-size: 9.38px;">' . (($receiptData->bill_p_khw_moth) * $receiptData->a_power_cost) . ' บาท</span></p>
        <p><span style="font-size: 9.38px;">' . (($receiptData->bill_w_flow_month) * $receiptData->a_water_cost) . ' บาท</span></p>
        </td>
        </tr>
        <tr style="height: 12px;">
        <td style="text-align: center; width: 62.4698%; height: 12px;" colspan="3">
        <h5>('.numberToThaiWord($receiptData->bill_cost).')</h5>
        </td>
        <td style="width: 14.0834%; text-align: center; height: 12px;">
        <h6>จำนวนเงินรวม</h6>
        </td>
        <td style="width: 20.9968%; text-align: center; height: 12px;">
        <h5>' . $receiptData->bill_cost . ' บาท</h5>
        </td>
        </tr>
        </tbody>
        </table>';
        $pdf->writeHTML($t_detail, true, false, true, false, '');
    } else {
        $content->regis_room_tcost = thaiDigit($content->regis_room_cost);
        $content->regis_tinsurance = thaiDigit($content->regis_insurance);
        foreach ($content as $key => $value) {
            if ($key != 't_detail') {
                $content->t_detail = str_replace("\$$key", $value, $content->t_detail);
            }
        }
        $outputFile = $outputDir . '\regis' . $content->regis_a_id . $content->r_name . $content->u_id . ".pdf";
        $pdf->writeHTML($content->t_detail, true, false, true, false, '');
    }
} else {
    $pdf->writeHTML($data, true, false, true, false, '');
}
// Set some content to the PDF (example)
$html = '<h1>Hello, TCPDF!</h1>';
// Close and output PDF document
if ($_POST['show'] == 1) {
    $pdf->Output('I');
} else {
    $pdf->Output($outputFile, 'F');
    $pdf->Output($outputFile, 'I');
}
