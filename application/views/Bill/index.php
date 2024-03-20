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
                        <?php echo '<option selected value=' . $value->a_id . '">' . $value->a_name . '</option>' ?>
                      <?php else : ?>
                        <?php echo '<option value=' . $value->a_id . '">' . $value->a_name . '</option>' ?>
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
  loadList();
  $('#MsgBtn').click(function(e) {
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
      url: 'bill/get',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
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
      url: 'bill/get',
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
  // function saveFormSubmit(r_id) {
  //   $('#fMsg').addClass('text-warning');
  //   $('#fMsg').text('กำลังดำเนินการ ...');
  //   var formData = {};
  //   formData['bill_r_id'] = r_id;
  //   // formData['sum-cell'] = data-sum;
  //   $('[name^="inputValue"]').each(function() {
  //     formData[this.id] = this.value;

  //     // formData['sum-cell'] = this.Class;
  //     // formData[this.id] = this.value;
  //     // formData['bill_p_khw'] = P_meterValue;
  //     // formData['bill_w_flow'] = w_meterValue;
  //     // formData['bill_cost'] = sum;
  //     // formData['bill_mg_status'] = 1;
  //   });
  //   console.log(formData);
  //   // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
  //   //   $('#fMsg').addClass('text-danger');
  //   //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
  //   //   !formData.username ? $('#username').get(0).focus() : '';
  //   //   !formData.role ? $('#role').get(0).focus() : '';
  //   //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
  //   //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
  //   //   !formData.prename ? $('#prename').get(0).focus() : '';
  //   //   !formData.id_card ? $('#id_card').get(0).focus() : '';

  //   //   $.toast({
  //   //     heading: 'พบข้อผิดพลาด',
  //   //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
  //   //     position: 'top-right',
  //   //     loaderBg: '#FF5733',
  //   //     icon: 'error',
  //   //     hideAfter: 3500,
  //   //     stack: 6
  //   //   })
  //   //   return false;
  //   // }
  //   // console.log('good');
  //   $.ajax({
  //     method: "post",
  //     url: 'Bill/add',
  //     data: formData
  //   }).done(function(returnData) {
  //     // console.log(returnData);
  //     if (returnData.status == 1) {
  //       $.toast({
  //         heading: 'สำเร็จ',
  //         text: returnData.msg,
  //         position: 'top-right',
  //         icon: 'success',
  //         hideAfter: 3500,
  //         stack: 6
  //       });
  //       $('#fMsg').addClass('text-success');
  //       $('#fMsg').text(returnData.msg);
  //       $('#roomForm')[0].reset();
  //       $('#mainModal').modal('hide');
  //       loadList();
  //     }
  //   });
  // }

  function changeStatus(r_id, status) {
    $.ajax({
      method: "POST",
      url: 'Bill/updateStatus',
      data: {
        bil_r_id: r_id,
        bill_mg_status: 1
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
        var u_id = returnData.u_id;
        console.log(u_id);
        $.ajax({
          url: appRoot + 'Payment/get',
          method: 'post',
          data:{u_id:u_id,r_id:r_id}
        }).done(function(returnedData) {
          var formData1 = returnedData.data;
          var formData2 = new FormData();
          formData2.append('data', JSON.stringify(formData1))
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
          // formData.append('content', textContainer);
          var path = "application/views/payments/generate_pdf.php"
          // สร้างคำร้องขอไปยังไฟล์ PHP ที่สร้าง PDF
          xhr.open("POST", path, true);
          xhr.responseType = "blob"; // รับข้อมูลเป็น blob
          xhr.send(formData2);
        })
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
  // function edit(r_id) {
  //   $.ajax({
  //     method: "post",
  //     url: 'Apartment/getEditForm',
  //     data: {
  //       r_id: r_id
  //     }
  //   }).done(function(returnData) {
  //     $('#mainModalTitle').html(returnData.title);
  //     $('#mainModalBody').html(returnData.body);
  //     $('#mainModalFooter').html(returnData.footer);
  //     $('#mainModal').modal();
  //     $('#r_name').prop('disabled', false); // เปิด disabled
  //     $('#r_u_id').prop('disabled', false); // เปิด disabled
  //     $('#r_type').prop('disabled', false); // เปิด disabled
  //     $('#pay_status').prop('disabled', false); // เปิด disabled
  //   });
  // }

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



  function changePass(r_id) {
    $.ajax({
      method: "post",
      url: 'users/getChangePassForm',
      data: {
        r_id: user_id
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