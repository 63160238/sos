<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">ตั้งค่าบิล</h4>
      <form id="billForm">
        <div class="row">
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <label for="tb-fname">ค่าน้ำ / หน่วย</label>
              <input type="Number" class="form-control" name="waterRate" value="<?php echo $getData_partment->a_water_cost; ?>" placeholder="ค่าน้ำ / หน่วย">
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <label for="tb-email">ค่าไฟ / หน่วย</label>
              <input type="Number" class="form-control" name="electricityRate" value="<?php echo $getData_partment->a_power_cost; ?>" placeholder="ค่าไฟ / หน่วย">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <label for="tb-pwd">กำหนดรอบบิล / ทุกวันที่</label>
              <input type="Number" class="form-control" name="billingCycle" value="<?php echo $getData_partment->a_duedate; ?>" placeholder="ทุกวันที่">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <label for="tb-cpwd">เกินกำหนดชำระ / ทุกวันที่</label>
              <input type="Number" class="form-control" name="dueDate" value="<?php echo $getData_partment->a_lateday; ?>" placeholder="ทุกวันที่">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <label for="tb-cpwd">หมายเลยพร้อมเพย์</label>
              <input type="Number" class="form-control" name="promptpay" value="<?php echo $getData_partment->promptpay_no; ?>" placeholder="พร้อมเพย์สำหรับโอนเงิน">
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body">
      <h4 class="card-title">ประเภทห้อง</h4>
      <?php if (is_array($getData)) : ?>
        <?php foreach ($getData as $key => $value) : ?>
          <form class="roomTypeForm" id="roomTypeForm_<?php echo $key; ?>">
            <div class="row" data-ac-type-id="<?php echo $value->ac_type_id; ?>">
              <!-- Rest of your code -->
              <div class="col-md-3">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="roomType" value="<?php echo $value->ac_type_name; ?>" placeholder="ประเภทห้องพัก">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-floating mb-3">
                  <input type="Number" class="form-control" name="roomPrice" value="<?php echo $value->ac_type_cost; ?>" placeholder="ราคา">
                </div>
              </div>
              <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-btn" onclick="removeInput(this)">
                  <span class="far fa-trash-alt" data-icon="ic:baseline-delete-forever" data-inline="false"></span>
                </button>
              </div>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
      <button class="btn btn-success" type="button" onclick="addInput()">
        <span class="icon-plus" data-inline="false"> เพิ่มประเภทห้อง</span>
      </button>
      <!-- <button class="btn btn-primary" type="button" onclick="saveForm()">บันทึก</button> -->
    </div>

    <script>
      // Create a template outside the loop
      var formTemplate = document.querySelector('.roomTypeForm').cloneNode(true);

      function addInput() {
        // Clone the template to create a new row
        var newRow = formTemplate.cloneNode(true);

        // Clear the input values in the new row
        var inputs = newRow.querySelectorAll('input');
        inputs.forEach(function(input) {
          input.value = '';
        });

        // Generate a new ac_type_id for the new row
        var newAcTypeId = generateUniqueAcTypeId();
        newRow.setAttribute('data-ac-type-id', newAcTypeId);

        // Find the index of the last form to create a unique identifier
        var formIndex = document.querySelectorAll('.roomTypeForm').length;

        // Update IDs of form elements in the new row
        newRow.id = 'roomTypeForm_' + formIndex;

        // Get the reference node (button)
        var referenceNode = document.querySelector('.btn-success');

        // Insert the new row before the button
        referenceNode.parentNode.insertBefore(newRow, referenceNode);

        console.log(newAcTypeId);
      }

      function generateUniqueAcTypeId() {
        // ดึงฟอร์มทั้งหมดที่มีอยู่และค้นหา ac_type_id ที่สูงที่สุด
        var existingForms = document.querySelectorAll('.roomTypeForm');
        var highestAcTypeId = 0;
        existingForms.forEach(function(form) {
          var acTypeId = parseInt(form.getAttribute('data-ac-type-id'));
          if (!isNaN(acTypeId) && acTypeId > highestAcTypeId) {
            highestAcTypeId = acTypeId;
          }
        });
        // เพิ่มค่า ac_type_id ทีละหนึ่งสำหรับแถวใหม่
        return highestAcTypeId + 1;
      }

      // ตัวอย่างการใช้งาน

      function removeInput(button) {
        console.log(button);
        // Get the parent element (row) and remove it from the UI
        var row = button.closest('.roomTypeForm');
        // console.log("row");
        var fow_name = row[0].value;
        row.parentNode.removeChild(row);
        // Get the ac_type_id of the row to be deleted
        // var acTypeId = row.getAttribute('data-ac-type-id');
        // console.log('acTypeId:', acTypeId);
        // Send AJAX request to delete the data in the database
        $.ajax({
          method: "POST",
          url: 'Setting/delete_Type', // แทนที่ด้วย URL ของไฟล์หรือเส้นทางที่จะทำการลบข้อมูล
          data: {
            ac_type_name: fow_name
          },
          dataType: 'json',
          success: function(returnData) {
            // Handle success response, if needed
            console.log(returnData);
          },
          error: function(xhr, status, error) {
            // Handle error response, if needed
            console.error(xhr.responseText);
          }
        });
      }

      function saveForm(a_id) {
        // Collect data from all forms
        var formData = [];
        var forms = document.querySelectorAll('.row');
        forms.forEach(function(form) {
          var formValues = {};
          var inputs = form.querySelectorAll('input');
          console.log(inputs);
          formValues['ac_a_id'] = a_id;
          inputs.forEach(function(input) {
            formValues[input.name] = input.value;
          });
          // Add ac_type_id to the form data
          formValues['ac_type_id'] = form.getAttribute('data-ac-type-id');
          formData.push(formValues);
        });
        // Convert formData to a format suitable for sending in an AJAX request
        var postData = {};
        var postData = {};
        var count = 1; // เพิ่มตัวแปร count เพื่อเก็บค่า index ที่ใช้ใน postData
        formData.forEach(function(form, index) {
          if (form.ac_type_id !== null || form.billingCycle) { // เพิ่มเงื่อนไขด้วย ac_type_id
            postData['data[formData][' + count + ']'] = form; // ใช้ตัวแปร count แทน index ใน postData
            count++; // เพิ่มค่า count หลังจากที่ใช้ค่า index ใน postData
          }
        });
        // Send formData to the server using AJAX
        $.ajax({
          method: "post",
          url: 'Setting/add',
          data: postData,
          dataType: 'json',
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
            $('#billForm')[0].reset();
            $('#mainModal').modal('hide');
            loadList();
          }
        });

        // You can remove or modify this console.log statement
        // You can add code here to send formData to the server
      }
    </script>