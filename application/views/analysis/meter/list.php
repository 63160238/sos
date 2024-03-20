<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- <h4 class='card-title'>เลือกปีของประวัติการใช้น้ำ ใช้ไฟ</h4> -->
                <div class=" mt-4">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="input-group">
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <button id="powerButton" type="button" class="btn btn-primary btn-lg btn-block"><i class="mdi mdi-power-plug"> </i> วิเคราะห์มิเตอร์ไฟฟ้าของผู้เช่า</button>
                                </div>
                                <div class="col-6">
                                    <button id="waterButton" type="button" class="btn btn-info btn-lg btn-block"><i class="mdi mdi-water-pump"> </i> วิเคราะห์มิเตอร์น้ำของผู้เช่า</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4 text-left">
                                    <button id="previous" class="btn btn-secondary " style="font-size: 30px;" onclick="previous()">
                                        < </button>
                                </div>
                                <div id="floor" class="col-4 text-center" style="font-size: 30px;">
                                </div>
                                <div class="col-4 text-right btn">
                                    <button id="next" class="btn btn-secondary" style="font-size: 30px;" onclick="next()">></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($info) : ?>
                        <div class="row d-flex justify-content-center">
                            <?php foreach ($info as $value) : ?>
                                <div class="col-4 ">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-6">
                                                    <?= $value['r_name'] ?>
                                                </div>
                                                <?php if ($value['user'] != '') : ?>
                                                    <div class="col-6 text-right">
                                                        ( <?= $value['user'] ?> )
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <canvas class="chart-canvas" style="width:100%;height:400px;" id="chart-<?= $value['r_name'] ?>" data-chart-data="<?= htmlspecialchars(json_encode($value['month'])) ?>"></canvas>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.table').DataTable({
        dom: 'ftp'
    });
    $('#powerButton').click(function() {
        newValue = 0; // Set newValue to 0 when powerButton is clicked
        document.getElementById("floor").innerHTML = '<i class="mdi mdi-power-plug"> </i>' + "วิเคราะห์มิเตอร์ไฟฟ้าของผู้เช่าชั้นที่ " + f;
        updateCharts(); // Call the function to update charts
    });

    $('#waterButton').click(function() {
        newValue = 1; // Set newValue to 1 when waterButton is clicked
        updateCharts(); // Call the function to update charts
        document.getElementById("floor").innerHTML = '<i class="mdi mdi-water-pump"> </i>' + "วิเคราะห์มิเตอร์น้ำของผู้เช่าชั้นที่ " + f;
    });
    showData();

    function updateCharts() {
        if (newValue == 0) {
            document.getElementById("floor").innerHTML = '<i class="mdi mdi-power-plug"> </i>' + "วิเคราะห์มิเตอร์ไฟฟ้าของผู้เช่าชั้นที่ " + f;
        } else {
            document.getElementById("floor").innerHTML = '<i class="mdi mdi-water-pump"> </i>' + "วิเคราะห์มิเตอร์น้ำของผู้เช่าชั้นที่ " + f;
        }   
        $('.chart-canvas').each(function() {
            var data = $(this).data('chart-data');
            var months = data.map(item => item.m_y);
            var pkhw = newValue == 0 ? data.map(item => item.bill_p_khw) : data.map(item => item.bill_w_flow);
            var rgb = newValue == 0 ? '#ffa500' : 'rgba(75, 192, 192, 1)';
            var label = newValue == 0 ? 'ปริมาณการใช้ไฟฟ้า' : 'ปริมาณการใช้น้ำประปา';
            var existingChart = $(this).data('chart');

            if (existingChart) {
                existingChart.destroy();
            }
            var lineChart = new Chart($(this), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: label,
                        data: pkhw,
                        borderColor: rgb,
                        borderWidth: 2,
                    }]
                },
                options: {

                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16
                                }
                            },
                        }
                    }
                }
            });
            $(this).data('chart', lineChart);
        });
    }

    function next() {
        // เพิ่มดัชนีขึ้น 1
        currentIndex++;
        // ตรวจสอบว่าดัชนีเกินขอบเขต array หรือไม่
        if (currentIndex >= floor.length) {
            // ตั้งค่าดัชนีกลับไปที่ 0
            currentIndex = 0;
        }

        // ปิดการใช้งานปุ่ม "ถัดไป"
        // if (currentIndex === floor.length - 1) {
        //     document.getElementById("next").disabled = true;
        //     document.getElementById("next").title = "ไม่มีชั้นถัดไปแล้ว";
        //     document.getElementById("previous").title = "";
        // } else {
        //     document.getElementById("next").disabled = false;
        //     document.getElementById("next").title = "";
        // }
        document.getElementById("previous").disabled = false;
        // แสดงข้อมูล
        showData();
        chageFloor();
    }

    // ฟังก์ชันสำหรับย้อนกลับ
    function previous() {
        // ลดดัชนีลง 1
        currentIndex--;
        // ตรวจสอบว่าดัชนีเป็นจำนวนลบหรือไม่
        if (currentIndex < 0) {
            // ตั้งค่าดัชนีไปที่ดัชนีสุดท้ายของ array
            currentIndex = floor.length - 1;
        }
        // เปิดใช้งานปุ่ม "ถัดไป"
        // if (currentIndex < floor.length - 1) {
        //     document.getElementById("next").disabled = false;
        //     document.getElementById("next").title = "";
        //     document.getElementById("previous").title = "";
        // }
        // if (currentIndex === 0) {
        //     document.getElementById("previous").disabled = true;
        //     document.getElementById("previous").title = "ชั้นสุดท้ายแล้ว";
        // }
        // แสดงข้อมูล
        showData();
        chageFloor();
    }

    function showData() {
        // เขียนข้อมูลลงใน element
        f = floor[currentIndex]['r_floor'];
        if (newValue == 0) {
            document.getElementById("floor").innerHTML = '<i class="mdi mdi-power-plug"> </i>' + "วิเคราะห์มิเตอร์ไฟฟ้าของผู้เช่าชั้นที่ " + f;
        } else {
            document.getElementById("floor").innerHTML = '<i class="mdi mdi-water-pump"> </i>' + "วิเคราะห์มิเตอร์น้ำของผู้เช่าชั้นที่ " + f;
        }
        // loadList();
    }
</script>