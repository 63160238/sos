<div id="listDiv"></div>
<script>
  loadList();
  var formData = {};
  $('#newBtn').click(function (e) {
    var ppID = "000000000";
    // var amount = 20.00;
    // if (ppID == '') {
    //   $('#pp-id').addClass('is-invalid')
    // } else {
    //   $('#amount').removeClass('is-invalid')
    //   $('#pp-id').removeClass('is-invalid')
    //   makeCode();
    //   $("#pp-id").
    //   on("blur", function() {
    //     makeCode();
    //   }).
    //   on("keydown", function(e) {
    //     if (e.keyCode == 13) {
    //       makeCode();
    //     }
    //   });
    //   $("#amount").
    //   on("blur", function() {
    //     makeCode();
    //   }).
    //   on("keydown", function(e) {
    //     if (e.keyCode == 13) {
    //       makeCode();
    //     }
    //   });
    //   $("#myModal").modal();
    e.preventDefault();
    $.ajax({
      method: "post",
      url: 'Payment/getAddForm'
    }).done(function (returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  });
  // $(document).ready(function() {
  //     $("#myBtn").click(function() {
  //      
  //       }
  //     });
  //   });

  function loadList() {
    $.ajax({
      url: 'Payment/get',
      method: 'post'
    }).done(function (returnedData) {
      formData = returnedData.data;
      $('#listDiv').html(returnedData.html);
    })
  }

  function saveFormSubmit(r_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    var formData2 = new FormData();
    var files;
    $('[name^="inputValue"]').each(function () {
      files = $(this).prop("files")[0];
      console.log(files);
      formData2.append('slip', files); // เพิ่มไฟล์ลงใน FormData object
      $.ajax({
        method: "post",
        url: 'Payment/uploadFile',
        data: formData2,
        processData: false,
        contentType: false,
      }).done(function (returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal('hide');
      });
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
    }).done(function (returnData) {
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

  function edit(user_id) {
    $.ajax({
      method: "post",
      url: 'users/getEditForm',
      data: {
        user_id: user_id
      }
    }).done(function (returnData) {
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
    }).done(function (returnData) {
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
      }).done(function (returnData) {
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