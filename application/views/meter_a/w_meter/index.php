<link href="<?= base_url() ?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
        <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
        <div class="row">
          <?php if ($_SESSION['user_role'] == 3) { ?>
            <div class="col-4">
              <label for="p_category">เลือก Apartment </label>
              <div class="input-group">
                <select class="form-control select2" id="a_id" onchange="filter()" name="inputValue[]">
                  <option selected disabled value="all">-- กรุณาเลือกหอพัก --</option>
                  <?php if ($filterApartment) { ?>
                    <?php foreach ($filterApartment as $value) : ?>
                      <?php if (intval($value->a_id) == $_SESSION['user_a_id']) : ?>
                        <?php echo '<option selected value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                      <?php else : ?>
                        <?php echo '<option value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                      <?php endif ?>
                    <?php endforeach ?>
                  <?php  } ?>
                </select>
              </div>
            </div>
          <?php  } ?>
          <div class="col-4">
            <label for="p_category">สถานะ</label>
            <div class="input-group">
              <select class="form-control select2" id="status" name="inputValue[]" onchange=filter()>
                <option value="all">--ทั้งหมด--</option>
                <option value="1">กำลังใช้งาน</option>
                <option value="0">ไม่ได้ใช้งาน</option>
              </select>
            </div>
          </div>
          <div class="col-4">
            <label for="p_category">ชั้น </label>
            <div class="input-group">
              <select class="form-control select2" id="a_floor" name="inputValue[]" onchange=filter()>
                <option value=0>--ทั้งหมด--</option>
                <?php if (is_array($floor)) : ?>
                  <?php foreach ($floor as $key => $value) : ?>
                    <?php for ($i = 1; $i <= $value->a_floor; $i++) : ?>
                      <option value=<?= $i; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="listDiv"></div>

<script>
  loadList();
  $('#newBtn').click(function(e) {
    e.preventDefault();
    $.ajax({
      method: "post",
      url: 'getAddForm_water'
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#w_name').prop('disabled', false); // เปิด disabled
      $('#emb_id').prop('disabled', false); // เปิด disabled
      $('#addr').prop('disabled', false); // เปิด disabled
      $('#r_id').prop('disabled', false); // เปิด
    });
  });

  function loadList() {
    $.ajax({
      url: 'get_water',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function saveFormSubmit() {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['w_vbatt'] = 0;
    $('[name^="inputValue"]').each(function() {
      if (this.id != 'status') {
        if (this.id != 'a_floor' && this.id != 'r_id') {
          if (this.id == 'a_id') {
            formData['w_a_id'] = this.value;
          } else {
            formData[this.id] = this.value;
          }
        }
        if (this.id == 'r_id') {
          r_id = this.value
        }
      }
    });
    console.log(formData);
    if (!formData.w_name ) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.w_name ? $('#w_name').get(0).focus() : '';
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
    // console.log('good');
    $.ajax({
      method: "post",
      url: 'add_water',
      data: {
        formData: formData,
        r_id: r_id
      },
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
        $('#fMsg').addClass('text-success');
        $('#fMsg').text(returnData.msg);
        $('#roomForm')[0].reset();
        $('#mainModal').modal('hide');
        loadList();
      }
    });
  }

  function filter() {
    var formData = {};
    $('[name^="inputValue"]').each(function() {
      if (this.id == 'a_floor') {
        floor = formData[this.id] = this.value;
      } else {
        formData[this.id] = this.value;
      }
    });
    $.ajax({
      method: "post",
      url: 'get_water',
      data: formData
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    });
  }

  function edit(w_id) {
    $.ajax({
      method: "post",
      url: 'getEditForm_water',
      data: {
        w_id: w_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#w_name').prop('disabled', false); // เปิด disabled
      $('#emb_id').prop('disabled', false); // เปิด disabled
      $('#addr').prop('disabled', false); // เปิด disabled
      $('#r_id').prop('disabled', false); // เปิด disabled
    });
  }

  function changeStatus(w_id, w_status) {
    $.ajax({
      method: "POST",
      url: 'updateStatus_water',
      data: {
        w_id: w_id,
        w_status: w_status
      }
    }).done(function(returnData) {
      if (returnData.status == 1) {
        loadList();
        $.toast({
          heading: 'สำเร็จ',
          text: returnData.msg,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          stack: 6
        });
      } else {
        $.toast({
          heading: 'ล้มเหลว',
          text: returnData.msg,
          position: 'top-right',
          icon: 'error',
          hideAfter: 3500,
          stack: 6
        });
      }
    })
  }

  function get(w_id) {
    $.ajax({
      method: "post",
      url: 'getForm_water',
      data: {
        w_id: w_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#r_name').prop('disabled', true); // เปิด disabled
      $('#user').prop('disabled', true); // เปิด disabled
      $('#type').prop('disabled', true); // เปิด disabled
      $('#pay').prop('disabled', true); // เปิด disabled
    });
  }

  function saveFormEditSubmit(w_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['w_id'] = w_id;
    $('[name^="inputValue"]').each(function() {
      if (this.id != 'status') {
        if (this.id != 'a_floor' && this.id != 'r_id') {
          if (this.id == 'a_id') {
            formData['w_a_id'] = this.value;
          } else {
            formData[this.id] = this.value;
          }
        }
        if (this.id == 'r_id') {
          r_id = this.value
        }
      }
    });
    if (!formData.w_name) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.w_name ? $('#w_name').get(0).focus() : '';
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
      url: 'edit_water',
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
        $('#fMsg').addClass('text-success');
        $('#fMsg').text(returnData.msg);
        $('#roomForm')[0].reset();
        $('#mainModal').modal('hide');
        loadList();
      }
    });
  }

  function changePassSubmit(user_id) {
    var pass = $('#password').val();
    var cfPass = $('#confirm_password').val();
    if (pass != cfPass || pass == '' || cfPass == '') {
      $('#fMsg').html('<small class="text-danger">การยืนยันรหัสผ่านไม่ถูกต้อง</small>');
      return false;
    } else {
      $('#fMsg').html('<small class="text-Info">รอสักครู่ ระบบกำลังดำเนินการ ...</small>');
      $.ajax({
        url: 'users/changePass',
        method: 'POST',
        data: {
          newPass: pass,
          user_id: user_id
        }
      }).done(function(returnData) {
        if (returnData.status == 1) {
          $.toast({
            heading: 'สำเร็จ',
            text: returnData.msg,
            position: 'top-right',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
          });
          $('#fMsg').addClass('text-success');
          $('#fMsg').text(returnData.msg);
          $('#changePassForm')[0].reset();
          $('#mainModal').modal('hide');
        }
      });
    }
  }
</script>