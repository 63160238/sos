<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>รายการห้องพัก</h4>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>มิเตอร์</th>
                <th>ห้องพัก</th>
                <th>สถานะการใช้งาน</th>
                <th>สถานะแบต</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($getData)) : ?>
                <?php foreach ($getData as $key => $value) : ?>
                  <?php foreach ($getData_room as $key => $valueroom) : ?>
                  <?php if ($valueroom->r_w_id==$value->w_id) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $value->w_name ?></td>
                    <?php if (is_array($getData)) : ?>
                      <?php $found = false; ?>
                      <?php foreach ($getData_room as $key => $value2) : ?>
                        <?php if ($value2->r_w_id == $value->w_id) : ?>
                          <td><?= $value2->r_name ?></td>
                          <?php $found = true; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <?php if (!$found) : ?>
                        <td><?= "ว่าง" ?></td>
                      <?php endif; ?>
                    <?php endif; ?>
                    <td class="<?= $value->w_status == 1 ? "text-success" : "text-danger" ?>""><?= $value->w_status == 1 ? "กำลังใช้งาน" : "ไม่ได้ใช้งาน" ?></td>
                    <td><?= $value->w_vbatt > 3.5 ? "ปกติ" : "กำลังจะหมด" ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-info btn-sm" name="edit" id="get" onclick="get(<?= $value->w_id ?>)" title="แก้ไขข้อมูลพนักงาน"><i class="fas fa-eye"></i></button>
                      <!-- onclick="edit(<?= $value->user_id ?>)"  -->
                      <button type="button" class="btn btn-warning btn-sm" name="edit" id="changePass" onclick="edit(<?= $value->w_id ?>)" title="เปลี่ยนรหัสผ่าน"><i class="icon-pencil"></i></button>
                      <?php if ($value->w_status == 1) : ?>
                        <button type="button" class="btn btn-success btn-sm" name="del" id="del" title="ปิดการใช้งาน" onclick="changeStatus(<?= $value->w_id ?>,<?= $value->w_status ?>)"><i class="fas fa-lock-open"></i></button>
                      <?php else : ?>
                        <button type="button" class="btn btn-danger btn-sm" name="del" id="del" title="เปิดใช้งาน" onclick="changeStatus(<?= $value->w_id ?>,<?= $value->w_status ?>)"><i class="fas fa-lock"></i></button>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>