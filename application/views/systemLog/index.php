<link href="<?=base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">เลือกข้อมูลที่ต้องการการตรวจสอบ</h5>
        <!-- <h6 class="card-subtitle">ระบบจะแสดงรายการขายตามช่วงวันที่กำหนด</h6> -->
        <div class="row">
          <div class="col">
            <label for="">ช่วงวันที่ </label>
            <div class='input-group'>
              <input type='text' class="form-control shawCalRanges" />
              <div class="input-group-append">
                  <span class="input-group-text">
                      <span class="ti-calendar"></span>
                  </span>
              </div>
            </div>
          </div>
          <div class="col">
            <label for="p_category">Action </label>
            <div class="input-group">
              <select class="form-control select2" id="action" name="action" >
                <option value="all">--ทั้งหมด--</option>
                <option value="add">add </option>
                <option value="update">update </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="listDiv"></div>
<script src="<?=base_url()?>assets/node_modules/moment/moment.js"></script>
<script src="<?=base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>

<script>
  var controller = 'SystemLog/';
  startDate = moment().subtract(1, 'month').format('YYYY-MM-DD');
  endDate = moment().format('YYYY-MM-DD');
  loadList(startDate,endDate);
  // Always Show Calendar on Ranges
  $('.shawCalRanges').daterangepicker({
      ranges: {
          'Today': [(moment), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate : moment().subtract(1, 'month'),
      endDate : moment(),
      applyClass: 'btn-sm btn-primary',
      cancelClass: 'btn-sm btn-default',
      locale: {
          format: 'DD/MM/YYYY',
          applyLabel: 'ยืนยัน',
          cancelLabel: 'ยกเลิก',
          fromLabel: 'ตั้งแต่',
          toLabel: 'ถึง',
          daysOfWeek: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
          monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน','กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน','ธันวาคม'],
          firstDay: 1
      },
      alwaysShowCalendars: true,
  }, function(start, end, label) {
    startDate = start.format('YYYY-MM-DD');
    endDate  = end.format('YYYY-MM-DD');
    loadList(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
  });
  $('#action').change(function(e){
    loadList(startDate, endDate);
  })
  function loadList(startDate, endDate){
    $.ajax({
      url: appRoot+controller+'get',
      method : 'post',
      data : {startDate:startDate, endDate:endDate, action:$('#action').val()}
    }).done(function(returnedData){
      $('#listDiv').html(returnedData.html);
    })
  }

</script>
