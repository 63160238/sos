<!-- <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">เพิ่มสมาชิกใหม่</h4>
      </div>
    </div>
  </div>
</div> -->
<?php if ($_SESSION['user_role'] == 3) { ?>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
          <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
          <div class="row">
            <div class="col-4">
              <label for="p_category">เลือก Apartment </label>
              <div class="input-group">
                <select class="form-control select2" id="a_id" onchange="chageAppartment()" name="inputValue[]">
                  <option selected disabled value="all">-- กรุณาเลือกหอพัก --</option>
                  <?php if ($filterApartment) { ?>
                    <?php foreach ($filterApartment as $value) : ?>
                      <?php if (intval($value->a_id) == $_SESSION['user_a_id']) : ?>
                        <?php echo '<option selected value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                      <?php else : ?>
                        <?php echo '<option value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                      <?php endif ?>
                    <?php endforeach ?>
                  <?php  } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php  } ?>
<div id="listDiv"></div>
<script>
  var floor = [];
  let currentIndex = 0;
  var newValue = 0;
  loadList();

  function loadList() {
    $.ajax({
      url: 'getFloor',
      method: 'get',
      dataType: 'json',
      success: function(data) {
        floor = data;
        if (floor.length > 0) {
          let f = floor[currentIndex]['r_floor'];
        }
        $.ajax({
          url: 'getMeterList',
          method: 'post',
          data: {
            filterFloor: 1,
          }
        }).done(function(returnedData) {
          $('#listDiv').html(returnedData.html);
          showData();
          updateCharts();
        })
        // loadList();
      }
    })
  }

  function chageAppartment() {
    $.ajax({
      url: 'getMeterList',
      method: 'post',
      data: {
        apartment: $('#a_id').val(),
      }
    }).done(function(returnedData) {
      $.ajax({
        url: 'getFloor',
        method: 'get',
        dataType: 'json',
        success: function(data) {
          floor = data;
          if (floor.length > 0) {
            let f = floor[currentIndex]['r_floor'];
          }
          $('#listDiv').html(returnedData.html);
          f = 1;
          currentIndex = 0;
          updateCharts();
        }
      })
    })
  }

  function chageFloor() {

    $.ajax({
      url: 'getMeterList',
      method: 'post',
      data: {
        filterFloor: f,
      }
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
      updateCharts();
    })

  }
</script>