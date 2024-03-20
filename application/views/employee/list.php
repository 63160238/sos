<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>รายชื่อสมาชิก</h4>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>ชื่อ - นามสกุล</th>
                <!-- <th>สิทธิ์</th> -->
                <th>สถานะ</th>
                <th>หอพัก</th>
                <th>วันที่เพิ่ม</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($getData)) : ?>
                <?php foreach ($getData as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $value->fname_th ?> <?= $value->lname_th ?></td>
                    <!-- <td><?= ROLE[$value->role] ?></td> -->
                    <td class="<?= ($value->status == 1 ? "text-success" : "text-danger") ?>"><?= ($value->status == 1 ? 'ใช้งาน' : 'ไม่ใช้งาน') ?></td>
                    <?php if($value->user_a_id !=0) :?>
                      <?php $output = ''; ?>
                    <?php foreach ($apartment_name as $key => $value2) : ?>
                      <?php foreach ($value->user_a_id as $key => $value_a) : ?>
                      <?php if ($value_a == $value2->a_id) : ?>
                        <?php $output .=  $value2->a_name ."<br>"; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endforeach; ?>
                    <td><?= $output ?></td>
                    <?php else : ?>
                      <td><?= "ไม่จำกัด" ?></td>
                    <?php endif; ?>
                    <td><?= thaiDate($value->created_at) ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-warning btn-sm" name="edit" id="edit" onclick="edit(<?= $value->user_id ?>)" title="แก้ไขข้อมูลพนักงาน"><i class="icon-pencil"></i></button>
                      <button type="button" class="btn btn-outline-secondary btn-sm" name="edit" id="changePass" onclick="changePass(<?= $value->user_id ?>)" title="เปลี่ยนรหัสผ่าน"><i class="mdi mdi-key-change"></i></button>
                      <?php if ($value->status == 1) : ?>
                        <button type="button" class="btn btn-success btn-sm" name="del" id="del" title="ปิดการใช้งาน" onclick="changeStatus(<?= $value->user_id ?>,<?= $value->status ?>)"><i class="fas fa-lock-open"></i></button>
                      <?php else : ?>
                        <button type="button" class="btn btn-danger btn-sm" name="del" id="del" title="เปิดใช้งาน" onclick="changeStatus(<?= $value->user_id ?>,<?= $value->status ?>)"><i class="fas fa-lock"></i></button>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.table').DataTable();
</script>