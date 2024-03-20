<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="usersForm" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-6">
              <label for="user">ชื่อผู้เช่า <span class="text-danger"> *</span></label>
              <select class="form-control" id="u_id" name="inputValue[]" <?= is_array($getU) ? '' : "disabled" ?>>
                <option value="0">เลือกผู้เช่า</option>
                <?php if (is_array($getU)) : ?>
                  <?php foreach ($getU as $key => $value) : ?>
                    <option value="<?= $value->user_id ?>"><?= $value->fname_th . " " . $value->lname_th ?></option>
                  <?php endforeach; ?>
                <?php else : ?>
                  <option selected value="<?= $getU->user_id ?>"><?= $getU->fname_th . " " . $getU->lname_th ?></option>
                <?php endif; ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label>เลือก template สัญญา<span class="text-danger"> *</span></label>
              <select class="form-control" id="regis_doc_tem" name="inputValue[]" <?= isset($view) ? "disabled"  : "" ?>>
                <option value="0" selected disabled>เลือก Template</option>
                <?php foreach ($getTemplate as $key => $value) : ?>
                  <option value="<?= $value->t_id ?>" <?= !is_array($getRU)  && $getRU->regis_doc_tem ==  $value->t_id  ? "selected"  : "" ?>>
                    <?= $value->t_name ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-4 hide">
              <label for="t_detail">template detail<span class="text-danger"> *</span></label>
              <input name="inputValue[]" type="text" class="form-control form-control-line" disabled id="t_detail" required>
            </div>
          </div>
        </div>
        <hr>
        <div class="card-body">
          <h5>ข้อมูลทำสัญญาเช่า</h5>
          <div class="row">
            <div class="form-group col-4">
              <label for="fname_th">ชื่อ Apartment<span class="text-danger"> *</span></label>
              <input name="inputValue[]" type="text" class="form-control form-control-line" value="<?= isset($getAp) ? $getAp->a_name : "" ?>" disabled id="a_name" required>
            </div>
            <div class="form-group col-4 hide">
              <label for="fname_th">ชื่อ Apartment<span class="text-danger"> *</span></label>
              <input name="inputValue[]" type="text" class="form-control form-control-line" value="<?= is_array($getRU) ? ""  : $getRU->regis_a_id ?>" disabled id="regis_a_id" required>
            </div>
            <div class="form-group col-4">
              <label for="fname_th">ที่อยู่ Apartment<span class="text-danger"> *</span></label>
              <input name="inputValue[]" type="text" class="form-control form-control-line" value="<?= isset($getAp) ? $getAp->a_adds : "" ?>" disabled id="a_adds" required>
            </div>
            <div class="form-group col-4">
              <label for="fname_th">เลขห้อง<span class="text-danger"> *</span></label>
              <input name="inputValue[]" type="text" class="form-control form-control-line" value="<?= isset($getRoom) ? $getRoom->r_name  : "" ?>" disabled id="r_name" required>
            </div>
            <div class="form-group col-4">
              <label for="u_phone">เบอร์โทรผู้เช่า<span class="text-danger"> *</span></label>
              <input name="inputValue1[]" type="text" class="form-control form-control-line" value="<?= is_array($getRU) ? ""  : $getRU->regis_phone ?>" <?= is_array($getRU) || isset($view) ? "disabled"  : "" ?> id="regis_phone" required>
            </div>
            <div class="form-group col-4">
              <label for="u_phone">ที่อยู่ผู้เช่า<span class="text-danger"> *</span></label>
              <input name="inputValue1[]" type="text" class="form-control form-control-line" value="<?= is_array($getRU) ? ""  : $getRU->regis_addr ?>" <?= is_array($getRU) || isset($view) ? "disabled"  : "" ?> id="regis_addr" required>
            </div>
            <div class="form-group col-4">
              <label for="role">ระยะเวลาสัญญา <span class="text-danger"> *</span></label>
              <select name="inputValue1[]" id="regis_period" class="form-control form-select" disabled>
                <option value="0">ไม่ระบุ</option>
                <?php if (!is_array($getRU)) : ?>
                  <option value="1" <?= $getRU->regis_period == 1  ? "selected"  : "" ?>>6เดือน</option>
                  <option value="2" <?= $getRU->regis_period == 2  ? "selected"  : "" ?>>1ปี</option>
                <?php else : ?>
                  <option value="1">6เดือน</option>
                  <option value="2">1ปี</option>
                <?php endif ?>
              </select>
            </div>
            <div class="form-group col-4">
              <label for="u_phone">เงินประกันห้อง<span class="text-danger"> *</span></label>
              <input name="inputValue1[]" type="text" class="form-control form-control-line" value="<?= is_array($getRU) ? ""  : $getRU->regis_insurance ?>" <?= is_array($getRU) || isset($view) ? "disabled"  : "" ?> id="regis_insurance" required>
            </div>
            <div class="form-group col-4">
              <label for="u_phone">ค่าเช่าห้อง<span class="text-danger"> *</span></label>
              <input name="inputValue1[]" type="text" class="form-control form-control-line" value="<?= is_array($getRU) ? ""  : $getRU->regis_room_cost ?>" <?= is_array($getRU) || isset($view) ? "disabled"  : "" ?> id="regis_room_cost" required>
            </div>
            <div class="form-group col-4">
              <label for="lname_th">วันที่เริ่มทำสัญญา <span class="text-danger"> *</span></label>
              <input name="inputValue1[]" type="date" class="form-control form-control-line" value="<?= is_array($getRU) ? ""  : $getRU->regis_start_date ?>" id="regis_start_date" <?= is_array($getRU) || isset($view) ? "disabled"  : "" ?> required>
            </div>
            <?php if (!is_array($getRU) && $getRU->regis_doc != NULL) : ?>
              <div class="form-group col-4">
                <label for="lname_th">เอกสารประกอบสัญญา </label>
                <a  class="btn btn-primary" title="เอกสารสัญญา" target="_blank" href="<?= base_url() ?>assets\docs\regis\<?= $getRU->regis_doc ?>"><i class="mdi mdi-file-pdf"></i> </a>
                </div>
            <?php endif ?>
          </div>
        </div>

      </form>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      var formData = {};
      var regisData = {};
      // ฟังก์ชันที่ใช้เมื่อมีการเปลี่ยนแปลงใน #role
      var myButton = document.getElementById("regis_doc_tem");

      // เช็คว่าปุ่ม disabled หรือไม่
      if (myButton.disabled) {
        $('#save').hide()
      }
      $('#u_id').change(function() {
        var u_id = $('#u_id').val();
        if (u_id == 0) {
          $('#print').prop('disabled', true);
        } else {
          $('#save').prop('disabled', false);
        }
        $.ajax({
          method: "POST",
          url: 'document/changeUser',
          data: {
            u_id: $('#u_id').val()
          }
        }).done(function(returnData) {
          if (Object.keys(returnData['regisInfo']).length !== 0) {
            console.log(returnData);
            document.getElementById("a_name").value = returnData['regisInfo']['a_name'];
            document.getElementById("regis_a_id").value = returnData['regisInfo']['regis_a_id'];
            document.getElementById("a_adds").value = returnData['regisInfo']['a_adds'];
            document.getElementById("r_name").value = returnData['regisInfo']['r_name'];
            document.getElementById("regis_room_cost").value = returnData['regisInfo']['regis_room_cost'];
            document.getElementById("regis_insurance").value = returnData['regisInfo']['regis_insurance'];
            document.getElementById("regis_addr").value = returnData['regisInfo']['regis_addr'];
            document.getElementById("regis_phone").value = returnData['regisInfo']['regis_phone'];
            document.getElementById("regis_period").value = returnData['regisInfo']['regis_period'];
            document.getElementById("regis_start_date").value = returnData['regisInfo']['regis_start_date'];
            $('#regis_phone').prop('disabled', false);
            $('#regis_insurance').prop('disabled', false);
            $('#regis_room_cost').prop('disabled', false);
            $('#regis_addr').prop('disabled', false);
          } else {
            document.getElementById("a_name").value = '';
            document.getElementById("a_adds").value = '';
            document.getElementById("r_name").value = '';
            document.getElementById("regis_a_id").value = '';
            document.getElementById("regis_room_cost").value = '';
            document.getElementById("regis_insurance").value = '';
            document.getElementById("regis_addr").value = '';
            document.getElementById("regis_phone").value = '';
            document.getElementById("regis_period").value = '';
            document.getElementById("regis_start_date").value = '';
            $('#regis_phone').prop('disabled', true);
            $('#regis_insurance').prop('disabled', true);
            $('#regis_room_cost').prop('disabled', true);
            $('#regis_period').prop('disabled', true);
            $('#regis_addr').prop('disabled', true);
          }
        });
      });
      if ($('#regis_doc_tem').val() != null && $('#regis_doc_tem').val() != 0) {
        console.log($('#regis_doc_tem').val());
        $.ajax({
          method: "POST",
          url: 'document/changeTemplate',
          data: {
            t_id: $('#regis_doc_tem').val()
          }
        }).done(function(returnData) {
          if (Object.keys(returnData['getTemplate']).length !== 0) {
            document.getElementById("t_detail").value = returnData['getTemplate']['t_detail'];
          } else {
            document.getElementById("t_detail").value = '';
          }
        });
        $('#print').prop('disabled', false);
      }
      $('#regis_doc_tem').change(function() {
        $.ajax({
          method: "POST",
          url: 'document/changeTemplate',
          data: {
            t_id: $('#regis_doc_tem').val()
          }
        }).done(function(returnData) {
          if (Object.keys(returnData['getTemplate']).length !== 0) {
            document.getElementById("t_detail").value = returnData['getTemplate']['t_detail'];
          } else {
            document.getElementById("t_detail").value = '';
          }
        });
        $('#print').prop('disabled', false);
      });
      $('#print').click(function() {
        $('[name^="inputValue"]').each(function() {
          formData[this.id] = this.value;

        });
        $('[name^="inputValue1"]').each(function() {
          formData[this.id] = this.value;
        });
        var selectedOption = document.getElementById("u_id").selectedOptions[0];
        formData['u_name'] = selectedOption.textContent;
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
        var formData2 = new FormData();
        formData2.append('show', 1);
        formData2.append('content', JSON.stringify(formData));
        // formData.append('content', textContainer);
        var path = "application/views/document/generate_pdf.php"
        // สร้างคำร้องขอไปยังไฟล์ PHP ที่สร้าง PDF
        xhr.open("POST", path, true);
        xhr.responseType = "blob"; // รับข้อมูลเป็น blob
        xhr.send(formData2);
      });
      $('#save').click(function() {
        $('[name^="inputValue1"]').each(function() {
          regisData[this.id] = this.value;
          formData[this.id] = this.value;
        });
        $('[name^="inputValue"]').each(function() {
          if (this.id == 'u_id' || this.id == 'regis_a_id' || this.id == 'regis_doc_tem') {
            regisData[this.id] = this.value;
          }
          formData[this.id] = this.value;
        });
        var startDate = new Date(regisData['regis_start_date']);
        // บวกจำนวนวัน
        if (regisData['regis_period'] == 1) {
          var date = 6;
        } else {
          var date = 12;
        }
        startDate.setMonth(startDate.getMonth() + date);
        // แปลงเป็นรูปแบบวันที่ที่ต้องการ
        regisData['regis_end_date'] = startDate.toISOString().split('T')[0];
        console.log(regisData);
        $.ajax({
          method: "POST",
          url: 'document/addContract',
          data: regisData
        }).done(function(returnData) {
          // if (returnData.status == 1) {
          //   var selectedOption = document.getElementById("u_id").selectedOptions[0];
          //   formData['u_name'] = selectedOption.textContent;
          //   var xhr = new XMLHttpRequest();
          //   xhr.onreadystatechange = function() {
          //     if (xhr.readyState === 4 && xhr.status === 200) {
          //       // เมื่อได้รับข้อมูล PDF จากเซิร์ฟเวอร์
          //       // สร้าง URL object จากข้อมูลที่ได้รับ

          //       var pdfURL = URL.createObjectURL(xhr.response);
          //       console.log(pdfURL);
          //       // เปิดหน้าต่างใหม่เพื่อแสดง PDF
          //       window.open(pdfURL);
          //     }
          //   };
          //   var formData2 = new FormData();
          //   formData2.append('show', 2);
          //   formData2.append('content', JSON.stringify(formData));
          //   // formData.append('content', textContainer);
          //   var path = "application/views/document/generate_pdf.php"
          //   // สร้างคำร้องขอไปยังไฟล์ PHP ที่สร้าง PDF
          //   xhr.open("POST", path, true);

          //   xhr.responseType = "blob"; // รับข้อมูลเป็น blob
          //   xhr.send(formData2);
          $('#mainModal').modal('hide');
          $.toast({
            heading: 'แก้ไขข้อมูลสำเร็จ',
            text: 'แก้ไขข้อมูลสำเร็จแล้ว',
            position: 'top-right',
            loaderBg: '#FF5733',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
          })
          loadlist();
          // }
        });
      });
    });
  </script>