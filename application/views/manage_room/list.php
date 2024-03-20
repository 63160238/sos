<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>ผังหอพัก</h4>
        <!-- <button type="button" class="btn btn-info mb-2 "onclick=add()>เพิ่ม-ลด ห้องพัก</button> -->
        <button type="button" class="btn btn-info mb-2" onclick=edit()>แก้ไขห้องพัก</button>
        
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">ห้องพัก</th>
                <!-- <th class="text-center">แก้ไขห้องพัก</th> -->
                <th class="text-center">ประเภทห้อง</th>
                <!-- <th class="text-center">แก้ไขประเภทห้อง</th> -->
                <!-- <th>การใช้งานน้ำล่าสุด</th> -->
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php if (is_array($room)) : ?>
                <?php foreach ($room as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $value->r_name ?></td>
                    <td>ธรรมดา</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-outline-secondary btn-sm" name="del" id="del" title="ปิดการใช้งาน" ?><i class="fas fa-trash-alt"></i></button>
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

<!-- <script>
  $('.table').DataTable();
</script> -->