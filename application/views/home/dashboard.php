<!-- <h1>Power Data</h1> -->
<!-- <?php
        // print_r($power_meter);
        // ตรวจสอบว่ามีข้อมูลใน $powerdata หรือไม่ก่อนที่จะแสดงผล
        // if (!empty($power_meter)) {
        //     // วนลูปแสดงข้อมูลที่ได้รับจาก API
        //     foreach ($power_meter as $item) {
        //         echo "<p>id: " . $item->p_id . ", ใช้งานรวม: " . $item->p_kwh . "</p>";
        //         // แสดงข้อมูลแต่ละส่วนของข้อมูลที่ได้รับจาก API ตามที่ต้องการ
        //     }
        // } else {
        //     echo "<p>No data available.</p>";
        // }
        ?> -->

<head>
    <style>
        /* Custom CSS for drop shadow */
        .custom-card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            /* Adjust the values as needed */
        }
    </style>
</head>


<div class="col-lg-12 col-xlg-9 col-md-12">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <i class="mdi mdi-water text-left" style="font-size:60px; color: #699BF7;"></i>
                        </div>
                        <div class="col-10">
                            <div class="row  justify-content-end align-items-end text-right">
                                <div class="col-12 card-title text-right">
                                    <h3 style="font-weight: bold;">การใช้น้ำในวันนี้</h3>
                                </div>
                                <div class="col-7 text-right card-text">
                                    <h3 style="font-weight:bold;"> <?= round($water_meter, 2) ?>
                                    </h3>
                                </div>
                                <div class="col-5">
                                    <h3>หน่วย</h3>
                                </div>
                                <div class="col-12">
                                    <h5> <?= $pmConfig->a_water_cost ?> บาท : หน่วย</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3><a style="font-weight: bold; ">คิดเป็นเงิน</a> <a style=" color:#00B69B;"> <?= round($water_meter, 2) * $pmConfig->a_water_cost ?> บาท</a></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <i class="mdi mdi-flash text-left" style="font-size:60px;color: #E4A951;"></i>
                        </div>
                        <div class="col-10">
                            <div class="row  justify-content-end align-items-end text-right">
                                <div class="col-12 card-title text-right">
                                    <h3 style="font-weight: bold;">การใช้ไฟฟ้าในวันนี้</h3>
                                </div>
                                <div class="col-7 text-right">
                                    <h3 style="font-weight:bold;"> <?= round($power_meter, 2) ?>
                                    </h3>
                                </div>
                                <div class="col-5">
                                    <h3> หน่วย</h3>
                                </div>
                                <div class="col-12">
                                    <h5> <?= $pmConfig->a_power_cost ?> บาท : หน่วย</ฟ>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3><a style="font-weight: bold; ">คิดเป็นเงิน</a> <a style=" color:#00B69B;"> <?= round($power_meter, 2) * $pmConfig->a_power_cost ?> บาท</a></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <i class="mdi mdi-water text-left" style="font-size:60px; color: #699BF7;"></i>
                        </div>
                        <div class="col-10">
                            <div class="row  justify-content-end align-items-end text-right">
                                <div class="col-12 card-title  text-right">
                                    <h3  style="font-weight: bold;">การใช้น้ำในเดือนนี้</h3>
                                </div>
                                <div class="col-7 text-right">
                                    <h3 style=" font-weight:bold;"> <?= round($water_month, 2) ?>
                                </div>
                                <div class="col-5">
                                    <h3> หน่วย</h3>
                                </div>
                                <div class="col-12">
                                    <h5> <?= $pmConfig->a_water_cost ?> บาท : หน่วย</ฟ>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3><a style="font-weight: bold; ">คิดเป็นเงิน</a> <a style=" color:#00B69B;"> <?= round($water_month * $pmConfig->a_water_cost, 2) ?> บาท</a></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <h1> <i class="mdi mdi-flash text-left" style="color: #E4A951;"></i></h1>
                        </div>
                        <div class="col-10">
                            <div class="row  justify-content-end align-items-end text-right">
                                <div class="col-12 card-title text-right">
                                    <h3 style="font-weight: bold;">การใช้ไฟฟ้าในเดือนนี้</h3>
                                </div>
                                <div class="col-7 text-right card-text">
                                    <h3 style="font-weight:bold;"> <?= round($power_month, 2) ?>
                                </div>
                                <div class="col-5">
                                    <h3>หน่วย</h3>
                                </div>
                                <div class="col-12 card-text">
                                    <h5> <?= $pmConfig->a_power_cost ?> บาท : หน่วย</ฟ>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3><a style="font-weight: bold; ">คิดเป็นเงิน</a> <a style=" color:#00B69B;"> <?= round($power_month * $pmConfig->a_power_cost, 2) ?>บาท</a></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel">
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-body text-right">
                            <div class="form-group">
                                <select class="form-control form-select col-lg-1 col-xlg-2 col-md-2" name="start_year" id="start_year" onchange="changeLineChart()">
                                    <?php
                                    if ($start_year) {
                                        echo '<option selected value="' . $start_year . '">ปี ' . ($start_year + 543) . '</option>';
                                    }
                                    foreach ($filter_year as $ft) {
                                        if ($ft != intval($start_year))
                                            echo '<option value= "' . $ft . '">ปี ' . (intval($ft) + 543) . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="text" id="type" name="type" class="hide">
                                <?php if ($type == 0) : ?>
                                    <button type="button" id="powerButton" class="btn btn-warning">ไฟ</button>
                                    <button type="button" id="waterButton" class="btn btn-outline-primary">น้ำ</button>
                                <?php else : ?>
                                    <button type="button" id="powerButton" class="btn btn-outline-warning">ไฟ</button>
                                    <button type="button" id="waterButton" class="btn btn-info">น้ำ</button>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="lineChartID" style="width:100%;height:400px;"></canvas>
            <!--second tab-->
            <div class="tab-pane" id="settings" role="tabpanel">
                <div class="card-body">
                    <div class="form-group" style="max-width: 300px;">
                        <label for="exampleDropdown">Select an option:</label>
                        <select class="form-control" id="exampleDropdown">
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                    <div class="table-responsive col-md-12 mb-12">
                        <table class="display table table-striped table-bordered  nowrap">
                            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
                            <thead>
                                <tr class="text-center">
                                    <th>ลำดับ</th>
                                    <th>เดือน</th>
                                    <th>น้ำ (หน่วย)</th>
                                    <th>ค่าน้ำ (บาท)</th>
                                    <th>การใช้ไฟฟ้า (วัตต์)</th>
                                    <th>ค่าไฟ (บาท)</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeTab(tabId) {
        // ดึงคอลเล็กชันของทุกแท็บ
        var tabs = document.querySelectorAll('.nav-link');

        // วนลูปทุกรายการและลบคลาส 'active'
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });

        // เพิ่มคลาส 'active' ให้กับแท็บที่ถูกคลิก
        document.querySelector('[href="#' + tabId + '"]').classList.add('active');

        // ดึงคอลเล็กชันของทุกแท็บพานิล
        var tabPanels = document.querySelectorAll('.tab-pane');

        // วนลูปทุกรายการและเพิ่มคลาส 'show' และ 'active' ให้กับแท็บที่ถูกคลิก
        tabPanels.forEach(function(panel) {
            panel.classList.remove('show', 'active');
        });

        // เพิ่มคลาส 'show' และ 'active' ให้กับแท็บที่ถูกคลิก
        document.getElementById(tabId).classList.add('show', 'active');
    }
    document.getElementById('powerButton').addEventListener('click', function() {
        var newValue = 0;
        document.getElementById('type').value = newValue;
        changeLineChart()
    });
    document.getElementById('waterButton').addEventListener('click', function() {
        var newValue = 1;
        document.getElementById('type').value = newValue;
        changeLineChart()
    });
    // var controller = "Home";
    function thaiMonth($m) {
        $months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return $months[$m - 1];
    }
    var chartData = <?php echo json_encode($chart_data); ?>;
    if (chartData) {
        var months = chartData.map(item => item.month);
        var pkwData = chartData.map(item => item.pkw);
        var year = <?php echo json_encode($start_year); ?>;
    } else {
        var months = [];
        var pkwData = [];
    }
    var getLabel = <?php echo json_encode($type); ?>;
    if (getLabel == 0 || getLabel == null) {
        var label = "ปริมาณการใช้ไฟฟ้า"
        var rgb = '#ffa500'
    } else {
        var label = "ปริมาณการใช้น้ำประปา"
        var rgb = 'rgba(75, 192, 192, 1)'
    }
    $('.table').DataTable();
    var lineChart = new Chart($("#lineChartID"), {
        type: 'line',
        data: {
            labels: months.map(thaiMonth),
            datasets: [{
                label: label,
                data: pkwData,
                borderColor: rgb,
                borderWidth: 2,
            }]
        }, // End data  
        options: {
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'เดือน ประจำปี ' + year
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'จำนวนการใช้งาน (หน่วย)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        font: {
                            size: 20
                        }
                    },
                }
            }
        }
    });

    // function loadList() {
    //     $ajax({
    //         url: hostname + 'home/index',
    //         method: 'post',
    //         data: {}
    //     }).done(function(returnData) {
    //         $('')
    //     })
    // }
    // var controller_update ="Updatedata"
    // $('#get_map').click(function() {
    //   // $.ajax({
    //   //   method: "get",
    //   //   url: "http://cloud.sunelectricsupply.co.th/SSmart/Apartment/SS_API.php?function=get_map_id()"
    //   // }).done(function(returnData) {
    //   //   console.log(returnData);
    //   // })

    //   // })

    //   var mapId = $('#mapId').data('map_id');
    //   var water = $('#water').data('water');
    //   var power = $('#power').data('power');
    //   // console.log(water);
    //   // console.log(power);
    //   for (let index = 0; index < mapId.ITEM.length; index++) {
    //     console.log(index);
    //     $.ajax({
    //       method: "post",
    //       url: appRoot + controller + "/add",
    //       data: {
    //         id: mapId.ITEM[index].ID,
    //         emb_id: mapId.ITEM[index].EMB_ID,
    //         addr: mapId.ITEM[index].ADDR,
    //         type: mapId.ITEM[index].TYPE,
    //         loc_id: mapId.ITEM[index].LOC_ID,
    //         ss_label: mapId.ITEM[index].SS_LABEL
    //       }
    //     });
    //   }
    // })
    // $('#get_power').click(function() {
    //   var power = $('#power').data('power');
    //   console.log(power.ITEM);
    //     $.ajax({
    //       method: "post",
    //       url: appRoot +controller_update+ "/Updata_meter",
    //       data: {
    //         p_id: 1,
    //         p_kwh: power.ITEM.KWH,
    //         p_pf: power.ITEM.PF,
    //         p_a_id: 1,
    //       }
    //     });
    // })
    //   setInterval(function() {
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //           var responseData = JSON.parse(this.responseText); // แปลงข้อมูลที่ได้รับเป็น JSON
    //             // displayData(responseData); // เรียกใช้ฟังก์ชัน displayData() เพื่อแสดงผลข้อมูล
    //             console.log(responseData);
    //         }
    //     };
    //     xhttp.open("GET", "http://localhost:8080/smart_apartment/Home/Updata_meter_power", true);
    //     xhttp.send();
    // }, 300000); // เรียกใช้งาน Updata_meter() ทุก 5 นาที

    // function displayData(data) {
    //     // ตัวอย่างการแสดงผลข้อมูลใน Console
    //     console.log(data);

    //     // หรือสร้าง HTML element เพื่อแสดงผลข้อมูลในส่วนต่าง ๆ ของเว็บไซต์ของคุณ
    //     var displayElement = document.getElementById("dataDisplay"); // แสดงผลใน Element ที่มี id เป็น dataDisplay
    //     displayElement.innerHTML = ""; // ล้างข้อมูลที่แสดงอยู่ก่อนหน้า

    //     // สร้าง HTML string เพื่อแสดงข้อมูล
    //     var html = "<ul>";
    //     for (var key in data) {
    //         html += "<li>" + key + ": " + data[key] + "</li>";
    //     }
    //     html += "</ul>";

    //     // แทรก HTML string เข้าไปใน Element
    //     displayElement.innerHTML = html;
    // }
</script>