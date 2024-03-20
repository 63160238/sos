<div class="row">
  <?php $sum = 0 ?>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>รายการการคำนวนบิล</h4>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th>ห้อง</th>
                <th class="text-center">วันครบกำหนด</th>
                <th>ราคาห้อง</th>
                <th>เลขมิเตอร์ไฟก่อนหน้า</th>
                <th>เลขมิเตอร์ไฟล่าสุด</th>
                <th>เลขมิเตอร์น้ำก่อนหน้า</th>
                <th>เลขมิเตอร์น้ำล่าสุด</th>
                <th>ราคาสุทธิล่าสุด</th>
                <th>คำนวนล่าสุด</th>
                <th>บันทึกล่าสุด</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($getData_room)) : ?>
                <?php foreach ($getData_room as $key => $value) : ?>
                  <tr data-room-id="<?= $value->r_id ?>">
                    <td>
                      <?= $value->r_name ?>
                    </td>
                    <?php
                    // วันที่ต้องการ
                    $current_month = date('m'); // หรือ 'n' หากต้องการให้เดือนเป็นรูปแบบที่ไม่มีศูนย์นำหน้า
                    $current_year = date('Y');
                    $target_date = strtotime("$current_year-$current_month-$value->r_duedate");
                    // วันปัจจุบัน
                    $current_date = strtotime("today");

                    // หาจำนวนวันที่เหลือ
                    $diff_seconds = $target_date - $current_date;
                    $diff_days = floor($diff_seconds / (60 * 60 * 24));
                    ?>
                    <?php if ($diff_days < 0) : ?>
                      <td class="text-danger">
                        <?php $late = 0 - $diff_days; ?>
                        <?= "ครบกำหนดมาแล้ว $late วัน"; ?>
                      </td>
                    <?php else : ?>
                      <?php if ($diff_days == 0) : ?>
                        <td class="text-success">
                          <?= "ครบรอบการจดบิล"; ?>
                        </td>
                      <?php else : ?>
                        <td class="text-warning">
                          <?= "อีก $diff_days วัน"; ?>
                        </td>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php if (is_array($getData_type)) : ?>
                      <?php foreach ($getData_type as $key => $value2) : ?>
                        <?php if ($value->r_type == $value2->ac_type_id) : ?>
                          <td id="ac_type_cost">
                            <?= $value2->ac_type_cost ?>
                          </td>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (is_array($getData_bill)) : ?>
                      <?php foreach ($getData_bill as $key) : ?>
                        <?php foreach ($key as $value3) : ?>
                          <?php if ($value->r_id == $value3->bil_r_id) : ?>
                            <td id="bill_p_khw">
                              <?= $value3->bill_p_khw ?>
                            </td>
                            <?php if ($value3->bill_mg_status == 0) : ?>
                              <td><input type="number" id="P_meter" name="inputValue[]" class="form-control" placeholder="กรอกเลขมิเตอร์" oninput="updateSum(this)" disabled></td>
                              <td id="bill_w_flow">
                                <?= $value3->bill_w_flow ?>
                              </td>
                              <td><input type="number" id="w_meter" class="form-control" placeholder="กรุณาเลขมิเตอร์" oninput="updateSum(this)" disabled></td>
                              <td>
                              <?php endif; ?>
                              <?php if ($value3->bill_mg_status == 1) : ?>
                              <td><input type="number" id="P_meter" name="inputValue[]" class="form-control" placeholder="กรอกเลขมิเตอร์" oninput="updateSum(this)"></td>
                              <td id="bill_w_flow">
                                <?= $value3->bill_w_flow ?>
                              </td>
                              <td><input type="number" id="w_meter" class="form-control" placeholder="กรุณาเลขมิเตอร์" oninput="updateSum(this)"></td>
                              <td>
                              <?php endif; ?>
                              <?= $value3->bill_cost ?>
                              </td>
                              <td class="sum-cell" id="sum"></td>
                              <td id="date">
                                <?= $value3->bill_updete_at ?>
                              </td>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                      <td class="text-center">
                        <?php if (is_array($getData_bill)) : ?>
                          <?php foreach ($getData_bill as $key) : ?>
                            <?php foreach ($key as $value3) : ?>
                              <?php if ($value->r_id == $value3->bil_r_id) : ?>
                                <?php if ($value3->bill_mg_status == 1) : ?>
                                  <?php foreach ($meter as $key => $value4) : ?>
                                    <?php if ($value4->p_id == $value->r_p_id) : ?>
                                      <?php if ($value4->emb_id != 0) : ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" name="edit" id="get" title="จดเลขอัตโนมัต" onclick="get_meter(<?= $value3->bil_r_id ?>)"><i class="fas fa-weight"></i></button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                  <button type="button" onclick="confirmSubmit(<?= $value3->bil_r_id ?>,<?= $diff_days ?>)" class="btn btn-outline-info btn-sm" name="edit" id="save" title="บันทึก"><i class="fas fa-save"></i></button>
                                <?php endif; ?>
                                <?php if ($value3->bill_mg_status == 0) : ?>
                                  <button type="button" onclick="edit(<?= $value3->bil_r_id ?>)" class="btn btn-outline-warning btn-sm" name="edit" id="change" title="คำนวนใหม่"><i class="icon-pencil"></i></button>
                                  <button type="button" class="btn btn-outline-info btn-sm" name="edit" id="post" title="ส่งบิลให้ผู้เช่า" onclick="changeStatus(<?= $value3->bil_r_id ?>)"><i class="fas fa-paper-plane"></i></button>
                                <?php endif; ?>
                                <!-- <button type="button" class="btn btn-outline-secondary btn-sm" name="del" id="del" title="คืนค่าเริ่มต้น"><i class="fas fa-trash-alt"></i></button> -->
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endforeach; ?>
                        <?php endif; ?>
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
  var row = "";

  function updateSum(element) {
    row = element.closest('tr');
    var inputValue = parseFloat(element.value);
    P_meterValue = parseFloat(row.querySelector('#P_meter').value) || 0;
    w_meterValue = parseFloat(row.querySelector('#w_meter').value) || 0;
    ac_type_cost = parseFloat(row.querySelector('#ac_type_cost').innerText) || 0;
    bill_p_khw = parseFloat(row.querySelector('#bill_p_khw').innerText) || 0;
    bill_w_flow = parseFloat(row.querySelector('#bill_w_flow').innerText) || 0;
    if (P_meterValue < bill_p_khw || w_meterValue < bill_w_flow) {
      row.querySelector('.sum-cell').innerHTML = '<td class="sum-cell"><span class="text-danger">' + "เลขมิเตอร์น้อยกว่าค่าเดิม" + '</span></td>';
    } else if (P_meterValue >= bill_p_khw && w_meterValue >= bill_w_flow) {
      sum = ((P_meterValue - bill_p_khw) * <?= $getData_Apamet->a_power_cost ?>) + ((w_meterValue - bill_w_flow) * <?= $getData_Apamet->a_water_cost ?>) + ac_type_cost;
      row.querySelector('.sum-cell').innerHTML = '<td class="sum-cell">' + sum.toFixed(2) + '</td>'

    }
  }
