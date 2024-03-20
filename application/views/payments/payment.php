<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form id="pdfForm" action="#">
                <div class="text-right">
                    <!-- Add a button to trigger PDF generation -->
                    <button id="generatePdfButton" class="btn btn-info "><i class=" far fa-file-pdf"></i>
                        ดาวน์โหลดเป็น pdf
                    </button>
                </div>
                <div class="form-body">
                    <h3 class="card-title">รายการชำระรวมทั้งสิ้น</h3>
                    <h3>
                        <?= $getData_bill->bill_cost ?><span> บาท</span>
                    </h3>
                    <hr>
                    <div>
                        <div>ห้องพัก<span>
                                <?= $s_room->r_name ?>
                            </span></div>
                        <div>ผู้เช่า <span>
                                <?= $getData_user->prename . " " . $getData_user->fname_th . "" . $getData_user->lname_th ?>
                            </span></div>
                        <?php foreach (P_STATUS as $key => $value) : ?>
                            <?php if ($key == $getData_bill->bill_status) : ?>
                                <div>สถานะการชำระเงิน<span class="bd-highlight <?= $color[$getData_bill->bill_status-1] ?>">
                                        <?= $value ?>
                                    </span></div>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="container mt-4">
                        <div class="card p-3">
                            <table class="table text-center">
                                <!-- Header -->
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ / No.</th>
                                        <th scope="col">รายการ / Free Item</th>
                                        <th scope="col">จำนวนหน่วย / Quantity</th>
                                        <th scope="col">ราคาต่อหน่วย (บาท) / Price (Bath)</th>
                                        <th scope="col">จำนวนเงิน (บาท) / Totals (Bath)</th>
                                    </tr>
                                </thead>
                                <!-- Rows -->
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>ค่าเช่าห้อง</td>
                                        <td>1</td>
                                        <td class="text-right">
                                            <?= $getData->ac_type_cost ?>
                                        </td>
                                        <td class="text-right">
                                            <?= $getData->ac_type_cost ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>ค่าไฟฟ้า</td>
                                        <td>
                                            <?= $getData_bill->bill_p_khw_moth ?>
                                        </td>
                                        <td class="text-right">
                                            <?= $getData_partment->a_power_cost ?>
                                        </td>
                                        <td class="text-right">
                                            <?= $getData_bill->bill_p_khw_moth * $getData_partment->a_power_cost ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>ค่าน้ำ</td>
                                        <td>
                                            <?= $getData_bill->bill_w_flow_month ?>
                                        </td>
                                        <td class="text-right">
                                            <?= $getData_partment->a_water_cost ?>
                                        </td>
                                        <td class="text-right">
                                            <?= $getData_bill->bill_w_flow_month * $getData_partment->a_water_cost ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right">
                        <div style="justify-content: flex-start; align-items: flex-start; gap: 9px; display: inline-flex">
                            <div>วันที่ออกใบแจ้งหนี้</div>
                            <div>:</div>
                            <div>
                                <?= thaiDate($getData_bill->bill_updete_at) ?>
                            </div>
                        </div>
                        <br>
                        <div style="justify-content: flex-start; align-items: flex-start; gap: 9px; display: inline-flex">
                            <div>เกินหนดชำระเงิน</div>
                            <div>:</div>
                            <div>
                                <?= thaiDate($getData_partment->a_lateday) ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
    // Add event listener to the button for PDF generation
    document.getElementById('generatePdfButton').addEventListener('click', function() {
        // Submit the form data using AJAX
        var form = document.getElementById('pdfForm');
        var formData2 = new FormData();
        formData2.append('data',JSON.stringify(formData))
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // เมื่อได้รับข้อมูล PDF จากเซิร์ฟเวอร์
                // สร้าง URL object จากข้อมูลที่ได้รับ

                var pdfURL = URL.createObjectURL(xhr.response);
                console.log(pdfURL);
                // เปิดหน้าต่างใหม่เพื่อแสดง PDF
                window.open(pdfURL);
            }
        };
        // formData.append('content', textContainer);
        var path = "application/views/payments/generate_pdf.php"
        // สร้างคำร้องขอไปยังไฟล์ PHP ที่สร้าง PDF
        xhr.open("POST", path, true);
        xhr.responseType = "blob"; // รับข้อมูลเป็น blob
        xhr.send(formData2);
    });
</script>