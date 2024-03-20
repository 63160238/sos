<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="roomForm" autocomplete="off">
        <div class="card-body">
          <h6 class="card-subtitle">กรอกเลขมิเตอร์ใหม่ให้ถูกต้อง</h6>
          <div class="table-responsive">
            <table class="display table table-striped table-bordered dt-responsive nowrap">
              <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
              <thead>
                <tr>
                  <th>ห้อง</th>
                  <!-- <th>สิทธิ์</th> -->
                  <!-- <th>ประเภทห้อง</th> -->
                  <th>ราคาห้อง</th>
                  <th>เลขมิเตอร์ไฟก่อนหน้า</th>
                  <th>เลขมิเตอร์ไฟล่าสุด</th>
                  <th>เลขมิเตอร์น้ำก่อนหน้า</th>
                  <th>เลขมิเตอร์น้ำล่าสุด</th>
                  <th>คำนวนล่าสุด</th>
                </tr>
              </thead>
              <tr>
                <tbody>
                  <?php if (is_array($getData_edit)) : ?>
                      <td><?= $getData_room->r_name ?></td>
                      <td id="ac_type_cost" name="inputValue[]"><?= $getData_type->ac_type_cost ?></td>
                      <td id="bill_p_khw"><?=$getData_edit[0]->bill_p_khw ?></td>
                      <td><input type="number" id="P_meter" name="inputValue[]" class="form-control" placeholder="กรอกเลขมิเตอร์" oninput="updateSum(this)"></td>
                      </td>
                      <td id="bill_w_flow"><?= $getData_edit[0]->bill_w_flow ?></td>
                      <td><input type="number" id="w_meter" name="inputValue[]"class="form-control" placeholder="กรุณาเลขมิเตอร์" oninput="updateSum(this)"></td>
                      <td class="sum-cell"  name="inputValue[]" id="sum-cell"</td></td>
                  <?php endif; ?>
                </tbody>
              <tr>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
