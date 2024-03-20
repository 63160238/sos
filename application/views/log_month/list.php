<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>เลือกปีของประวัติการใช้น้ำ ใช้ไฟ</h4>
        <div class="table-responsive">
          <select class="form-control form-select col-lg-1 col-xlg-2 col-md-2" name="filterYear" id="filterYear" onchange="chageYear()">
            <?php
            if ($select) {
              echo '<option disabled  value= "">เลือกปี</option>';
              echo '<option selected value= "' . $select . '">ปี ' . ($select+543) . ' </option>';
            } else {
              echo '<option disabled selected value= "">เลือกปี</option>';
            }
            foreach ($filterYear as $ft) {
              if ($ft != $select) {
                echo '<option value= "' . $ft . '">ปี ' . ($ft+543) . ' </option>';
              }
            } ?>
          </select>
          <table class="display table table-striped table-bordered dt-responsive nowrap">

            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">ลำดับ</th>
                <th>เดือน</th>
                <th>น้ำ (หน่วย)</th>
                <th>ค่าน้ำ (บาท)</th>
                <th>ไฟ (หน่วย)</th>
                <th>ค่าไฟ (บาท)</th>
                <th>ราคาสุทธิ (บาท)</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($history) : ?>
                <?php foreach ($history as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td class="text-center"><?= thaiMonthFull(date('n', strtotime($value->bill_updete_at))) ?></td>
                    <td class="text-center"><?= round($value->bill_w_flow, 2) ?> หน่วย</td>
                    <td class="text-center"><?= round($value->bill_w_flow, 2) * $config->a_water_cost ?> บาท</td>
                    <td class="text-center"><?= round($value->bill_p_khw, 2) ?> หน่วย</td>
                    <td class="text-center"><?= round($value->bill_p_khw, 2) * $config->a_power_cost ?> บาท</td>
                    <td class="text-center"><?= $value->bill_cost ?> บาท</td>
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
  $('.table').DataTable({
    dom: 'ftp'
  });
</script>