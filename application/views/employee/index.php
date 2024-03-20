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
              <select class="form-control select2" id="a_id" onchange="filter()" name="inputValue[]">
                <option selected  value="all">-- ทั้งหมด --</option>
                <?php if ($filterApartment) { ?>
                  <?php foreach ($filterApartment as $key => $value) : ?>
                    <?php if (intval($value->a_id) == $filterAid) : ?>
                      <?php echo '<option selected value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                    <?php else : ?>
                      <?php echo '<option value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                    <?php endif ?>
                  <?php endforeach ?>
                <?php  } ?>
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
      url: 'Employee/getAddForm'
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  });

  function loadList() {
    $.ajax({
      url: 'Employee/get',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }
  function filter() {
    $.ajax({
      url: 'Employee/get',
      method: 'post',
      data: {a_id:$('#a_id').val()}
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function saveFormSubmit(user_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var selectedValues = [];
    // เลือก elements ที่มี id เป็น 'user_a_id' และเป็นตัวเลือกที่ถูกเลือก
    $('#user_a_id option:selected').each(function() {
      // เพิ่มค่า value ของตัวเลือกที่ถูกเลือกเข้าไปในอาร์เรย์
      selectedValues.push($(this).val());
    });
    var selectedString = selectedValues.join(',');
    var formData = {};
    formData['user_id'] = user_id;
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
      formData["user_a_id"] = selectedString;
    });
    console.log(formData);
    if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username || !formData.user_a_id) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.username ? $('#username').get(0).focus() : '';
      !formData.role ? $('#role').get(0).focus() : '';
      !formData.user_a_id ? $('#user_a_id').get(0).focus() : '';
      !formData.lname_th ? $('#lname_th').get(0).focus() : '';
      !formData.fname_th ? $('#fname_th').get(0).focus() : '';
      !formData.prename ? $('#prename').get(0).focus() : '';
      !formData.id_card ? $('#id_card').get(0).focus() : '';

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
      url: 'Employee/add',
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
        $('#usersForm')[0].reset();
        $('#mainModal').modal('hide');
        loadList();
      }
    });
  }

  function changeStatus(user_id, status) {
    $.ajax({
      method: "POST",
      url: 'Employee/updateStatus',
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

  function edit(user_id) {
    $.ajax({
      method: "post",
      url: 'Employee/getEditForm',
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

  function changePass(user_id) {
    $.ajax({
      method: "post",
      url: appRoot + 'Employee/getChangePassForm',
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
        url: appRoot + 'users/changePass',
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