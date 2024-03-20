<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class='card-title'>รายการสัญญาเช่า</h4>
                <div class="table-responsive">
                    <!-- Textarea for Bootstrap-wysihtml5 -->
                    <table class="display table table-striped table-bordered dt-responsive nowrap">

                        <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th>เลขห้อง</th>
                                <th>ชื่อผู้เข้าพัก</th>
                                <th>ระยะเวลาสัญญา</th>
                                <th>วันที่สิ้นสุดสัญญา</th>
                                <th>สถานะการทำสัญญา</th>
                                <th>ปุ่มดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($doc_data)) : ?>
                                <?php foreach ($doc_data as $key => $value) : ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td class="text-center"><?= $value->r_name ?></td>
                                        <td class="text-center"><?= $value->u_name ?></td>
                                        <td class="text-center"><?= $value->regis_period == 1 ? "6": "12" ?> เดือน</td>
                                        <td class="text-center"><?= thaiDate_Full($value->regis_start_date) ?></td>
                                        <td class="text-center">
                                            <?php if ($value->regis_status == 1) : ?>
                                                <p style="color:orange;">รอเซ็นสัญญา</p>
                                            <?php endif; ?>
                                            <?php if ($value->regis_status == 2) : ?>
                                                <p style="color:green">เซ็นสัญญาเรียบร้อย</p>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($value->regis_status == 1) : ?>
                                                <button id="editForm" title="แก้ไขข้อมูล" onclick="editForm(<?= $value->regis_id ?>)" class="btn btn-warning"><i class="mdi mdi-pencil"></i></button>
                                                <label for="upload-file">
                                                    <button class="btn btn-secondary" title="แนบไฟล์สัญญา" id="bt-upload" onclick="openDialog(<?= $value->r_name ?>)" type="button">
                                                        <i class="mdi mdi-upload"></i>
                                                    </button>
                                                    <input type="file" name="files[]" id="upload<?= $value->r_name ?>" onchange="uploadFile(<?= $value->regis_u_id ?>,<?= $value->r_name ?>)" hidden>
                                                </label>
                                            <?php endif; ?>
                                            <?php if ($value->regis_status == 2) : ?>
                                                <button class="btn btn-secondary" title="ดูข้อมูลสัญญา" onclick="viewForm(<?= $value->regis_id ?>)" type="button">
                                                    <i class="mdi mdi-magnify"></i>
                                                </button>
                                                <a  class="btn btn-primary" title="เอกสารสัญญา" target="_blank" href="<?= base_url() ?>assets\docs\contract\<?= $value->sign_contract ?>"><i class="mdi mdi-file-pdf"></i> </a>
                                                <button class="btn btn-secondary" title="ยกเลิกการแนบสัญญา" onclick="cancelContract(<?= $value->r_name ?>,<?= $value->regis_id ?>)" type="button">
                                                    <i class="mdi mdi-file-restore"></i>
                                                </button>
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