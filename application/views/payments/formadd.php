<div class="row">
  <div class="col-6">
    <div class="card">
      <form class="form-material" id="usersForm" autocomplete="off">
        <div class="card-body">
          <div class="modal-body" style="margin: auto;">
            <img id="PromptPay" src="img/PromptPay-logo.jpg" alt="พร้อมเพย์" style="max-width: 250px; margin-bottom: 10px;">
            <div id="qrcode" style="width: 250px; height: 250px;"></div>
            <!-- แสดงหมายเลขพร้อมเพย์ -->
            <div>หมายเลขพร้อมเพย์: <span id="pp-id-show"></span></div>
            <!-- แสดงจำนวนเงิน -->
            <div>จำนวนเงิน: <span id="amount-show">0 บาท</span></div>
            <div>
              <a id="downloadQRCode" href="#" text-left">ดาวน์โหลด QR Code</a>
            </div>
          </div>

        </div>
    </div>
    </form>
  </div>
  <div class="col-6">
    <div class="card">
      <form class="form-material" id="uploadForm" autocomplete="off">
        <div class="card-body">
          <div class="modal-body">
            <form>
              <div class="card-body">
                <div class="modal-body" style="margin: auto;">
                  <form>
                    <div>
                      <label for="fileInput">
                        <img src="assets/images/uplond.png" alt="พร้อมเพย์" style="max-width: 450px; max-height: 450px; margin-bottom: 10px; cursor: pointer;">
                      </label>
                      <input name="inputValue[]" type="file" id="fileInput" style="display: none;" accept="image/*">
                      <button type="button" id="removeImage" style="display: none; position: absolute; top: 0; right: 0;" class="btn btn-danger" onclick="removeImage()">
                        <i class="far fa-times-circle"></i> <!-- ไอคอน FontAwesome ลบ -->
                      </button>
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>

<!-- <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script> -->
<script type="text/javascript" src="js/qrcode.min.js"></script>
<script type="text/javascript" src="js/promptpay.js"></script>
<script>
  // โค้ด QR Code
  var qrcode = new QRCode(document.getElementById("qrcode"), {
    width: 250,
    height: 250,
    correctLevel: QRCode.CorrectLevel.L
  });

  function makeCode() {
    <?php if (is_array($getData)) : ?>
      <?php foreach ($getData as $value) : ?>
        var ppID = <?php echo json_encode($value->promptpay_no); ?>;
        // var amount = 3999.02;
      <?php endforeach; ?>
    <?php endif; ?>
    var amount = parseFloat(<?php echo json_encode($getData_bill->bill_cost); ?>);
    if (!ppID || isNaN(ppID)) {
      ppID = "promptpay.github.io";
    }
    qrcode.makeCode(generatePayload(ppID, amount));
    $("#pp-id-show").html(ppID);

    if (amount > 0.0) {
      $("#amount-show").html(Number(amount.toFixed(2)).toLocaleString() + " บาท");
    } else {
      $("#amount-show").html("");
    }
  }
  // เรียก makeCode() เมื่อหน้าเว็บโหลด
  makeCode();
  // จัดการกับเหตุการณ์เมื่อมีการเลือกไฟล์
  $("#fileInput").change(function() {
    var file = $(this).prop("files")[0];
    // ทำอย่างไรก็ตามที่คุณต้องการกับไฟล์ที่ถูกเลือก
    // เปลี่ยนรูปที่แสดงใน <img> ตามที่อัปโหลด
    if (file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $("#uploadForm img").attr("src", e.target.result);
        $("#removeImage").show(); // แสดงปุ่มลบ
      };
      reader.readAsDataURL(file);
    }
  });
  // จัดการเหตุการณ์คลิกที่ปุ่มลบ
  $("#removeImage").click(function() {
    $("#fileInput").val(""); // ล้างค่า input file
    $("#uploadForm img").attr("src", "assets/images/uplond.png"); // เปลี่ยนรูปเป็นรูปเริ่มต้น
    $(this).hide(); // ซ่อนปุ่มลบ
  });
</script>
<script>
  // เมื่อผู้ใช้คลิกที่ปุ่มดาวน์โหลด
  document.getElementById("downloadQRCode").addEventListener("click", function() {
    // ดึงข้อมูล URL ของรูปภาพจาก QR Code
    var qrCodeURL = document.querySelector("#qrcode img").getAttribute("src");
    // var qrCodeURL = document.querySelector("#qrcode img").getAttribute("src");
    // สร้างลิงก์สำหรับดาวน์โหลด
    // สร้างลิงก์สำหรับดาวน์โหลด
    var downloadLink = document.createElement("a");
    downloadLink.href = qrCodeURL;
    downloadLink.download = "QR_Code.png"; // กำหนดชื่อไฟล์ที่ต้องการให้ดาวน์โหลด
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  });
 

</script>