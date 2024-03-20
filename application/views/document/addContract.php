<div class="col-lg-12">
  <div class="card">
    <div class="card-header bg-info">
      <h4 class="mb-0 text-white text-center" style="font-size: 20px;">แบบฟอร์มสัญญาเช่า</h4>
    </div>
    <div class="col-12 mt-2">
      <button id="apartmentName" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ชื่อหอพัก</button>
      <button id="userName" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ชื่อผู้เช่า</button>
      <button id="today" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> วันที่ปัจจุบัน</button>
      <button id="addr" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ที่อยู่หอพัก</button>
      <button id="u_id" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> หมายเลขบัตรประชาชนผู้เช่า</button>
      <button id="u_addr" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ที่อยู่ผู้เช่า</button>
      <button id="u_phone" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> เบอร์โทรผู้เช่า</button>
      <button id="r_id" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> หมายเลขห้องพัก</button>
      <button id="period" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ระยะเวลาสัญญา</button>
      <button id="start_d" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> วันที่เริ่มต้นสัญญา</button>
      <button id="end_d" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> วันที่สิ้นสุดสัญญา</button>
      <button id="cost_c" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> เงินประกันห้อง</button>
      <button id="cost_ct" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> เงินประกันห้องเลขไทย</button>
      <button id="cost_r" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ค่าเช่าห้อง</button>
      <button id="cost_rt" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> ค่าเช่าห้องเลขไทย</button>
      <button id="pay_end" type="button" name="value[]" class="btn btn-info button mt-2"><i class="mdi mdi-water-pump"> </i> วันที่สิ้นสุดการชำระเงิน</button>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
      <div class="form-body">
        <div class="card-body">
          <div class="row pt-3">
            <div class="col-12">
              <div class="form-group">
                <h3>เลือก Template</h3>
                <div class="row">
                  <div class="col-6">
                    <select class="form-control" name="" id="template">
                      <option value="0"> สร้าง Template ใหม่</option>
                      <?php
                      foreach ($template as $t) {
                        echo '<option value="' . $t->t_id . '">' . $t->t_name . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-6">
                    <div class="row">
                      <div class="col-6">
                        <button id="edit" type="button" class="btn btn-warning  btn-block hide"><i class="mdi mdi-water-pump"> </i> แก้ไข Template</button>
                      </div>
                      <div class="col-6">
                        <p id="text1" class=" hide" style="color:red;">* กรุณากดปุ่มแก้ไขเพื่อแก้ไขรายละเอียด</p>
                      </div>
                    </div>
                    <div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <div id="t_name" class="row">
                  <div class="col-1">
                    <h4 class="form-label">ชื่อ Template: </h4>
                  </div>
                  <div class="col-6">
                    <input id="tname" class="form-control" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">รายละเอียด Template สัญญาเช่า</label>
                <textarea class="form-control" id="editor" name="html_content" rows="10"></textarea>
              </div>
              <div class="row">
                <div class="col-md-3 text-left">
                  <button id="print" type="button" class="btn btn-primary btn-lg btn-block"><i class="mdi mdi-water-pump"> </i> พิมพ์ตัวอย่างเอกสาร</button>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-3">
                      <button id="default" type="button" class="btn btn-secondary btn-lg btn-block"><i class="mdi mdi-water-pump"> </i> กลับสู่สัญญาเริ่มต้น</button>
                    </div>
                    <div class="col-md-3">
                      <button id="submit" type="button" class="btn btn-success btn-lg btn-block float-right"><i class="mdi mdi-water-pump"> </i> บันทึกสัญญาเช่า</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
    </form>
  </div>
</div>

<script src="<?= base_url() ?>assets/add.js"></script>
<script>
  var formData = {};
  $(function() {
    // Initialize Bootstrap-wysihtml5 editor
    tinymce.init({
      selector: '#editor',
      plugins: 'table'
    });
  });

  let index2 = defalut2.length;

  $('#template').change(function() {
    if ($(this).val() == '0') {
      $('#edit').hide();
      $('#text1').hide();
      var textContainer = tinymce.get('editor');
      textContainer.setContent('');
      $('#tname').val('');
      $('#tname').prop('disabled', false);
      tinyMCE.get('editor').getBody().setAttribute('contenteditable', true);
    } else {
      tinyMCE.get('editor').getBody().setAttribute('contenteditable', false);
      $('#edit').show();
      $('#text1').show();
      $('#tname').prop('disabled', true);
    }
  });

  function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }
  $('#edit').click(function() {
    $('#text1').hide();
    $('#tname').prop('disabled', false);
    tinyMCE.get('editor').getBody().setAttribute('contenteditable', true);
    let edit = {};
    edit['t_id'] = $('#template').val();
    $.ajax({
      method: "post",
      url: 'editTemplate',
      data: edit
    }).done(function(returnData) {
      var textContainer = tinymce.get('editor');
      for (var i = 0; i < index2; i++) {
        returnData['t_detail'] = returnData['t_detail'].replace(new RegExp(escapeRegExp(defalut2[i]), 'g'), defalut[i]);
        console.log(returnData['t_detail']);
      }
      textContainer.setContent('');
      textContainer.insertContent(returnData['t_detail']);
      $('#tname').val(returnData['t_name']);
      // console.log(returnData);
    });
  });
  $('#default').click(function() {
    $('#text1').hide();
    $('#edit').show();
    $('#tname').prop('disabled', false);
    tinyMCE.get('editor').getBody().setAttribute('contenteditable', true);
    let def = {};
    def['t_id'] = 6;
    $.ajax({
      method: "post",
      url: 'editTemplate',
      data: def
    }).done(function(returnData) {
      var textContainer = tinymce.get('editor');
      for (var i = 0; i < index2; i++) {
        returnData['t_detail'] = returnData['t_detail'].replace(new RegExp(escapeRegExp(defalut2[i]), 'g'), defalut[i]);
        console.log(returnData['t_detail']);
      }
      textContainer.setContent('');
      textContainer.insertContent(returnData['t_detail']);
      $('#tname').val(returnData['t_name']);
      $('#template').val(6);
      // console.log(returnData);
    });
  });
  $('#submit').click(function() {
    var textContainer = tinymce.get('editor').getContent();
    var oldtext = textContainer;
    for (var i = 0; i < index2; i++) {
      textContainer = textContainer.replace(new RegExp(escapeRegExp(defalut[i]), 'g'), defalut2[i]);
      console.log(textContainer);
    }
    formData['t_detail'] = textContainer;
    formData['choose'] = $('#template').val();
    formData['t_name'] = $('#tname').val();
    if (!formData['t_name']) {
      !formData['t_name'] ? $('#tname').get(0).focus() : '';
      $.toast({
        heading: 'พบข้อผิดพลาด',
        text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
        position: 'top-right',
        loaderBg: '#FF5733',
        icon: 'error',
        hideAfter: 3500,
        stack: 6
      })
      return false;
    }
    $.ajax({
      method: "post",
      url: 'saveTemplate',
      data: formData
    }).done(function(returnData) {
      // console.log(returnData);
      if (returnData.status == 1) {
        $.toast({
          heading: 'สำเร็จ',
          text: returnData.msg,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          stack: 6
        });
        setTimeout(function() {
          location.reload();
        }, 3500);
      }
    });
  });

  $('#print').click(function() {
    var textContainer = tinymce.get('editor').getContent();
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // เมื่อได้รับข้อมูล PDF จากเซิร์ฟเวอร์
        // สร้าง URL object จากข้อมูลที่ได้รับ

        var pdfURL = URL.createObjectURL(xhr.response);
        console.log(pdfURL);
        // เปิดหน้าต่างใหม่เพื่อแสดง PDF
        window.open(pdfURL);
      }
    };
    var formData = new FormData();
    formData.append('show', 1);
    formData.append('content', textContainer);
    var path = "../application/views/document/generate_pdf.php"
    // สร้างคำร้องขอไปยังไฟล์ PHP ที่สร้าง PDF
    xhr.open("POST", path, true);

    xhr.responseType = "blob"; // รับข้อมูลเป็น blob
    xhr.send(formData);
  });
</script>