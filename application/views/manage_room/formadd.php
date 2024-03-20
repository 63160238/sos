<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>เพิ่มห้องพัก</h4>
        <button id="addRowBtn" class="btn btn-primary mt-3 mr-1 mb-2">เพิ่มชั้น</button>
        <div class="table-responsive">
          <table id="roomTable" class="display table table-striped table-bordered dt-responsive nowrap">
            <thead>
              <tr>
                <th class="text-center">ชั้น</th>
                <th class="text-center">จำนวนห้อง</th>
                <th class="text-center"></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php if (is_array($floor)) : ?>
                <?php foreach ($floor as $key => $value) : ?>
                  <?php for ($i = 1; $i <= $value->a_floor; $i++) : ?>
                    <tr>
                      <td class="input-floor">
                        <?= $i ?>
                      </td>
                      <?php $cout = 0 ?>
                      <?php $user = 0 ?>
                      <?php if (is_array($room)) : ?>
                        <?php foreach ($room as $key => $value2) : ?>
                          <?php if ($value2->r_floor == $i) : ?>
                            <?php $cout += 1 ?>
                            <?php if ($value2->r_u_id) : ?>
                              <?php $user += 1 ?>
                            <?php endif; ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($user > 1) : ?>
                          <td class="input-room"><input type="number" class="roomInput" value="<?= $cout ?>" disabled></td>
                          <?php $data[$i] = $cout ?>
                          <td><button class="btn btn-danger btn-sm delete-row" title="ชั้นนี้ยังมีผู้ใช้งาน " disabled>ลบ</button></td>
                        <?php else : ?>
                          <td class="input-room"><input type="number" class="roomInput" value="<?= $cout ?>"></td>
                          <td><button class="btn btn-danger btn-sm delete-row">ลบ</button></td>
                        <?php endif; ?>
                      <?php endif; ?>

                    </tr>
                  <?php endfor; ?>
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
  var tableData = []; // สร้างอาร์เรย์เพื่อเก็บค่าของตาราง
  $(document).ready(function() {
    $('#addRowBtn').click(function() {
      var rowCount = $('#roomTable tbody tr').length + 1;
      var newRow = '<tr><td>' + rowCount + '</td>' + '<td><input type="number" class="roomInput" value="' + 0 + '"></td><td><button class="btn btn-danger btn-sm delete-row">ลบ</button></td></tr>';
      $('#roomTable tbody').append(newRow);
    });
    // เมื่อมีการเปลี่ยนแปลงค่าใน input
    $(document).on('click', '.delete-row', function() {
      $(this).closest('tr').remove();
    });
  });
  // ตัวอย่างการแสดงผลข้อมูลใน console
</script>
<script>
  function saveFormRoom(r_id) {
    var u = 0;
    $('#fMsg').addClass('text-warning');
    $('#fMsg').text('กำลังดำเนินการ ...');
    var data = []; // สร้างอาร์เรย์เพื่อเก็บค่า $i และ $cout
    $('.input-floor').each(function(index) {
      var i = $(this).text(); // ดึงค่า $i จาก <td class="input-floor">
      var cout = $(this).closest('tr').find('.roomInput').val(); // ดึงค่า $cout 
      data.push({
        i: i,
        cout: cout
      });
    });
    $('#roomTable tbody tr').each(function() {
      var floor = $(this).find('td:eq(0)').text();
      var room = $(this).find('.roomInput').val();
      if (room <= 0) {
        u = 1;
      } else {
        tableData.push({
          floor: floor,
          room: room
        });
      }
    });
    if (u == 1 || tableData.length == 0) {
      tableData = [];
      $('#fMsg').addClass('text-warning');
      $('#fMsg').text('กรอกข้อมูลให้ถูกต้อง');
      $.toast({
        heading: 'พบข้อผิดพลาด',
        text: 'กรอกข้อมูลให้ถูกต้อง',
        position: 'top-right',
        loaderBg: '#FF5733',
        icon: 'error',
        hideAfter: 3500,
        stack: 6
      })
      return false;
    }
    // ตัวอย่างการแสดงผลข้อมูลใน console
    // console.log(tableData);
    // // console.log(data);
    // var formData = {};
    // formData['r_id'] = r_id;
    // // $('[name^="inputValue"]').each(function() {
    // //   formData[this.id] = this.value;
    // // });
    $.ajax({
      method: "post",
      url: 'Apartment/update_formroom',
      data: {
        tableData: tableData
      }, // แปลงอ็อบเจกต์ tableData เป็น JSON string
      // contentType: "application/json",
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
        $('#mainModal').modal('hide');
        filter();
      }
    });
  }

  function loadList() {
    $.ajax({
      url: 'Apartment/get',
      method: 'post'
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }
</script>