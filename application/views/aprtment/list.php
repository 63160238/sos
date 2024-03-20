<div class="row">
  <div class="col-12" id="table">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>รายการห้องพัก</h4>
        <!-- <button type="button" class="btn btn-info mb-2 " onclick=add()>เพิ่ม-ลด ห้องพัก</button> -->
        <button type="button" class="btn btn-info mb-2" onclick=edit_room()>แก้ไขห้องพัก</button>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>ห้อง</th>
                <th>ผู้เช่า</th>
                <th>สถานะการชำระเงิน</th>
                <th>การใช้งานน้ำล่าสุด</th>
                <th>การใช้งานไฟล่าสุด</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($getData)) : ?>
                <?php foreach ($getData as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $value->r_name ?></td>
                    <?php if ($value->r_u_id != null&&$value->r_u_id != 0)  : ?>
                      <?php foreach ($getData_user as $key => $value2) : ?>
                        <?php if ($value->r_u_id == $value2->user_id ) : ?>
                          <td><?= $value2->fname_th . " " . $value2->lname_th ?></td>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <td><?= "ว่าง" ?></td>
                    <?php endif; ?>
                    <?php if ($value->pay_status != null) : ?>
                      <?php foreach (P_STATUS as $key => $value2) : ?>
                        <?php if ($value->pay_status == $key) : ?>
                          <td class="<?= $color[$value->pay_status-1] ?>"><?= $value2 ?></td>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <td><?= "ไม่มีผู้เช่า" ?></td>
                    <?php endif; ?>
                    <?php if (is_array($getData_water_now)) : ?>
                      <?php foreach ($getData_water_now as $key => $value3) : ?>
                        <?php if ($value->r_id == $value3->bil_r_id) : ?>
                          <?php if ($value3->w_flow_sum != 0) : ?>
                            <td><?= ($value3->w_flow_sum) . " หน่วย " ?>/
                              <?= $getData_Apamet->a_water_cost * $value3->w_flow_sum . " บาท" ?>
                            </td>
                          <?php else : ?>
                            <td><?= " ไม่มีข้อมูล " ?>
                            </td>
                          <?php endif; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <!-- <?php if ($sd) : ?>
                        <td> ไม่มิเตอร์น้ำ
                        </td> -->
                      <!-- <?php endif; ?> -->
                    <?php endif; ?>
                    <?php if (is_array($getData_power_now)) : ?>
                      <?php foreach ($getData_power_now as $key => $value4) : ?>
                        <?php if ($value->r_id == $value4->bil_r_id) : ?>
                          <?php if ($value4->p_kwh != 0) : ?>
                            <td><?= $value4->p_kwh . " หน่วย " ?>/
                              <?= $getData_Apamet->a_power_cost * $value4->p_kwh . " บาท" ?></td>
                          <?php else : ?>
                            <td><?= " ไม่มีข้อมูล " ?>
                            <?php endif; ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      <?php else : ?>
                            <td> ไม่มิเตอร์น้ำ
                            </td>
                          <?php endif; ?>
                          <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" name="edit" id="get" onclick="get(<?= $value->r_id ?>)" title="ดูรายละเอียด"><i class="fas fa-eye"></i></button>
                            <!-- onclick="edit(<?= $value->user_id ?>)"  -->
                            <button type="button" class="btn btn-warning btn-sm" name="edit" id="changePass" onclick="edit(<?= $value->r_id ?>)" title="เปลี่ยนรหัสผ่าน"><i class="icon-pencil"></i></button>
                            <button type="button" class="btn btn-success btn-sm" name="edit" id="changePass" onclick="edit_slip(<?= $value->r_id ?>)" title="ตรวจสอบยอดโอนเงิน"><i class=" fas fa-donate"></i></button>
                            <!-- <button type="button" class="btn btn-outline-secondary btn-sm" name="del" id="del" onclick="changeStatus(<?= $value->r_id ?>,<?= $value->status ?>)" title="ปิดการใช้งาน" ?><i class="fas fa-trash-alt"></i></button> -->

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