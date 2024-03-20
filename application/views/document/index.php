<div class="row">
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
                                <select class="form-control select2" id="a_id" onchange="filterList()" name="inputValue[]">
                                    <option selected disabled value="all">-- กรุณาเลือกหอพัก --</option>
                                    <?php if ($filterApartment) { ?>
                                        <?php foreach ($filterApartment as $key => $value) : ?>
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
                    <?php  } ?>
                    <div class="col-4">
                        <label for="p_category">ระยะเวลาสัญญาเช่า</label>
                        <div class="input-group">
                            <select class="form-control select2" onchange="filterList()" id="contract_period" name="floor">
                                <option selected value="all">--ทั้งหมด--</option>
                                <option value="1">6 เดือน</option>
                                <option value="2">12 เดือน</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="p_category">สถานะการทำสัญญา</label>
                        <div class="input-group">
                            <select class="form-control select2" onchange="filterList()" id="contract_status" name="inputValue[]" onchange=filter()>
                                <option selected value="all">--ทั้งหมด--</option>
                                <option value="1">รอเซ็นสัญญา</option>
                                <option value="2">เซ็นสัญญาเรียบร้อย</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="listDiv"></div>

<script>
    loadlist();
    var formData = new FormData();
    $('#newBtn').click(function(e) {
        e.preventDefault();
        $.ajax({
            method: "post",
            url: appRoot + 'document/getAddForm'
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
            $('#mainModal').modal();
        });
    });

    // uploadButton.addEventListener('click', () => {
    //     console.log("2");
    //     fileInput.click();
    // });  
    function filterList() {
        var filter = {};
        filter['contract_period'] = $('#contract_period').val();
        filter['contract_status'] = $('#contract_status').val();
        filter['a_id'] = $('#a_id').val();
        $.ajax({
            url: 'document/getContract',
            method: 'post',
            data: filter
        }).done(function(returnedData) {
            $('#listDiv').html(returnedData.html);
        })
        console.log(contract_period + " " + contract_status);
    }

    function editForm(id) {
        $.ajax({
            method: "post",
            url: 'document/getEditForm',
            data: {
                id: id,
            }
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
            $('#mainModal').modal();
            $('#print').prop('disabled', false);
        });
    }

    function viewForm(id) {
        $.ajax({
            method: "post",
            url: 'document/getEditForm',
            data: {
                id: id,
                view: 1,
            }
        }).done(function(returnData) {
            $('#mainModalTitle').html(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#mainModalFooter').html(returnData.footer);
            $('#mainModal').modal();
            $('#print').prop('disabled', false);
        });
    }

    function openDialog(id) {
        document.getElementById('upload' + id).click();
    }

    function cancelContract(rid, id) {
        Swal.fire({
            title: 'หมายเลขห้อง ' + rid + '<br>คุณต้องการที่ยกเลิกการแนบสัญญา ใช่หรือไม่ ?',
            text: 'คุณต้องการที่ยกเลิกการแนบสัญญาที่ถูกเซ็นแล้ว ใช่หรือไม่?',
            type: "warning",
            focusConfirm: false,
            allowOutsideClick: false,
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonColor: "#E4E4E4",
            cancelButtonText: "<font style='color:black'>" + 'ภายหลัง' + "</font>",
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    method: 'post',
                    url: 'document/cancelContract',
                    data: {
                        regis_id: id
                    },
                }).done(function(returnedData) {
                    loadlist();
                })
            }
        });
    }

    function uploadFile(uid, rid) {
        Swal.fire({
            title: 'หมายเลขห้อง ' + rid + '<br>คุณต้องการที่จะแนบไฟล์สัญญา ใช่หรือไม่ ?',
            text: 'คุณต้องการที่จะแนบไฟล์สัญญาที่ได้รับการเซ็นแล้ว ใช่หรือไม่?',
            type: "warning",
            focusConfirm: false,
            allowOutsideClick: false,
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonColor: "#E4E4E4",
            cancelButtonText: "<font style='color:black'>" + 'ภายหลัง' + "</font>",
        }).then((result) => {
            if (result.value == true) {
                formData.append('uid', uid);
                formData.append('rid', rid);
                var files = $('#upload' + rid)[0].files;
                formData.append('contract', files[0])
                $.ajax({
                    method: 'post',
                    url: 'document/uploadFile',
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function(returnedData) {
                    swal.fire('อัปโหลดไฟล์สำเร็จ!', 'การอัปโหลดไฟล์ของคุณสำเร็จแล้ว.', 'success');
                    loadlist();
                })
            }
        });
    }

    function loadlist() {
        $.ajax({
            url: 'document/getContract',
            method: 'post',
        }).done(function(returnedData) {
            $('#listDiv').html(returnedData.html);
        })
    }
</script>