<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="changePassForm" autocomplete="off">
        <div class="card-body">
          <h6 class="card-subtitle">กรุณาระบุรหัสผ่านใหม่</h5>
            <div class="form-group">
              <label for="password">รหัสผ่าน <span class="text-danger"> *</span></label>
              <div class="input-group">
                <input type="password" class="form-control form-control-line" name="inputValue[]" value="" id="password" required >
                <div class="input-group-append">
                    <span class="input-group-text"><a href="#" id="showPass"><i class="fas fa-key"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="password">ยืนยันรหัสผ่าน  <span class="text-danger"> *</span> </label>
              <div class="input-group">
                <input type="password" class="form-control form-control-line " name="inputValue[]" value="" id="confirm_password" required >
                <div class="input-group-append">
                    <span class="input-group-text"><a href="#" id="showConfirmPass" ><i class="fas fa-key"></i></a></span>
                </div>
              </div>
              <small id="errMsg">&nbsp;</small>
            </div>
            <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                <input type="checkbox" class="custom-control-input" id="checkShowPass" value="check">
                <label class="custom-control-label" for="checkShowPass">แสดงรหัสผ่าน !</label>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#confirm_password').on('blur', function(e){
    if(this.value != $('#password').val()){
      $('#errMsg').html('<span class="text-danger">ยืนยันรหัสผ่าน ไม่ถูกต้อง</span>');
    }else{
      $('#errMsg').html('<span class="text-success">ยืนยันรหัสผ่าน ถูกต้อง</span>');
    }
  });
  $('#showPass, #showConfirmPass').click(function(e){
    $('#password').attr('type') == 'password' ? $('#password, #confirm_password').attr('type', 'text') : $('#password, #confirm_password').attr('type', 'password');
  });
  $('#checkShowPass').click(function(){
    $(this).is(':checked') ? $('#password, #confirm_password').attr('type', 'text') : $('#password, #confirm_password').attr('type', 'password');
  });
</script>
