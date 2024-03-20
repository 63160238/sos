<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="roomForm" autocomplete="off">
        <div class="card-body">
          <h6 class="card-subtitle">กรุณากรอกข้อมูลให้ครบถ้วน</h5>
            <div class="form-group" id="meter">
              <label for="meter">ชื่อมิเตอร์<span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]"
                value="<?= isset($getData) ? $getData->w_name : '' ?>" id="w_name" disabled required>
            </div>
            <div class="form-group">
              <label for="role">addr<span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]"
                value="<?= isset($getData) ? $getData->addr : '' ?>" id="addr" disabled required>
            </div>
            <div class="form-group">
              <label for="role">emb_id<span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]"
                value="<?= isset($getData) ? $getData->emb_id : '' ?>" id="emb_id" disabled required>
            </div>
            <div class="form-group" id="c_a">
              <label for="user_a_id">ห้องพัก<span class="text-danger"> *</span></label>
              <select class="form-control" id="r_id" name="inputValue[]" disabled required>
                <?php if (isset($apartment_room)): ?>
                  <option value="">ไม่มีหอพัก</option>
                <?php endif; ?>
                <?php foreach ($apartment_room as $key => $value): ?>
                  <option value="<?= $value->r_id ?>" <?= isset($getData->w_id) && $getData->w_id == $value->r_p_id ? 'selected' : '' ?>>
                    <?= $value->r_name ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    // ฟังก์ชันที่ใช้เมื่อมีการเปลี่ยนแปลงใน #role
    $('#role').change(function () {
      var roleValue = $(this).val();
      if (roleValue != '3') {
        $('#c_a').show();
      } else {
        // เมื่อ role เป็น '3' ให้ซ่อน #c_a และตั้งค่า value ของ #apartment เป็น 0
        $('#c_a').hide();
        $('#user_a_id').val(0);
      }
    });
    // เมื่อหน้าเว็บโหลด, ตรวจสอบค่าเริ่มต้นของ #role และทำการปรับแต่งตามเงื่อนไข
    if ($('#role').val() == '3') {
      $('#c_a').hide();
      $('#user_a_id').val(0);
    }
  });
</script>