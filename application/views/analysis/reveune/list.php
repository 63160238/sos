    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class='card-title'>เลือกปีของประวัติการใช้น้ำ ใช้ไฟ</h4> -->

                    <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                        <h4 class="text-center " style="font-weight:bold;">
                            เลือกเดือนและปี
                        </h4>
                        <div class=" text-center mt-3 ">
                            <select class="btn btn-info" name="inputValue[]" id="filterYear" onchange="chageMonth()">
                                <?php
                                if ($filterYear) {
                                    echo '<option selected value="' . $filterYear[ 'month' ] . " พ.ศ. " . $filterYear[ 'year' ] . '">' . thaiMonthFull($filterYear[ 'month' ]) . " พ.ศ. " . ($filterYear[ 'year' ] + 543) . '</option>';
                                }
                                if ($filterList) {
                                    foreach ($filterList as $fl) {
                                        if ($filterYear[ 'month' ] != $fl->month || $filterYear[ 'year' ] != $fl->year) {
                                            echo '<option value="' . $fl->month . " พ.ศ. " . $fl->year . '">' . thaiMonthFull($fl->month) . " พ.ศ. " . ($fl->year + 543) . '</option>';
                                        }
                                    }
                                } else {
                                    echo '<option value="0">ไม่มีข้อมูล</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light   mb-3 justify-content-center "
                        style=" background-color: #03a9f3;">
                        <a class="navbar-brand" style="font-size: 20px;font-weight:bold;color:white;"><i
                                class="mdi mdi-chart-arc" style="color: white; font-size:25px;"></i>
                            วิเคราะห์รายรับค่าเช่ารายเดือน ประจำเดือน
                            <?= isset($filterYear) ? thaiMonthFull($filterYear[ 'month' ]) . " พ.ศ. " . ($filterYear[ 'year' ] + 543) : "" ?>
                        </a>
                    </nav>
                    <div class="card shadow-sm p-3 mb-5 bg-white rounded">

                        <div class="row">
                            <div class="col">
                                <div style="width:100%;max-width:700px;max-height: 450px;" id="donutChart"></div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <h2 style="font-size: 20px;"><i class="mdi mdi-check-circle"
                                                        style="color: green;"></i> ผู้เช่าชำระค่าเช่าแล้ว</h2>
                                            </div>
                                            <div class="col-6 text-right">
                                                <h2 style="font-size: 20px;">รวมเป็นเงิน
                                                    <?= $u_paid ?> บาท
                                                </h2>
                                            </div>
                                        </div>
                                        <ul class="list-group">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <button
                                                    style="background-color:#66DA26;border-color:#66DA26;height:20px;"
                                                    disabled></button>จำนวนเงินค่าห้อง
                                                <span class="badge bg-primary rounded-pill">
                                                    <?= $pay[ 'pay_1' ] ?> บาท
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <button
                                                    style="background-color:#11c1e4;border-color:#11c1e4;height:20px;"
                                                    disabled></button>จำนวนเงินค่าน้ำ
                                                <span class="badge bg-primary rounded-pill">
                                                    <?= $pay[ 'pay_3' ] ?> บาท
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <button
                                                    style="background-color:#cf24db;border-color:#cf24db;height:20px;"
                                                    disabled></button>จำนวนเงินค่าไฟฟ้า
                                                <span class="badge bg-primary rounded-pill">
                                                    <?= $pay[ 'pay_2' ] ?> บาท
                                                </span>
                                            </li>
                                        </ul>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <h2 style="font-size: 20px;"><i class="mdi mdi-close-circle"
                                                        style="color: red;"></i> ผู้เช่าค้างชำระค่าเช่า</h2>
                                            </div>
                                            <div class="col-6 text-right">
                                                <h2 style="font-size: 20px;">รวมเป็นเงิน
                                                    <?= $u_overdue ?> บาท
                                                </h2>
                                            </div>
                                        </div>
                                        <h2 class="text-center mt-5">
                                            รวมสุทธิ
                                            <?= $u_paid + $u_overdue ?> บาท
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light  mt-3 justify-content-center "
                        style=" background-color: #03a9f3;">
                        <?php if (count($line) > 1): ?>
                            <a class="navbar-brand" style="font-size: 20px;font-weight:bold; color:white;"><i
                                    class="mdi mdi-chart-bar" style="color: white; font-size:25px;"></i>
                                สรุปรายรับค่าเช่ารายเดือน ประจำเดือน
                                <?= isset($filterYear) ? thaiMonthFull($line[ 0 ][ 'month' ]) . " พ.ศ. " . ($line[ 0 ][ 'year' ] + 543) . " - " . thaiMonthFull($filterYear[ 'month' ]) . " พ.ศ. " . ($filterYear[ 'year' ] + 543) : '' ?>
                            </a>
                        <?php else: ?>
                            <a class="navbar-brand" style="font-size: 20px;font-weight:bold; color:white;"><i
                                    class="mdi mdi-chart-bar " style="color: white; font-size:25px;"></i>
                                สรุปรายรับค่าเช่ารายเดือน ประจำเดือน
                                <?= isset($filterYear) ? thaiMonthFull($filterYear[ 'month' ]) . " พ.ศ. " . $filterYear[ 'year' ] : '' ?>
                            </a>
                        <?php endif; ?>
                    </nav>
                    <div
                        class="card mt-2 shadow-sm p-3 mb-5 bg-white rounded d-flex justify-content-between align-items-center">

                        <div style="width:100%;max-width:1300px;max-height: 450px;" id="chart"></div>

                        <!-- <canvas class="chart-canvas" id="chart"></canvas> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
<script>
    $('.table').DataTable({
        dom: 'ftp'
    });
    var newValue = 0;
    $('#powerButton').click(function () {
        newValue = 0; // Set newValue to 0 when powerButton is clicked
        updateCharts(); // Call the function to update charts
    });

    $('#waterButton').click(function () {
        newValue = 1; // Set newValue to 1 when waterButton is clicked
        updateCharts(); // Call the function to update charts
    });

    function thaiMonth($month) {
        $thaiMonthFull = [
            "ม.ค.",
            "ก.พ.",
            "มี.ค.",
            "เม.ย.",
            "พ.ค.",
            "มิ.ย.",
            "ก.ค.",
            "ส.ค.",
            "ก.ย.",
            "ต.ค.",
            "พ.ย.",
            "ธ.ค."
        ];
        return $thaiMonthFull[$month - 1];
    }
    var paid = <?php echo json_encode($pay); ?>;
    var overDue = <?php echo json_encode($u_overdue); ?>;
    var lineData = <?php echo json_encode($line); ?>;
    if (lineData) {
        var months = lineData.map(item => thaiMonth(item.month) + " " + (parseInt(item.year) + 543));
        var cost = lineData.map(item => item.cost);
    }

    var pieData = [paid['pay_1'], paid['pay_2'], paid['pay_3'], overDue];
    var barColors = [
        "#66DA26",
        "#11c1e4",
        "#cf24db",
        "#ff0000",
    ];
    var labels = ["จำนวนเงินค่าห้อง", 'จำนวนเงินค่าน้ำ', 'จำนวนเงินค่าไฟฟ้า'];
    // var pieChart = new Chart("myChart", {
    //     type: "pie",
    //     data: {
    //         datasets: [{
    //             label: labels,
    //             backgroundColor: barColors,
    //             data: pieData
    //         }]
    //     },
    //     options: {
    //         title: {
    //             display: true,
    //             text: "World Wide Wine Production"
    //         },
    //     }
    // });
    var options = {
        chart: {
            type: 'bar',
        },
        plotOptions: {
            bar: {
                distributed: true
            }
        },
        series: [{
            name: 'รายรับค่าเช่ารายเดือน',
            data: cost,
        }],
        // title: {
        //     text: 'Custom DataLabels',
        //     align: 'center',
        //     floating: true
        // },
        // subtitle: {
        //     text: 'Category Names as DataLabels inside bars',
        //     align: 'center',
        // },
        xaxis: {
            categories: months,
            labels: {
                show: true,
                rotate: -45,
                rotateAlways: true,
                hideOverlappingLabels: true,
                showDuplicates: false,
                trim: false,
                minHeight: 120,
                maxHeight: 120,
                style: {
                    colors: [],
                    fontSize: '12px',
                    fontFamily: 'Helvetica, Arial, sans-serif',
                    fontWeight: 400,
                    cssClass: 'apexcharts-xaxis-label',
                },
                offsetX: 0,
                offsetY: 0,
                format: undefined,
                formatter: undefined,
                datetimeUTC: true,
                datetimeFormatter: {
                    year: 'yyyy',
                    month: "MMM 'yy",
                    day: 'dd MMM',
                    hour: 'HH:mm',
                },
            },

        }
    }

    var chart2 = new ApexCharts(document.querySelector("#chart"), options);
    var options = {
        series: pieData,
        chart: {
            type: 'donut',
        },
        colors: barColors,
        labels: ["จำนวนเงินค่าห้อง", 'จำนวนเงินค่าน้ำ', 'จำนวนเงินค่าไฟฟ้า', 'จำนวนเงินค้างชำระ'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#donutChart"), options);
    chart.render();
    chart2.render();
    // var lineChart = new Chart($("#chart"), {
    //     type: 'line',

    //     data: {
    //         labels: months,
    //         datasets: [{
    //             label: "",
    //             data: cost,
    //             borderColor: 'rgb(255, 204, 0)', // Corrected color format
    //             borderWidth: 2,
    //         }]
    //     },
    //     options: {
    //         plugins: {
    //             legend: {
    //                 labels: {
    //                     font: {
    //                         size: 16
    //                     }
    //                 },
    //                 display: false
    //             }
    //         }
    //     }
    // });
</script>
