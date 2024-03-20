<link href="<?=base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
        <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
        <div class="row">
          <div class="col-4">
            <label for="">ช่วงวันที่ </label>
            <div class='input-group'>
              <input type='text' class="form-control shawCalRanges" />
              <div class="input-group-append">
                  <span class="input-group-text">
                      <span class="ti-calendar"></span>
                  </span>
              </div>
            </div>
          </div>
          <div class="col-4">
            <label for="p_category">Action </label>
            <div class="input-group">
              <select class="form-control select2" id="action" name="action" >
                <option value="all">--ทั้งหมด--</option>
                <option value="add">add </option>
                <option value="update">update </option>
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
  $('#newBtn').click(function(e){
    e.preventDefault();
    $.ajax({
      method : "post",
      url : 'users/getAddForm'
    }).done(function(returnData){
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  });

  function loadList(){
    $.ajax({
      url: 'users/get',
      method : 'post'
    }).done(function(returnedData){
      $('#listDiv').html(returnedData.html);
    })
  }

  function saveFormSubmit(user_id){
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['user_id'] = user_id;
    $('[name^="inputValue"]').each(function() {
      formData[this.id] = this.value;
    });
    console.log(formData);
    if(!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username ){
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
    }).done(function(returnData){
      // console.log(returnData);
      if(returnData.status == 1){
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

  function changeStatus(user_id, status){
    $.ajax({
      method : "POST",
      url : 'users/updateStatus',
      data: {user_id:user_id, status:status}
    }).done(function(returnData){
      if(returnData.status == 1){
        loadList();
        $.toast({
					heading: 'สำเร็จ',
					text: returnData.msg,
					position: 'top-right',
					icon: 'success',
					hideAfter: 3500,
					stack: 6
				});
      }else {
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

  function edit(user_id){
    $.ajax({
      method : "post",
      url : 'users/getEditForm',
      data : {user_id:user_id}
    }).done(function(returnData){
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  }

  function changePass(user_id){
    $.ajax({
      method : "post",
      url : appRoot+'users/getChangePassForm',
      data : {user_id:user_id}
    }).done(function(returnData){
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  }

  function changePassSubmit(user_id){
    var pass = $('#password').val();
    var cfPass = $('#confirm_password').val();
    if(pass != cfPass || pass == '' || cfPass == ''){
      $('#fMsg').html('<small class="text-danger">การยืนยันรหัสผ่านไม่ถูกต้อง</small>');
      return false;
    }else {
      $('#fMsg').html('<small class="text-Info">รอสักครู่ ระบบกำลังดำเนินการ ...</small>');
      $.ajax({
        url : 'users/changePass',
        method : 'POST',
        data : {newPass:pass, user_id:user_id}
      }).done(function(returnData){
        if(returnData.status == 1){
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
