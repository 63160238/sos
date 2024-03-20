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
                <select class="form-control select2" id="a_id" onchange="filter_apartment()" name="action">
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
    location.replace(hostname + 'Users_register');
    // $.ajax({
    //   method : "post",
    //   url : 'users/getAddForm'
    // }).done(function(returnData){
    //   $('#mainModalTitle').html(returnData.title);
    //   $('#mainModalBody').html(returnData.body);
    //   $('#mainModalFooter').html(returnData.footer);
    //   $('#mainModal').modal();
    // });
  });

  function loadList() {
    $.ajax({
      url: appRoot + 'Users_register/get',
      method: 'post',
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function filter_apartment() {
    $.ajax({
      url: appRoot + 'Users_register/get',
      method: 'post',
      data: {
        a_id: $('#a_id').val()
      }
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function saveFormSubmit(user_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['user_id'] = user_id;
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
    });
    if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.username ? $('#username').get(0).focus() : '';
      !formData.role ? $('#role').get(0).focus() : '';
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
      url: 'users/add',
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
      url: 'updateStatus',
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
      url: 'getEditForm',
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

  function view(user_id) {
    $.ajax({
      method: "post",
      url: 'getViewForm',
      data: {
        user_id: user_id
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      $('#id_card').prop('disabled', true);
      $('#prename').prop('disabled', true);
      $('#fname_th').prop('disabled', true);
      $('#lname_th').prop('disabled', true);
      $('#username').prop('disabled', true);
    });
  }

  function update(user_id) {
    var formData = {};
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
    });
    formData['user_id'] = user_id;
    if (!formData.fname_th || !formData.lname_th || !formData.prename || !formData.id_card || !formData.username) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.fname_th ? $('#fnameMsg').text('กรุณากรอกชื่อ') : '';
      !formData.lname_th ? $('#lnameMsg').text('กรุณากรอกนามสกุล') : '';
      !formData.prename ? $('#prenameMsg').text('กรุณากรอกคำนำหน้าชื่อ') : '';
      !formData.id_card ? $('#idcardMsg').text('กรุณากรอกหมายเลขบัตรประจำตัวประชาชน') : '';
      !formData.username ? $('#addrMsg').text('กรุณากรอกชื่อผู้ใช้') : '';
      // !formData2.regis_doc ? $('#regis_doc').get(0).focus() : '';
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
      url: 'update',
      data: formData
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
        $('#mainModal').modal('hide');
      }
    });
  }

  function changePass(user_id) {
    $.ajax({
      method: "post",
      url: 'getChangePassForm',
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
        url: 'changePass',
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