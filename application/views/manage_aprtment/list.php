<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>รายการหอพัก</h4>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>หอพัก</th>
                <th>จำนวนห้องพัก</th>
                <th>เจ้าหน้าที่ดูแลหอพัก</th>
                <!-- <th>การใช้งานน้ำล่าสุด</th> -->
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($getData)) : ?>
                <?php foreach ($getData as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $value->a_name ?></td>
                    <?php foreach ($room as $key => $value4) : ?>
                      <?php if ($value4['r_a_id'] == $value->a_id) : ?>
                        <td><?= $value4['count'] ?></td>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if (isset($value->admin)) : ?>
                      <td>
                      <?php foreach ($value->admin as $admin) : ?>
                        <?= $admin.'<br>' ?>
                      <?php endforeach; ?>
                    </td>
                    <?php else : ?>
                      <td>ไม่มีคนดูแล</td>
                    <?php endif; ?>
                    <td class="text-center">
                      <button type="button" class="btn btn-info btn-sm" name="edit" id="get" onclick="get(<?= $value->a_id ?>)" title="ดูข้อมูลหอพัก"><i class="fas fa-eye"></i></button>
                      <!-- onclick="edit(<?= $value->a_id ?>)"  -->
                      <button type="button" class="btn btn-warning btn-sm" name="edit" id="changePass" onclick="edit(<?= $value->a_id ?>)" title="แก้ไขข้อมูลหอพัก"><i class="icon-pencil"></i></button>
                      <button type="button" class="btn btn-outline-info btn-sm" name="edit" id="changePass" onclick="seting(<?= $value->a_id ?>)" title="ตั่งค่าหอพัก"><i class="fas fa-cogs"></i></button>
                      <button type="button" class="btn btn-outline-danger btn-sm" name="del" id="del" title="ปิดการใช้งาน" onclick="changeStatus(<?= $value->a_id ?>,0)"?><i class="fas fa-trash-alt"></i></button>
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