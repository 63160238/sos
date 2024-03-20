<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
  <link rel="stylesheet" href="../jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
  <script>
    (function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o), m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-33058582-1', 'auto', {
      'name': 'Main'
    });
    ga('Main.send', 'event', 'jquery.Thailand.js', 'GitHub', 'Visit');
  </script>
  <script>
    embedMap();
    document.getElementById("a_adds").addEventListener("input", function () {
      if (/[^a-zA-Z0-9\s\.,/\-ก-๙]/.test(this.value)) {
        // ลบอักขระพิเศษออก
        this.value = this.value.replace(/[^a-zA-Z0-9\s\.,/\-ก-๙]/g, '');
      }
    });

    function embedMap() {
      var mapURL = document.getElementById("iframe").value;
      var mapContainer = document.getElementById("mapContainer");
      mapContainer.innerHTML = mapURL;
    }
  </script>

</head>

<body>
  <div class="form-material">
    <div class="form-group" id="room">
      <label for="id_room">ชื่อหอพัก <span class="text-danger"> *</span></label>
      <input type="text" id="a_name" name="inputValue[]" class="form-control form-control-line" name="inputValue[]"
        value="<?= isset ($getData) ? $getData->a_name : '' ?>" disabled>
    </div>
    <div class="form-group">
      <label for="role">ที่อยู่<span class="text-danger"> *</span></label>
      <input id="a_adds" name="inputValue[]" type="text" class="form-control form-control-line" name="inputValue[]"
        value="<?= isset ($getData) ? $getData->a_adds : '' ?>" disabled>
    </div>
    <form id="demo1" class="demo form-group" style="display:none;" autocomplete="off" uk-grid>
      <div class="uk-width-1-2@m">
        <label>ตำบล / แขวง</label>
        <input name="district" id="a_district" class="uk-input uk-width-1-1" type="text" disabled>
      </div>
      <div class="uk-width-1-2@m">
        <label>อำเภอ / เขต</label>
        <input name="amphoe" id="a_amphure" class="uk-input uk-width-1-1" type="text" disabled>
      </div>
      <div class="uk-width-1-2@m">
        <label>จังหวัด</label>
        <input name="province" id="a_povince" class="uk-input uk-width-1-1" type="text" disabled>
      </div>
      <div class="uk-width-1-2@m">
        <label>รหัสไปรษณีย์</label>
        <input name="zipcode" id="zipcode" class="uk-input uk-width-1-1" type="text" disabled>
      </div>
    </form>
    <br>
    <div class="row col-12">
      <div class="form-group">
        <label for="role">เบอร์โทร<span class="text-danger"> *</span></label>
        <input type="tel" id="a_phone" class="form-control form-control-line" name="inputValue[]"
          value="<?= isset ($getData) ? $getData->a_phone : '' ?>" disabled>
      </div>
      <div class="form-group ml-1 mr-2">
        <label for="role">ชั้น<span class="text-danger"> *</span></label>
        <input type="number" id="a_floor" class="form-control form-control-line" name="inputValue[]"
          value="<?= isset ($getData) ? $getData->a_floor : '' ?>" disabled>
      </div>
      <div class="form-group">
        <label for="role">จำนวนห้อง/ชั้น<span class="text-danger"> *</span></label>
        <input type="number" id="a_room" class="form-control form-control-line" name="inputValue[]"
          value="<?= isset ($getData) ? $getData->a_room : '' ?>" disabled>
      </div>
    </div>
    <label for="role">ตำแหน่งหอพัก<span class="text-danger"> *</span></label>
    <div class="form-group">
      <div class="form-group">
        <textarea disabled id="iframe" oninput="embedMap()" name="inputValue[]"
          placeholder="วาง iframe ของคุณ"><?= isset ($getData) ? $getData->iframe : '' ?></textarea>
      </div>
      <div id="mapContainer"></div>
    </div>
  </div>
  <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> -->

  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/js/uikit.min.js"></script>

  <!-- dependencies for zip mode -->
  <script type="text/javascript" src="../jquery.Thailand.js/jquery.Thailand.js/dependencies/zip.js/zip.js"></script>
  <!-- / dependencies for zip mode -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

  <script type="text/javascript" src="../jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
  <script type="text/javascript"
    src="../jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>

  <script type="text/javascript" src="../jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>

  <script type="text/javascript">
    /******************\
     *     DEMO 1     *
    \******************/
    // demo 1: load database from json. if your server is support gzip. we recommended to use this rather than zip.
    // for more info check README.md  #a_adds
    var a_data;

    $.Thailand({
      database: '../jquery.Thailand.js/jquery.Thailand.js/database/db.json',

      $district: $('#demo1 [name="district"]'),
      $amphoe: $('#demo1 [name="amphoe"]'),
      $province: $('#demo1 [name="province"]'),
      $zipcode: $('#demo1 [name="zipcode"]'),

      onDataFill: function (data) {
        console.info('Data Filled', data);
        a_data = data;
      },

      onLoad: function () {
        console.info('Autocomplete is ready!');
        $('#loader, .demo').toggle();
      }
    });
    // watch on change
    // กำหนดค่า district จากข้อมูลใน $getData
    $('#demo1 [name="district"]').change(function () {
      console.log('ตำบล', this.value);
    });
    $('#demo1 [name="amphoe"]').change(function () {
      console.log('อำเภอ', this.value);
    });
    $('#demo1 [name="province"]').change(function () {
      console.log('จังหวัด', this.value);
    });
    $('#demo1 [name="zipcode"]').change(function () {
      console.log('รหัสไปรษณีย์', this.value);
    });
    <?php if (isset ($getData)): ?>
      $('#demo1 [name="district"]').val('<?= isset ($getData) ? $getData->a_district : '' ?> ');
      $('#demo1 [name="amphoe"]').val('<?= isset ($getData) ? $getData->a_amphure : '' ?>');
      $('#demo1 [name="province"]').val('<?= isset ($getData) ? $getData->a_povince : '' ?>');
      $('#demo1 [name="zipcode"]').val('<?= isset ($getData) ? $getData->zipcode : '' ?>');
      <?php endif ?>
    function saveFormSubmit() {
      $('#fMsg').addClass('text-warning');
      $('#fMsg').text('กำลังดำเนินการ ...');
      console.log(a_data);
      var formData = {};
      formData['a_povince'] = a_data.province
      formData['a_amphure'] = a_data.amphoe
      formData['a_district'] = a_data.district
      formData['zipcode'] = a_data.zipcode
      formData['a_status'] = 1;
      $('[name^="inputValue"]').each(function () {
        formData[this.id] = this.value;
      });
      if (!formData.a_name || !formData.a_adds || !formData.a_phone || !formData.a_floor || !formData.a_room || !formData.a_povince || !formData.a_amphure || !formData.a_district || !formData.a_status || !formData.zipcode) {
        $('#fMsg').addClass('text-danger');
        $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
        !formData.a_name ? $('#a_name').get(0).focus() : '';
        !formData.a_adds ? $('#a_adds').get(0).focus() : '';
        !formData.a_phone ? $('#a_phone').get(0).focus() : '';
        !formData.a_floor ? $('#a_floor').get(0).focus() : '';
        !formData.a_povince ? $('#a_povince').get(0).focus() : '';
        !formData.a_amphure ? $('#a_amphure').get(0).focus() : '';
        !formData.a_district ? $('#a_district').get(0).focus() : '';
        !formData.zipcode ? $('#zipcode').get(0).focus() : '';
        $.toast({
          heading: 'พบข้อผิดพลาด',
          text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
          position: 'top-right',
          loaderBg: '#FF5733',
          icon: 'error',
          hideAfter: 3500,
          stack: 6
        })
        return false;
      }
      if (/^[0]{1}[0-9]{9}$/.test(formData.a_phone)) {
        // ทำสิ่งที่ต้องการกับข้อมูลเบอร์โทรศัพท์ที่ถูกต้อง
        console.log("เบอร์โทรที่ถูกต้อง: " + formData.a_phone);
      } else {
        $.toast({
          heading: 'พบข้อผิดพลาด',
          text: 'กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง',
          position: 'top-right',
          loaderBg: '#FF5733',
          icon: 'error',
          hideAfter: 3500,
          stack: 6
        })
        !formData.a_phone ? $('#a_phone').get(0).focus() : '';
        return false;
        console.log("กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง");
      }
      $.ajax({
        method: "post",
        url: 'Manege_Apartment/add',
        data: formData
      }).done(function (returnData) {
        $.ajax({
          method: "post",
          url: 'Manege_Apartment/add_room',
          data: returnData
        }).done(function (returnData) {
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
            loadList()
          }
        });
      });
    }
    /******************\
     *     DEMO 2     *
    \******************/
    // demo 2: load database from zip. for those who doesn't have server that supported gzip.
    // for more info check README.md
    $.Thailand({
      database: '../jquery.Thailand.js/jquery.Thailand.js/database/db.zip',
      $search: $('#demo2 [name="search"]'),

      onDataFill: function (data) {
        console.log(data)
        var html = '<b>ที่อยู่:</b> ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
        $('#demo2-output').prepend('<div class="uk-alert-warning" uk-alert><a class="uk-alert-close" uk-close></a>' + html + '</div>');
      }

    });

    function edit(a_id) {
      $.ajax({
        method: "post",
        url: 'Manege_Apartment/getEditForm',
        data: {
          a_id: a_id
        }
      }).done(function (returnData) {
        $('#mainModalTitle').html(returnData.title);
        $('#mainModalBody').html(returnData.body);
        $('#mainModalFooter').html(returnData.footer);
        $('#mainModal').modal();
        $('#a_name').prop('disabled', false);
        $('#a_adds').prop('disabled', false);
        $('#a_povince').prop('disabled', false);
        $('#a_amphure').prop('disabled', false);
        $('#a_district').prop('disabled', false);
        $('#zipcode').prop('disabled', false);
        $('#a_phone').prop('disabled', false);
        $('#iframe').prop('disabled', false);
        $('#a_floor').prop('disabled', false);
        $('#a_room').prop('disabled', false);
        $('#a_povince').prop('disabled', false);
        $('#a_amphure').prop('disabled', false);
        $('#a_district').prop('disabled', false);
        $('#zipcode').prop('disabled', false);

      });
    }
  </script>
</body>

</html>