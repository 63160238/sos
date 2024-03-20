<!-- <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">เพิ่มสมาชิกใหม่</h4>
      </div>
    </div>
  </div>
</div> -->
<div id="listDiv"></div>

<script>
  loadList();
  $('#newBtn').click(function(e) {
    e.preventDefault();
    $.ajax({
      method: "post",
      url: 'Apartment/getAddForm'
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  });

  function loadList() {
    $.ajax({
      url: 'Log_month/get',
      method: 'post',
      data: {
        filterYear: $('#filterYear').val(),
      }
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function chageYear() {
    loadList();
  }

  function saveFormSubmit(r_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['r_id'] = r_id;
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
      url: 'Apartment/add',
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