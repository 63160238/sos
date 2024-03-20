<div class="col-lg-12">
  <div class="card">
    <form class="form-material ">
      <h4 class="card-title">*กรุณากรอกข้อมูลรายละเอียดในการเข้าพัก*</h4>
      <hr>
      <h4>ข้อมูลทั่วไป</h4>
      <div class="form-body">
        <div class="card-body">
          <div class="row pt-3">
            <div class="col-md-6">
              <div class="form-group has-danger">
                <label class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                <input type="text" name="inputValue[]" id="id_card" value="<?= isset($getData) ? $getData->id_card : '' ?>" class="form-control form-control-danger" placeholder="กรุณากรอกนามสกุล">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">คำนำหน้า</label>
                <input type="text" name="inputValue[]" value="<?= isset($getData) ? $getData->prename : '' ?>" name="prename" id="prename" class="form-control" placeholder="กรุณากรอกคำนำหน้า">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">ชื่อ</label>
                <input type="text" name="inputValue[]" value="<?= isset($getData) ? $getData->fname_th : '' ?>" name="fname_th" id="fname_th" class="form-control" placeholder="กรุณากรอกชื่อ">
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">นามสกุล</label>
                <input type="text" name="inputValue[]" value="<?= isset($getData) ? $getData->lname_th : '' ?>" id="lname_th" class="form-control form-control-danger" placeholder="กรุณากรอกนามสกุล">
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">ชื่อผู้ใช้ (username)</label>
                <input type="text" name="inputValue[]" id="username" value="<?= isset($getData) ? $getData->username : '' ?>" class="form-control form-control-danger" placeholder="กรุณากรอกชื่อผู้ใช้">
              </div>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>