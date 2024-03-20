<div class="col-lg-12">
  <div class="card">
    <div class="card-header bg-info">
      <h4 class="mb-0 text-white">แบบฟร์อมการสมัครเข้าพัก</h4>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
      <div class="card-body">
        <h4 class="card-title">*กรุณากรอกข้อมูลรายละเอียดในการเข้าพัก*</h4>
      </div>
      <hr>
      <h4>ข้อมูลทั่วไป</h4>
      <div class="form-body">
        <div class="card-body">
          <div class="row pt-3">
            <div class="col-2">
              <div class="form-group">
                <label class="form-label">คำนำหน้า</label>
                <input type="text" id="prename" name="inputValue1[]" class="form-control" placeholder="กรุณากรอกชื่อ">
                <font id="prenameMsg" class="small text-danger"></font>
              </div>
            </div>
            <div class="col-5">
              <div class=" form-group">
                <label class="form-label">ชื่อ</label>
                <input type="text" id="fname_th" name="inputValue1[]" class="form-control" placeholder="กรุณากรอกชื่อ">
                <font id="fnameMsg" class="small text-danger"></font>
              </div>
            </div>
            <!--/span-->
            <div class="col-5">
              <div class="form-group ">
                <label class="form-label">นามสกุล</label>
                <input type="text" id="lname_th" name="inputValue1[]" class="form-control" placeholder="กรุณากรอกนามสกุล">
                <font id="lnameMsg" class="small text-danger"></font>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">ที่อยู่ตามทะเบียนบ้าน</label>
                <input type="text" id="regis_addr" name="inputValue2[]" class="form-control " placeholder="กรุณากรอกที่อยู่ตามทะเบียนบ้าน">
                <font id="addrMsg" class="small text-danger"></font>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                <input type="text" id="id_card" name="inputValue1[]" class="form-control " placeholder="กรุณากรอกนามสกุล">
                <font id="idcardMsg" class="small text-danger"></font>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">เบอร์โทรผู้เข้าพัก</label>
                <input type="text" id="regis_phone" name="inputValue2[]" class="form-control " placeholder="กรุณากรอกนามสกุล">
                <font id="phoneMsg" class="small text-danger"></font>
              </div>
            </div>
          </div>
          <h4> ข้อมูลประกอบการทำสัญญา</h4>
          <hr>
          <!--/row-->
          <div class="row">
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">วันที่ทำสัญญา</label>
                <input type="date" name="inputValue2[]" id="regis_start_date" class="form-control">
                <font id="dateMsg" class="small text-danger"></font>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">ระยะเวลาสัญญา</label>
                <select name="inputValue2[]" id="regis_period" class="form-control form-select">
                  <option value="0">ไม่ระบุ</option>
                  <option value="1">6เดือน</option>
                  <option value="2">1ปี</option>
                </select>
                <font id="periodMsg" class="small text-danger"></font>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">เงินค่าประกัน(บาท)</label>
                <input name="inputValue2[]" type="number" id="regis_insurance" class="form-control " placeholder="">
                <font id="insuranceMsg" class="small text-danger"></font>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">ค่าห้อง(บาท)</label>
                <input type="number" name="inputValue2[]" id="regis_room_cost" class="form-control " placeholder="">
                <font id="rcostMsg" class="small text-danger"></font>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group ">
                <label class="form-label">แนบเอกสาร</label>
                <input type="file" name="inputValue2[]" id="regis_doc1" class="form-control " placeholder="" multiple>
              </div>
            </div>
          </div>
          <!--/row-->
          <div class="text-right">
            <span id="fMsg"></span>
            <button type="button" class="btn btn-success mr-auto" onclick="getRoom('new');">ยืนยัน</button>
            <button type="button" class="btn btn-danger">ยกเลิก</button>
          </div>
        </div>
    </form>
  </div>
</div>