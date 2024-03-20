<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class='card-title'>รายการใบเสร็จชำระค่าเช่าห้อง</h4>
                <div class="table-responsive">
                    <!-- Textarea for Bootstrap-wysihtml5 -->
                    <table class="display table table-striped table-bordered dt-responsive nowrap">

                        <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
                        <thead>
                            <tr>
                                <th class="text-center" hidden>ลำดับ</th>
                                <th class="text-center">เดือนปี</th>
                                <th class="text-center">ชื่อใบเสร็จชำระ</th>
                                <th class="text-center">เลขห้อง</th>
                                <th class="text-center">ชื่อผู้เข้าพัก</th>
                                <th class="text-center">รวมสุทธิ</th>
                                <th class="text-center">สลิปชำระเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($receipt)) : ?>
                                <?php foreach ($receipt as $key => $value) : ?>
                                    <tr>
                                        <td class="text-center" hidden><?= $key + 1 ?></td>
                                        <td class="text-center"><?= $value->date ?></td>
                                        <td class="text-center"><a href="#" title="กดเพื่อเปิดดูใบเสร็จรับเงิน" onclick="printReceipt('<?= $value->bill_id ?>','<?= $value->receipt_id ?>')"><?= $value->receipt_id ?></a></td>
                                        <td class="text-center"><?= $value->r_id ?></td>
                                        <td class="text-center"><?= $value->u_name ?></td>
                                        <td class="text-center"> <?= $value->bill_cost ?> บาท</td>
                                        <td class="text-center"><a  class="btn btn-primary" title="เอกสารสัญญา" target="_blank" href="<?= base_url() ?>assets\slips\<?= $value->bill_slip ?>"><i class="mdi mdi-file-pdf"></i> </a></td>
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