<div id="listDiv"></div>

<script>
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
      $('#a_povince').prop('disabled', false);
      $('#a_amphure').prop('disabled', false);
      $('#a_district').prop('disabled', false);
      $('#zipcode').prop('disabled', false);
      $('#a_phone').prop('disabled', false);
      $('#iframe').prop('disabled', false);
      $('#a_room').prop('disabled', false);
      $('#a_floor').prop('disabled', false);
    });
  });

  function loadList() {
    $.ajax({
      url: 'Manege_Apartment/get',
      method: 'post'
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
    if (!formData.a_name || !formData.a_adds || !formData.a_phone || !formData.a_floor || !formData.a_room) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.a_name ? $('#a_name').get(0).focus() : '';
      !formData.a_adds ? $('#a_adds').get(0).focus() : '';
      !formData.a_phone ? $('#a_phone').get(0).focus() : '';
      !formData.a_floor ? $('#a_floor').get(0).focus() : '';
      !formData.a_room ? $('#a_room').get(0).focus() : '';
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
    if (/^[0]{1}[0-9]{9}$/.test(formData.a_phone)) {
        // ทำสิ่งที่ต้องการกับข้อมูลเบอร์โทรศัพท์ที่ถูกต้อง
        console.log("เบอร์โทรที่ถูกต้อง: " + formData.a_phone);
        
      } else {
        $.toast({
        heading: 'พบข้อผิดพลาด',
        text: 'กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง',
        position: 'top-right',
        loaderBg: '#FF5733',
        icon: 'error',
        hideAfter: 3500,
        stack: 6
      })
      !formData.a_phone ? $('#a_phone').get(0).focus() : '';
      return false;
        console.log("กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง");
      }
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
          $('#mainModal').modal('hide');
          loadList()
        }
      });
    });
  }

  function saveeEditFormSubmit(a_id) {
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
    if (!formData.a_name || !formData.a_adds || !formData.a_phone || !formData.a_floor || !formData.a_room) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.a_name ? $('#a_name').get(0).focus() : '';
      !formData.a_adds ? $('#a_adds').get(0).focus() : '';
      !formData.a_phone ? $('#a_phone').get(0).focus() : '';
      !formData.a_floor ? $('#a_floor').get(0).focus() : '';
      !formData.a_room ? $('#a_room').get(0).focus() : '';
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
    if (/^[0]{1}[0-9]{9}$/.test(formData.a_phone)) {
        // ทำสิ่งที่ต้องการกับข้อมูลเบอร์โทรศัพท์ที่ถูกต้อง
        console.log("เบอร์โทรที่ถูกต้อง: " + formData.a_phone);
        
      } else {
        $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง');
        $.toast({
        heading: 'พบข้อผิดพลาด',
        text: 'กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง',
        position: 'top-right',
        loaderBg: '#FF5733',
        icon: 'error',
        hideAfter: 3500,
        stack: 6
      })
      !formData.a_phone ? $('#a_phone').get(0).focus() : '';
      return false;
        console.log("กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง");
      }
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
        $('#mainModal').modal('hide');
        loadList()
      }
    });
  }
  function edit(a_id) {
      $.ajax({
        method: "post",
        url: 'Manege_Apartment/getEditForm',
        data: {
          a_id: a_id
        }
      }).done(function (returnData) {
        $('#mainModalTitle').html(returnData.title);
        $('#mainModalBody').html(returnData.body);
        $('#mainModalFooter').html(returnData.footer);
        $('#mainModal').modal();
        $('#a_name').prop('disabled', false);
        $('#a_adds').prop('disabled', false);
        $('#a_povince').prop('disabled', false);
        $('#a_amphure').prop('disabled', false);
        $('#a_district').prop('disabled', false);
        $('#zipcode').prop('disabled', false);
        $('#a_phone').prop('disabled', false);
        $('#iframe').prop('disabled', false);
        $('#a_floor').prop('disabled', false);
        $('#a_room').prop('disabled', false);
        $('#a_povince').prop('disabled', false);
        $('#a_amphure').prop('disabled', false);
        $('#a_district').prop('disabled', false);
        $('#zipcode').prop('disabled', false);

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
        console.log(returnData);
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
      $('#mainModalFooter').html('<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>');
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
          loadList()
        }
      });
    }
  }
</script>