</script>

<script>
  function confirmSubmit(r_id, diff_days) {
    if (diff_days > 0) {
      Swal.fire({
        title: 'อีก ' + diff_days + ' วัน ครบกำหนดรอบบิล',
        text: 'คุณต้องการที่จะตัดรอบบิลเลย ใช่หรือไม่?',
        type: "warning",
        focusConfirm: false,
        allowOutsideClick: false,
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonColor: "#E4E4E4",
        cancelButtonText: "<font style='color:black'>" + 'ภายหลัง' + "</font>",
      }).then((result) => {
        if (result.value == true) {
          saveSubmitbill(r_id);
        }
      });
    } else {
      saveSubmitbill(r_id);
    }
  }

  function saveSubmitbill(r_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    if (sum > 0) {
      var formData = {};
      formData['bil_r_id'] = r_id;
      $('[name^="inputValue"]').each(function() {
        formData['bill_p_khw'] = P_meterValue;
        formData['bill_w_flow'] = w_meterValue;
        formData['bill_w_flow_month'] = w_meterValue - bill_w_flow;
        formData['bill_p_khw_moth'] = P_meterValue - bill_p_khw;
        formData['bill_cost'] = sum;
        formData['bill_a_id'] = <?= $getData_Apamet->a_id ?>;
        formData['bill_mg_status'] = 0;
      });
      $.ajax({
        method: "post",
        url: 'Bill/add',
        data: formData
      }).done(function(returnData) {
        if (returnData.status == 1) {
          $.toast({
            heading: 'สำเร็จ',
            text: returnData.msg,
            position: 'top-right',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
          });
          $('#fMsg').addClass('text-success');
          $('#fMsg').text(returnData.msg);
          $('#mainModal').modal('hide');
          loadList();
        } else {
          $.toast({
            heading: 'ล้มเหลว',
            text: returnData.msg,
            position: 'top-right',
            icon: 'error',
            hideAfter: 3500,
            stack: 6
          });
          loadList();
        }
      });
    } else {
      $.toast({
        heading: 'คำนวนผิดพลาด',
        text: "กรอกข้อมุลให้ถูกต้อง",
        position: 'top-right',
        icon: 'error',
        hideAfter: 3500,
        stack: 6
      });
      $('#fMsg').addClass('text-error');
      $('#fMsg').text("กรอกข้อมุลให้ถูกต้อง");
      $('#mainModal').modal('hide');
      loadList();
    }
  }

  function edit(bil_r_id) {
    var formData = {};
    formData['bill_a_id'] = <?= $getData_Apamet->a_id ?>;
    formData['date'] = date;
    $.ajax({
      method: "post",
      url: 'Bill/edit',
      data: {
        bil_r_id: bil_r_id,
        bill_a_id: formData['bill_a_id'],
      }
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      loadList();
    });
  }

  function loadList() {
    $.ajax({
      url: 'bill/get',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    });
  }

  function saveFormSubmit(r_id) {
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var formData = {};
    formData['bil_r_id'] = r_id;
    formData['bill_p_khw'] = P_meterValue;
    formData['bill_w_flow'] = w_meterValue;
    formData['bill_cost'] = sum;
    formData['bill_w_flow_month'] = w_meterValue - bill_w_flow;
    formData['bill_p_khw_moth'] = P_meterValue - bill_p_khw;
    formData['bill_a_id'] = <?= $getData_Apamet->a_id ?>;
    formData['bill_mg_status'] = 0;
    $.ajax({
      method: "post",
      url: 'Bill/update_Edit',
      data: formData
    }).done(function(returnData) {
      if (returnData.status == 1) {
        $.toast({
          heading: 'สำเร็จ',
          text: returnData.msg,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          stack: 6
        });
        $('#fMsg').addClass('text-success');
        $('#fMsg').text(returnData.msg);
        $('#roomForm')[0].reset();
        $('#mainModal').modal('hide');
        loadList();
      }
    });
  }

  function get_meter(r_id) {
    var row = $('[data-room-id="' + r_id + '"]');
    $.ajax({
      method: "post",
      url: 'Bill/get_meter',
      data: {
        r_id: r_id
      }
    }).done(function(returnData) {
      row.find('#P_meter').val(returnData.getData_p.p_kwh);
      row.find('#w_meter').val(returnData.getData_w.w_flow_sum);
      P_meterValue = returnData.getData_p.p_kwh
      w_meterValue = returnData.getData_w.w_flow_sum
      ac_type_cost = parseFloat(row.find('#ac_type_cost').text()) || 0;
      bill_p_khw = parseFloat(row.find('#bill_p_khw').text()) || 0;
      bill_w_flow = parseFloat(row.find('#bill_w_flow').text()) || 0;
      sum = ((P_meterValue - bill_p_khw) * <?= $getData_Apamet->a_power_cost ?>) + ((w_meterValue - bill_w_flow) * <?= $getData_Apamet->a_water_cost ?>) + ac_type_cost;
      row.find('.sum-cell').html('<td class="sum-cell">' + sum.toFixed(2) + '</td>');

      // If you need to update the sum globally, you can assign it to a global variable here.
    });
  }
</script>

<!-- <script>
  $('.table').DataTable();
</script> -->