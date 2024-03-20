<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="roomForm" autocomplete="off">
        <div class="card-body">
          <h6 class="card-subtitle">กรุณากรอกข้อมูลให้ครบถ้วน</h5>
            <div class="form-group" id="room">
              <label for="id_room">ห้องพัก <span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]" value="<?= isset($getData) ? $getData->r_name : '' ?>" id="r_name" disabled required>
            </div>
            <div class="form-group" id="room">
              <?php if ($getData_bill->bill_slip_file) : ?>
                <input hidden type="number" id="bill_id" name="inputValue[]" value = "<?= $getData_bill->bill_id?>">p
                <img src="assets/slips/<?php echo $getData_bill->bill_slip_file; ?>" alt="รายละเอียดเพิ่มเติมเกี่ยวกับรูปภาพ">
              <?php endif ?>
            </div>
            <div class="form-group">
              <label for="role">สถานะการชำระเงิน<span class="text-danger"> *</span></label>
              <select class="form-control" id="pay_status" name="inputValue[]" disabled>
                <?php foreach (P_STATUS as $key => $value) : ?>
                  <option value="<?= $key ?>" <?= isset($getData) && $getData->pay_status == $key ? 'selected' : '' ?>>
                    <?= $value ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>