<link href="<?= base_url() ?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
        <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
        <div class="row">
          <div class="col-4">
            <label for="p_category">เลือก Apartment </label>
            <div class="input-group">
              <select class="form-control select2" id="a_id" onchange="filter_apartment()" name="action">
                <option disabled value="all">-- กรุณาเลือกหอพัก --</option>
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
      url: 'Manege_Apartment/getAddForm'
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#a_name').prop('disabled', false);
      $('#a_adds').prop('disabled', false);
      $('#a_povince_id').prop('disabled', false);
      $('#a_amphure_id').prop('disabled', false);
      $('#a_district_id').prop('disabled', false);
      $('#a_phone').prop('disabled', false);
      $('#iframe').prop('disabled', false);
      $('#a_room').prop('disabled', false);
      $('#a_floor').prop('disabled', false);
    });
  });

  function loadList() {
    $.ajax({
      url: 'Manege_room/get',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function filter_apartment() {
    $.ajax({
      url: appRoot + 'Manege_room/get',
      method: 'post',
      data: {
        a_id: $('#a_id').val()
      }
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }
  function saveFormSubmit() {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['a_status'] = 1;
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
    });
    console.log(formData);
    // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
    //   $('#fMsg').addClass('text-danger');
    //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
    //   !formData.username ? $('#username').get(0).focus() : '';
    //   !formData.role ? $('#role').get(0).focus() : '';
    //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
    //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
    //   !formData.prename ? $('#prename').get(0).focus() : '';
    //   !formData.id_card ? $('#id_card').get(0).focus() : '';

    //   $.toast({
    //     heading: 'พบข้อผิดพลาด',
    //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
    //     position: 'top-right',
    //     loaderBg: '#FF5733',
    //     icon: 'error',
    //     hideAfter: 3500,
    //     stack: 6
    //   })
    //   return false;
    // }
    // console.log('good');
    $.ajax({
      method: "post",
      url: 'Manege_Apartment/add',
      data: formData
    }).done(function(returnData) {
      $.ajax({
        method: "post",
        url: 'Manege_Apartment/add_room',
        data: returnData
      }).done(function(returnData) {
        console.log(returnData);
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
    });
  }

  function saveEditFormSubmit(a_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['a_id'] = a_id;
    formData['a_status'] = 1;
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
    });
    console.log(formData);
    // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
    //   $('#fMsg').addClass('text-danger');
    //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
    //   !formData.username ? $('#username').get(0).focus() : '';
    //   !formData.role ? $('#role').get(0).focus() : '';
    //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
    //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
    //   !formData.prename ? $('#prename').get(0).focus() : '';
    //   !formData.id_card ? $('#id_card').get(0).focus() : '';

    //   $.toast({
    //     heading: 'พบข้อผิดพลาด',
    //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
    //     position: 'top-right',
    //     loaderBg: '#FF5733',
    //     icon: 'error',
    //     hideAfter: 3500,
    //     stack: 6
    //   })
    //   return false;
    // }
    // console.log('good');
    $.ajax({
      method: "post",
      url: 'Manege_Apartment/edit',
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

  function changeStatus(a_id, status) {
    $.ajax({
      method: "POST",
      url: 'Manege_Apartment/updateStatus',
      data: {
        a_id: a_id,
        a_status: status
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

  function edit() {
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
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
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
      // $('#a_name').prop('disabled', false);
      // $('#a_adds').prop('disabled', false);
      // $('#a_povince_id').prop('disabled', false);
      // $('#a_amphure_id').prop('disabled', false);
      // $('#a_district_id').prop('disabled', false);
      // $('#a_phone').prop('disabled', false);
      // $('#iframe').prop('disabled', false);
    });
  }

  function seting(a_id) {
    $.ajax({
      method: "post",
      url: 'Manege_Apartment/getSetForm',
      data: {
        a_id: a_id
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

  function get(a_id) {
    $.ajax({
      method: "post",
      url: 'Manege_Apartment/getEditForm',
      data: {
        a_id: a_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#a_name').prop('disabled', true);
      $('#a_adds').prop('disabled', true);
      $('#a_povince_id').prop('disabled', true);
      $('#a_amphure_id').prop('disabled', true);
      $('#a_district_id').prop('disabled', true);
      $('#a_phone').prop('disabled', true);
      $('#iframe').prop('disabled', true);
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