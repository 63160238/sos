<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="usersForm" autocomplete="off">
        <div class="card-body">
          <h6 class="card-subtitle">กรุณากรอกข้อมูลให้ครบถ้วน</h5>
            <div class="form-group">
              <label for="id_code">เลขบัตรประจำตัวประชาชน <span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]" value="<?= isset($getData) ? $getData->id_card : '' ?>" id="id_card" required>
            </div>
            <div class="form-group">
              <label for="prename">คำนำหน้า<span class="text-danger"> *</span></label>
              <!-- <input type="text" class="form-control form-control-line" name="inputValue[]" value="<?= isset($getData) ? $getData->prename : '' ?>" id="prename" required > -->
              <select class="form-control" id="prename" name="inputValue[]" required>
                <option value="">-- กรุณาเลือก --</option>
                <?php foreach (PREFIX as $key => $value) : ?>
                  <option value="<?= $key ?>" <?= isset($getData) && $getData->prename == $key ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="fname_th">ชื่อ<span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]" value="<?= isset($getData) ? $getData->fname_th : '' ?>" id="fname_th" required>
            </div>
            <div class="form-group">
              <label for="lname_th">นามสกุล <span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]" value="<?= isset($getData) ? $getData->lname_th : '' ?>" id="lname_th" required>
            </div>
            <div class="form-group">
              <label for="role">สิทธิ์ <span class="text-danger"> *</span></label>
              <select class="form-control" id="role" name="inputValue[]">
                <?php foreach (ROLE as $key => $value) : ?>
                  <?php if ($value != 'User') : ?>
                    <option value="<?= $key ?>" <?= isset($getData) && $getData->role == $key ? 'selected' : '' ?>><?= $value ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group" id="c_a">
              <label for="user_a_id" class="form-label">หอพัก<span class="text-danger">*</span></label>
              <select class="form-select" id="user_a_id" name="inputValue[]" multiple aria-label="เลือกหอพัก">
                <?php foreach ($apartment_name as $key => $value) : ?>
                  <option value="<?= $value->a_id ?>" <?= isset($getData->user_a_id) && in_array($value->a_id, $getData->user_a_id) ? 'selected' : '' ?>>
                    <?= $value->a_name ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="username">ชื่อผู้ใช้ (username) <span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]" value="<?= isset($getData) ? $getData->username : '' ?>" id="username" required>
            </div>
            <?php if (!isset($getData)) : ?>
              <div class="form-group">
                <label for="password">รหัสผ่าน (password) <span class="text-danger"> *</span></label>
                <input type="text" class="form-control form-control-line" name="inputValue[]" value="" id="password" required>
              </div>
            <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#user_a_id').select2({
      placeholder: 'เลือกหอพัก',
      allowClear: true,
      width: '100%',
      tags: true
    });
  });
</script>
<script>
  $(document).ready(function() {
    // ฟังก์ชันที่ใช้เมื่อมีการเปลี่ยนแปลงใน #role
    $('#role').change(function() {
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