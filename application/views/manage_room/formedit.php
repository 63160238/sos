<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>ผังหอพัก</h4>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">ห้องพัก</th>
                <th class="text-center">แก้ไขห้องพัก</th>
                <th class="text-center">ประเภทห้อง</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php if (is_array($room)) : ?>
                <?php foreach ($room as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td name="r_id[]">
                      <input type="hidden" class="r_id" value="<?= $value->r_id ?>">
                      <?= $value->r_name ?>
                    </td>
                    <td><input name="r_name[]" id="r_name" value=""></td>
                    <td>
                      <select name="ac_type_name[]" id="ac_type_name" class=" btn btn-info">
                        <?php foreach ($type as $value2) : ?>
                          <option value="<?= $value2->ac_type_id ?>" <?= $value->r_type == $value2->ac_type_id ? 'selected' : '' ?>>
                            <?= $value2->ac_type_name ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
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
  function saveFormSubmit(r_id) {
    var tableData = [];
    // วนลูปผ่านแต่ละแถวของตาราง
    $("table tbody tr").each(function(index) {
      var rowData = {};
      // เข้าถึงข้อมูลในแต่ละฟิลด์ของแถว
      var r_id = $(this).find(".r_id").val();
      var r_name = $(this).find("input[name='r_name[]']").val();
      var ac_type_id = $(this).find("select[name='ac_type_name[]']").val();
      if (r_id) {
        rowData["r_id"] = r_id;
        rowData["r_name"] = r_name;
        rowData["ac_type_id"] = ac_type_id;
        tableData.push(rowData);
      }
      // เพิ่มอ็อบเจกต์ rowData เข้าไปในอาร์เรย์ tableData
    });
    // แสดงข้อมูลที่เก็บไว้ในอาร์เรย์ tableData ใน Console
    console.log(tableData);
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    $.ajax({
      method: "post",
      url: 'Apartment/edit_room',
      data: {
        data: tableData
      },
    }).done(function(returnData) {
      // console.log(returnData);
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
        // $('#roomForm')[0].reset();
        $('#mainModal').modal('hide');
        filter();
      }
    });
  }
</script>