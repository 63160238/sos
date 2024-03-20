<!-- <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">เพิ่มสมาชิกใหม่</h4>
      </div>
    </div>
  </div>
</div> -->
<style>
  .select2-dropdown {
    z-index: 1061;
  }
</style>
<div id="listDiv"></div>
<script>
  // loadList();
  var room = [];
  showAddForm();
  $('#newBtn').click(function(e) {
    e.preventDefault();
    location.replace(hostname + 'Apartment');
  });

  // function loadList() {
  //   $.ajax({
  //     url: 'Users_register/get_Register',
  //     method: 'post'
  //   }).done(function(returnedData) {
  //     $('#listDiv').html(returnedData.html);
  //   })
  // }

  function showAddForm() {
    $.ajax({
      url: appRoot + 'Users_register/get_Register',
      method: 'post'
    }).done(function(returnData) {
      let html = '<div class="card"><h2 class="card-title m-3">' + '</h2>' + returnData.body + '<div class="text-end mb-4 mx-2">' + '</div></div>'
      $('#listDiv').html(html)
    })
  }
 
  function getRoom(user_id) {
    $.ajax({
      url: appRoot + 'Users_register/getEmptyRoom',
      method: 'post'
    }).done(function(returnData) {
      room = returnData.getData;
      saveFormSubmit(user_id)
    })
  }
  function saveFormSubmit(user_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var selectHTML = `
                <select id="mySelect" style="width: 100%; z-index: X;">
            `;
    var length = Object.keys(room).length;
    if (length > 0) {
      selectHTML += `<option value="" selected disabled>เลือกห้องพัก</option>`;
      Object.keys(room).forEach(function(key) {
        Object.keys(room[key]).forEach(function(innerKey) {
          if (innerKey == 'floor') {
            selectHTML += `<optgroup label="ชั้นที่ ${room[key][innerKey]}">`;
          }
          if (innerKey == 'room') {
            Object.keys(room[key][innerKey]).forEach(function(roomIndex) {
              Object.keys(room[key][innerKey][roomIndex]).forEach(function(roomData) {
                if (roomData == 'room_id') {
                  selectHTML += `<option value="${room[key][innerKey][roomIndex][roomData]}">`;
                }
                if (roomData == 'room_name') {
                  selectHTML += `${room[key][innerKey][roomIndex][roomData]}</option>`;
                }
              })
            })
          }
        })
        selectHTML += `/<optgroup>`;
      })
    } else {
      selectHTML += `<option value="" selected disabled>ห้องพักเต็มแล้ว</option>`;
    }
    selectHTML += `</select>`
    var formData = {};
    var formData2 = {};
    var roomData = {};
    var formData3 = new FormData();
    formData['user_id'] = user_id;
    $('[name^="inputValue1"]').each(function() {
      formData[this.id] = this.value;
    });
    $('[name^="inputValue2"]').each(function() {
      if ($(this).attr('type') === 'file') {
        files = $(this)[0].files;
        if (files.length > 0) {
          dotIndex = files[0]['name'].split(".");
          type = dotIndex[1];
          formData2['typefile'] = type;
          formData3.append('regis_doc', files[0]);
        }
      } else {
        // สำหรับฟิลด์อื่น ๆ (ไม่ใช่ input file)
        formData2[this.id] = this.value;
      }
    });
    // formData2['regis_doc'] = document.getElementById('regis_doc');
    if (!formData.fname_th || !formData.lname_th || !formData.prename || !formData2.regis_addr || !formData.id_card || !formData2.regis_phone || !formData2.regis_start_date || formData2.regis_period == 0 || !formData2.regis_insurance || !formData2.regis_room_cost) {
      $('#fMsg').addClass('text-danger');
      $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
      !formData.fname_th ? $('#fnameMsg').text('กรุณากรอกชื่อ') : '';
      !formData.lname_th ? $('#lnameMsg').text('กรุณากรอกนามสกุล') : '';
      !formData.prename ? $('#prenameMsg').text('กรุณากรอกคำนำหน้าชื่อ') : '';
      !formData.id_card ? $('#idcardMsg').text('กรุณากรอกหมายเลขบัตรประจำตัวประชาชน') : '';
      !formData2.regis_addr ? $('#addrMsg').text('กรุณากรอกที่อยู่ของผู้เข้าพัก') : '';
      !formData2.regis_phone ? $('#phoneMsg').text('กรุณากรอกเบอร์โทรศัพท์') : '';
      !formData2.regis_date ? $('#dateMsg').text('กรุณาระบุวันที่ทำสัญญา') : '';
      !formData2.regis_period ? $('#periodMsg').text('กรุณาระบุระยะเวลาสัญญา') : '';
      !formData2.regis_insurance ? $('#insuranceMsg').text('กรุณากรอกเงินประกัน') : '';
      !formData2.regis_room_cost ? $('#rcostMsg').text('กรุณากรอกค่าห้อง') : '';
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
    } else {
      if (validateThaiIDCard(formData.id_card) == false || validatePhoneNumber(formData2.regis_phone) == false) {
        if (validateThaiIDCard(formData.id_card) == false) {
          $('#idcardMsg').text('กรุณากรอกหมายเลขบัตรประจำตัวประชาชนให้ถูกต้อง')
        }
        if (validatePhoneNumber(formData2.regis_phone) == false) {
          $('#phoneMsg').text('กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง')
        }
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
      } else {
        $('#idcardMsg').text('')
        $('#phoneMsg').text('')
      }
      formData.username = formData.id_card;
      formData.password = formData2.regis_phone;
    }
    $.ajax({
      method: "post",
      url: appRoot + 'Users_register/add',
      data: formData,
    }).done(function(returnData) {
      // console.log(returnData);
      if (returnData.status == 1) {
        formData2['regis_u_id'] = returnData.nu_id;
        var startDate = new Date(formData2['regis_start_date']);
        // บวกจำนวนวัน
        if (formData2['regis_period'] == 1) {
          var date = 6;
        } else {
          var date = 12;
        }
        startDate.setMonth(startDate.getMonth() + date);
        // แปลงเป็นรูปแบบวันที่ที่ต้องการ
        formData2['regis_end_date'] = startDate.toISOString().split('T')[0];
        roomData['nu_id'] = returnData.nu_id;
        formData3.append('regis_u_id', returnData.nu_id);
        // var entries = Array.from(formData3.entries());
        $.ajax({
          method: "post",
          url: appRoot + 'Users_register/add_Register',
          data: formData2,
        }).done(function(returnData) {
          if (formData3.has('regis_doc')) {
            $.ajax({
              method: "post",
              url: 'uploadFile',
              data: formData3,
              processData: false,
              contentType: false,
            })
          }
          $.toast({
            heading: 'สำเร็จ',
            text: returnData.msg,
            position: 'top-right',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
          });
          Swal.fire({
            title: 'คุณต้องการที่จะเลือกห้องพักให้กับผู้เช่าเลยหรือไม่ ?',
            text: 'คุณต้องการที่จะเลือกห้องพักให้กับผู้เช่าเลยหรือไม่?',
            type: "warning",
            focusConfirm: false,
            html: selectHTML,
            allowOutsideClick: false,
            onOpen: function() {
              $('#mySelect').select2();
            },
            preConfirm: () => {
              var selectedValue = $('#mySelect').val();
              if (!selectedValue) {
                $.toast({
                  heading: 'พบข้อผิดพลาด',
                  text: 'กรุณาเลือกห้องพัก',
                  position: 'top-right',
                  loaderBg: '#FF5733',
                  icon: 'error',
                  hideAfter: 3500,
                  stack: 6
                })
                return false;
              }
            },
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonColor: "#E4E4E4",
            cancelButtonText: "<font style='color:black'>" + 'ภายหลัง' + "</font>",
          }).then((result) => {
            if (result.value) {
              roomData['r_id'] = $('#mySelect').val();
              $.ajax({
                method: "post",
                url: appRoot+'Users_register/updateRoom',
                data: roomData,
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
                } else {
                  $.toast({
                    heading: 'ไม่สำเร็จ',
                    text: returnData.msg,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                  });
                }
                location.reload();
              });
            } else {
              location.reload();
            }
          });
        });
      } else {}
    });

    // console.log('good');
  }

  function validateThaiIDCard(id) {
    // ตรวจสอบความยาวของหมายเลขบัตรประชาชน
    if (id.length !== 13) {
      return false;
    }
    // ตรวจสอบว่าเป็นตัวเลขทั้งหมดหรือไม่
    if (!/^\d+$/.test(id)) {
      return false;
    }
    // ตรวจสอบ checksum
    var sum = 0;
    for (var i = 0; i < 12; i++) {
      sum += parseInt(id.charAt(i)) * (13 - i);
    }
    if ((11 - sum % 11) % 10 !== parseInt(id.charAt(12))) {
      return false;
    }
    // ผ่านเงื่อนไขทั้งหมด
    return true;
  }

  function validatePhoneNumber(phoneNumber) {
    // ตรวจสอบความยาวของหมายเลขโทรศัพท์
    if (phoneNumber.length !== 10) {
      return false;
    }

    // ตรวจสอบว่าเป็นตัวเลขทั้งหมดหรือไม่
    if (!/^\d+$/.test(phoneNumber)) {
      return false;
    }

    // หมายเลขโทรศัพท์ต้องเริ่มต้นด้วย 0
    if (phoneNumber.charAt(0) !== '0') {
      return false;
    }

    // ผ่านเงื่อนไขทั้งหมด
    return true;
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
      url: 'users/getEditForm',
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