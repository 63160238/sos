<style>
  .blur {
    filter: blur(8px);
    /* เพิ่มเอฟเฟคเบลอ */
  }
</style>
<?php if (!isset($_SESSION['a_ses']) && $_SESSION['user_role'] == 2 && count($_SESSION['a_id']) > 1) : ?>
  <div class="blur">
    <div class="row ">
      <div class="col-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
            <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
            <div class="row">
              <?php if ($_SESSION['user_role'] == 3) { ?>
                <div class="col-4">
                  <label for="p_category">เลือก Apartment </label>
                  <div class="input-group">
                    <select class="form-control select2" id="a_id" name="inputValue[]" onchange="chageApartment(),loadList()" name="action">
                      <option disabled value="all">-- กรุณาเลือกหอพัก --</option>
                      <?php if ($filterApartment) { ?>
                        <?php foreach ($filterApartment as $value) : ?>
                          <?php if (intval($value->a_id) == $_SESSION['user_a_id']) : ?>
                            <?php echo '<option selected value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                          <?php else : ?>
                            <?php echo '<option value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                          <?php endif ?>
                        <?php endforeach ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="listDiv"></div>
  </div>
<?php else : ?>
  <?php if ($_SESSION['user_role'] == 3) { ?>
  <div class="row ">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
          <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
          <div class="row">
            <?php if ($_SESSION['user_role'] == 3) { ?>
              <div class="col-4">
                <label for="p_category">เลือก Apartment </label>
                <div class="input-group">
                  <select class="form-control select2" id="a_id" name="inputValue[]" onchange="chageApartment(),loadList()" name="action">
                    <option disabled value="all">-- กรุณาเลือกหอพัก --</option>
                    <?php if ($filterApartment) { ?>
                      <?php foreach ($filterApartment as $value) : ?>
                        <?php if (intval($value->a_id) == $_SESSION['user_a_id']) : ?>
                          <?php echo '<option selected value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                        <?php else : ?>
                          <?php echo '<option value=' . $value->a_id . '>' . $value->a_name . '</option>' ?>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div id="listDiv"></div>
<?php endif ?>
<script>
  loadList();
  <?php if (!isset($_SESSION['a_ses']) && $_SESSION['user_role'] == 2 && count($_SESSION['a_id']) > 1) : ?>
    getA_SetForm();
  <?php endif ?>
  $('#newBtn').click(function(e) {
    e.preventDefault();
    $.ajax({
      method: "post",
      url: 'Apartment/getAddForm'
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
    });
  });

  function loadList() {
    var formData = {};
    $('[name^="inputValue"]').each(function() {
      if (this.value != '') {
        formData[this.id] = this.value;
      }
    });
    console.log(formData);
    $.ajax({
      url: appRoot + 'Analysis/getReveuneList',
      method: 'post',
      data: formData
    }).done(function(returnedData) {
      $('#listDiv').html(returnedData.html);
    })
  }

  function getA_SetForm() {
    $.ajax({
      method: "post",
      url: 'home/getA_SetForm',
    }).done(function(returnData) {
      $('#mainModalTitle').html(returnData.title);
      $('#mainModalBody').html(returnData.body);
      $('#mainModalFooter').html(returnData.footer);
      $('#mainModal').modal();
      console.log(returnData.data);
      // $('#a_name').prop('disabled', false);
      // $('#a_adds').prop('disabled', false);
      // $('#a_povince_id').prop('disabled', false);
      // $('#a_amphure_id').prop('disabled', false);
      // $('#a_district_id').prop('disabled', false);
      // $('#a_phone').prop('disabled', false);
      // $('#iframe').prop('disabled', false);
    });
  }

  function chageApartment() {
    console.log('เข้า');
    $('#filterYear').val(null);
  }

  function chageMonth() {
    loadList();
  }
</script>