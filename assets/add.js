var defalut = ['{ ชื่อผู้เช่า }','{ ชื่อหอพัก }','{ วันที่ปัจจุบัน }','{ ที่อยู่หอพัก }','{ หมายเลขบัตรประชาชนผู้เช่า }','{ ที่อยู่ผู้เช่า }','{ เบอร์โทรผู้เช่า }','{ หมายเลขห้องพัก }','{ ระยะเวลาสัญญา }','{ วันที่เริ่มทำสัญญา }','{ วันที่สิ้นสุดสัญญา }','{ เงินประกันห้อง }','{ เงินประกันห้องเลขไทย }','{ เงินค่าเช่าห้อง }','{ เงินค่าเช่าห้องเลขไทย }','{ วันที่สิ้นสุดการชำระเงิน }'];
var defalut2 = ['$u_name','$a_name','.$today','$a_adds','$register_id', '$regis_addr', '$regis_phone','$r_name','$regis_period','$regis_start_date','$regis_end_date','$regis_insurance','$regis_tinsurance','$regis_room_cost','$regis_room_tcost','.$today']; 
var content = [];
var content2 = [];
let index = 0;
$('.button').click(function() {
    var buttonId = $(this).attr('id');
    if (buttonId == 'userName') {
      content[index] = defalut[0];
      content2[index] = defalut2[0];
    }
    if (buttonId == 'apartmentName') {
      content[index] = defalut[1];
      content2[index] = defalut2[1];
    }
    if (buttonId == 'today') {
      content[index] = defalut[2];
      content2[index] = defalut2[2];
    }
    if (buttonId == 'addr') {
      content[index] = defalut[3];
      content2[index] = defalut2[3];
    }
    if (buttonId == 'u_id') {
      content[index] = defalut[4];
      content2[index] = defalut2[4];
    }
    if (buttonId == 'u_addr') {
      content[index] = defalut[5];
      content2[index] = defalut2[5];
    }
    if (buttonId == 'u_phone') {
      content[index] = defalut[6];
      content2[index] = defalut2[6];
    }
    if (buttonId == 'r_id') {
      content[index] = defalut[7];
      content2[index] = defalut2[7];
    }
    if (buttonId == 'period') {
      content[index] = defalut[8];
      content2[index] = defalut2[8];
    }
    if (buttonId == 'start_d') {
      content[index] = defalut[9];
      content2[index] = defalut2[9];
    }
    if (buttonId == 'end_d') {
      content[index] = defalut[10];
      content2[index] = defalut2[10];
    }
    if (buttonId == 'cost_c') {
      content[index] = defalut[11];
      content2[index] = defalut2[11];
    }
    if (buttonId == 'cost_ct') {
      content[index] = defalut[12];
      content2[index] = defalut2[12];
    }
    if (buttonId == 'cost_r') {
      content[index] = defalut[13];
      content2[index] = defalut2[13];
    }
    if (buttonId == 'cost_rt') {
      console.log('เข้า');
      content[index] = defalut[14];
      content2[index] = defalut2[14];
    }
    if (buttonId == 'pay_end') {
      content[index] = defalut[15];
      content2[index] = defalut2[15];
    }
    var textContainer = tinymce.get('editor');
    if (textContainer !== undefined) {
      var currentPosition = textContainer.selection.getRng();
      if (currentPosition !== undefined) {
        textContainer.insertContent(content[index]);
      }
    }
    index++;
  });