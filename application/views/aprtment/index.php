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
                    <?php foreach ($filterApartment as $key => $value) : ?>
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
  var floor = 0;
  loadList();
  $('#newBtn').click(function(e) {
    e.preventDefault();
    $.ajax({
      method: "post",
      url: 'Manege_room/get_add'
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      // $('#r_name').prop('disabled', false); // เปิด disabled
      // $('#r_u_id').prop('disabled', false); // เปิด disabled
      // $('#r_type').prop('disabled', false); // เปิด disabled
      // $('#pay_status').prop('disabled', false); // เปิด disabled
    });
  });

  function loadList() {
    $.ajax({
      url: 'Apartment/get',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function saveFormSubmit(r_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    // formData['r_id'] = r_id;
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
    });
    $.ajax({
      method: "post",
      url: 'Apartment/edit_room',
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
        $('#mainModal').modal('hide');
        filter();
      }
    });
  }

  function saveFormUpdate(r_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['r_id'] = r_id;
    $('[name^="inputValue"]').each(function() {
      if (this.id != 'a_floor') {
        formData[this.id] = this.value;
      };
    });
    $.ajax({
      method: "post",
      url: 'Apartment/update',
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
        // $('#roomForm')[0].reset();
        $('#mainModal').modal('hide');
        filter();
      }
    });
  }



  function changeStatus(user_id, status) {
    $.ajax({
      method: "POST",
      url: 'users/updateStatus',
      data: {
        user_id: user_id,
        status: status
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
          heading: 'สำเร็จ',
          text: returnData.msg,
          position: 'top-right',
          icon: 'error',
          hideAfter: 3500,
          stack: 6
        });
      }
    })
  }

  function edit(r_id) {
    $.ajax({
      method: "post",
      url: 'Apartment/getEditForm',
      data: {
        r_id: r_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#r_name').prop('disabled', false); // เปิด disabled
      $('#r_u_id').prop('disabled', false); // เปิด disabled
      $('#r_type').prop('disabled', false); // เปิด disabled
      $('#pay_status').prop('disabled', false); // เปิด disabled
      $('#r_duedate').prop('disabled', false); // เปิด disabled
      $('#r_lateday').prop('disabled', false); // เปิด disabled
    });
  }

  function edit_slip(r_id) {
    $.ajax({
      method: "post",
      url: 'Apartment/getEdit_slip_Form',
      data: {
        r_id: r_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#r_name').prop('disabled', false); // เปิด disabled
      $('#r_u_id').prop('disabled', false); // เปิด disabled
      $('#r_type').prop('disabled', false); // เปิด disabled
      $('#pay_status').prop('disabled', false); // เปิด disabled
    });
  }

  function get(r_id) {
    $.ajax({
      method: "post",
      url: 'Apartment/getForm',
      data: {
        r_id: r_id
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
      $('#r_w_id').prop('disabled', true); // เปิด disabled
      $('#r_p_id').prop('disabled', true); // เปิด disabled
      $('#link').prop('hidden', true);
      filter();
    });
  }

  // function edit() {
  //   $.ajax({
  //     method: "post",
  //     url: 'Manege_room/get_edit',
  //     data: {
  //       floor: floor
  //     }
  //   }).done(function(returnData) {
  //     $('#mainModalTitle').html(returnData.title);
  //     $('#mainModalBody').html(returnData.body);
  //     $('#mainModalFooter').html(returnData.footer);
  //     $('#mainModal').modal();
  //     loadList();
  //     // $('#a_name').prop('disabled', false);
  //     // $('#a_adds').prop('disabled', false);
  //     // $('#a_povince_id').prop('disabled', false);
  //     // $('#a_amphure_id').prop('disabled', false);
  //     // $('#a_district_id').prop('disabled', false);
  //     // $('#a_phone').prop('disabled', false);
  //     // $('#iframe').prop('disabled', false);
  //   });
  // }
  function edit_room() {
    $.ajax({
      method: "post",
      url: 'Manege_room/get_edit',
      data: {
        floor: floor
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      filter();
      // $('#a_name').prop('disabled', false);
      // $('#a_adds').prop('disabled', false);
      // $('#a_povince_id').prop('disabled', false);
      // $('#a_amphure_id').prop('disabled', false);
      // $('#a_district_id').prop('disabled', false);
      // $('#a_phone').prop('disabled', false);
      // $('#iframe').prop('disabled', false);
    });
  }

  function filter() {
    var formData = {};
    $('[name^="inputValue"]').each(function() {
      floor = formData[this.id] = this.value;
    });
    $.ajax({
      method: "post",
      url: 'Apartment/get',
      data: formData
    }).done(function(returnData) {
      $('#listDiv').html(returnData.html);
      // $('#mainModalTitle').html(returnData.title);
      // $('#mainModalBody').html(returnData.body);
      // $('#mainModalFooter').html(returnData.footer);
      // $('#mainModal').modal();
      // $('#a_name').prop('disabled', false);
      // $('#a_adds').prop('disabled', false);
      // $('#a_povince_id').prop('disabled', false);
      // $('#a_amphure_id').prop('disabled', false);
      // $('#a_district_id').prop('disabled', false);
      // $('#a_phone').prop('disabled', false);
      // $('#iframe').prop('disabled', false);
    });
  }

  function add() {
    $.ajax({
      method: "post",
      url: 'Manege_room/get_add',
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      filter();
      // $('#a_name').prop('disabled', false);
      // $('#a_adds').prop('disabled', false);
      // $('#a_povince_id').prop('disabled', false);
      // $('#a_amphure_id').prop('disabled', false);
      // $('#a_district_id').prop('disabled', false);
      // $('#a_phone').prop('disabled', false);
      // $('#iframe').prop('disabled', false);
    });
  }

  function changePass(user_id) {
    $.ajax({
      method: "post",
      url: 'users/getChangePassForm',
      data: {
        user_id: user_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
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