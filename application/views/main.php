<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/favicon.png">
    <title>92 Tech :: smart_apartment</title>
    <!-- chartist CSS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="<?= base_url() ?>assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <link href="<?= base_url() ?>dist/css/pages/ecommerce.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>dist/css/style.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>dist/css/custom.min.css" rel="stylesheet">
    <!-- dataTables  -->
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <!-- toast CSS -->
    <link href="<?= base_url() ?>assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="<?= base_url() ?>assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>assets/node_modules/popper/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url() ?>dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url() ?>dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url() ?>dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?= base_url() ?>assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url() ?>dist/js/main.js"></script>
    <script src="<?= base_url() ?>dist/js/custom.min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="<?= base_url() ?>assets/node_modules/raphael/raphael-min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/morrisjs/morris.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--Custom JavaScript -->
    <!-- <script src="<?= base_url() ?>dist/js/ecom-dashboard.js"></script> -->

    <!-- data table -->
    <!-- This is data table -->
    <script src="<?= base_url() ?>assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>assets/index.js"></script>
    <!-- Session-timeout -->
    <script src="<?= base_url() ?>assets/node_modules/session-timeout/jquery.sessionTimeout.min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/session-timeout/session-timeout-init.js"></script>
    <!-- toast noti -->
    <script src="<?= base_url() ?>assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <!-- Sweet-Alert  -->
    <script src="<?= base_url() ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
    <!-- Tinymce CSS -->
    <script src="<?= base_url() ?>assets/node_modules/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.1/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <!-- start - This is for export functionality only -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
</head>
<script>
    var hostname = location.protocol + '//' + window.location.hostname + ":" + location.port + "/smart_apartment/";
</script>

<body class="skin-blue fixed-layout ">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Smart apartment</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?= base_url() ?>">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?= base_url() ?>assets/images/Group 2.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <!-- <img src="<?= base_url() ?>assets/images/Group 2.png" alt="homepage" class="light-logo" /> -->
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                            <!-- dark Logo text -->
                            <img src="<?= base_url() ?>assets/images/Group 3.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                            <img src="<?= base_url() ?>assets/images/logo-light-text.png" class="light-logo"
                                alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <!-- <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li> -->
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                                href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="Search & enter">
                            </form>
                        </li> -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <?php if ($_SESSION[ 'user_role' ] == 2): ?>
                            <li class="nav-item dropdown u-pro">
                                <?php if (isset ($_SESSION[ 'a_id' ])) { ?>
                                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic fs-5"
                                        onclick="showChangeDormMenu()" data-toggle="dropdown" data-bs-display="static"
                                        aria-haspopup="true" aria-expanded="false">
                                        <div class="row g-0 p-0 ">
                                            <div>
                                                <div style="line-height: 41px;">
                                                    <?php for ($i = 0; $i < count($_SESSION[ 'a_name' ]); $i++): ?>
                                                        <?php if ($_SESSION[ 'user_a_id' ] == $_SESSION[ 'a_name' ][ $i ]->a_id): ?>
                                                            <?php echo $_SESSION[ 'a_name' ][ $i ]->a_name; ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>

                                                    <i class="fas fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu animated flipInY" style="right: 0; width:100px">
                                        <div id="changeDormMenu" class="dropdown-menu text-center">
                                            <label for="">เลือกหอพัก</label><br>
                                            <a href="#">
                                                <select id="selectDorm" class=" btn btn-info" name="state"
                                                    style="right: 0; width:120px">
                                                    <?php for ($i = 0; $i < count($_SESSION[ 'a_name' ]); $i++): ?>
                                                        <option value="<?= $_SESSION[ 'a_id' ][ $i ] ?>" <?php if ($_SESSION[ 'a_id' ][ $i ] == $_SESSION[ 'user_a_id' ])
                                                                  echo 'selected' ?>>
                                                            <?= $_SESSION[ 'a_name' ][ $i ]->a_name ?>
                                                        </option>
                                                    <?php endfor ?>
                                                </select>
                                            </a>
                                        </div>
                                    </div>
                                    <script>
                                        function showChangeDormMenu() {
                                            document.getElementById("changeDormMenu").style.display = "block";
                                            document.getElementById("manageDormMenu").style.display = "none";
                                        }

                                        function showManageDormMenu() {
                                            document.getElementById("changeDormMenu").style.display = "none";
                                            document.getElementById("manageDormMenu").style.display = "block";
                                        }
                                        $(document).ready(function () {
                                            $('#selectDorm').click(function (event) {
                                                event.stopPropagation();
                                            });
                                        });
                                        $(document).ready(function () {
                                            // Attach change event to #selectDorm
                                            console.log(location.pathname);
                                            $('#selectDorm').on('change', function () {
                                                var formData = {
                                                    selectedDorm: $(this).val()
                                                };
                                                $.ajax({
                                                    method: "post",
                                                    url: 'Login/lond_sec',
                                                    data: formData,
                                                    success: function (returnData) {
                                                        location.reload();
                                                    },
                                                    error: function (xhr, status, error) {
                                                        $.ajax({
                                                            method: "post",
                                                            url: '../Login/lond_sec',
                                                            data: formData,
                                                            success: function (returnData) {
                                                                location.reload();
                                                            },
                                                            error: function (xhr, status, error) {

                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                        function saveFormSubmit() {
                                            $('#fMsg').addClass('text-warning');
                                            $('#fMsg').text('กำลังดำเนินการ ...');
                                            var formData = {};
                                            formData['a_status'] = 1;
                                            $('[name^="inputValue"]').each(function () {
                                                formData[this.id] = this.value;
                                            });
                                            console.log(formData);
                                            // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
                                            //   $('#fMsg').addClass('text-danger');
                                            //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
                                            //   !formData.username ? $('#username').get(0).focus() : '';
                                            //   !formData.role ? $('#role').get(0).focus() : '';
                                            //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
                                            //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
                                            //   !formData.prename ? $('#prename').get(0).focus() : '';
                                            //   !formData.id_card ? $('#id_card').get(0).focus() : '';

                                            //   $.toast({
                                            //     heading: 'พบข้อผิดพลาด',
                                            //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                                            //     position: 'top-right',
                                            //     loaderBg: '#FF5733',
                                            //     icon: 'error',
                                            //     hideAfter: 3500,
                                            //     stack: 6
                                            //   })
                                            //   return false;
                                            // }
                                            // console.log('good');
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
                                                    console.log(returnData);
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
                                                        loadList();
                                                    }
                                                });
                                            });
                                        }

                                        function saveeEditFormSubmit(a_id) {
                                            $('#fMsg').addClass('text-warning');
                                            $('#fMsg').text('กำลังดำเนินการ ...');
                                            var formData = {};
                                            formData['a_id'] = a_id;
                                            formData['a_status'] = 1;
                                            $('[name^="inputValue"]').each(function () {
                                                if (this.id != 'a_room' && this.id != 'a_floor') {
                                                    formData[this.id] = this.value;
                                                }
                                            });
                                            console.log(formData);
                                            // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
                                            //   $('#fMsg').addClass('text-danger');
                                            //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
                                            //   !formData.username ? $('#username').get(0).focus() : '';
                                            //   !formData.role ? $('#role').get(0).focus() : '';
                                            //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
                                            //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
                                            //   !formData.prename ? $('#prename').get(0).focus() : '';
                                            //   !formData.id_card ? $('#id_card').get(0).focus() : '';

                                            //   $.toast({
                                            //     heading: 'พบข้อผิดพลาด',
                                            //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                                            //     position: 'top-right',
                                            //     loaderBg: '#FF5733',
                                            //     icon: 'error',
                                            //     hideAfter: 3500,
                                            //     stack: 6
                                            //   })
                                            //   return false;
                                            // }
                                            // console.log('good');
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/edit',
                                                data: formData
                                            }).done(function (returnData) {
                                                // console.log(returnData);
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
                                                    $('#roomForm')[0].reset();
                                                    $('#mainModal').modal('hide');
                                                    loadList();
                                                }
                                            });
                                        }

                                        function changeStatus(a_id, status) {
                                            $.ajax({
                                                method: "POST",
                                                url: 'Manege_Apartment/updateStatus',
                                                data: {
                                                    a_id: a_id,
                                                    a_status: status
                                                }
                                            }).done(function (returnData) {
                                                if (returnData.status == 1) {
                                                    loadList();
                                                    $.toast({
                                                        heading: 'สำเร็จ',
                                                        text: returnData.msg,
                                                        position: 'top-right',
                                                        icon: 'success',
                                                        hideAfter: 3500,
                                                        stack: 6
                                                    });
                                                } else {
                                                    $.toast({
                                                        heading: 'สำเร็จ',
                                                        text: returnData.msg,
                                                        position: 'top-right',
                                                        icon: 'error',
                                                        hideAfter: 3500,
                                                        stack: 6
                                                    });
                                                }
                                            })
                                        }
                                        function edit_model(a_id) {
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/getEditForm',
                                                data: {
                                                    a_id: a_id
                                                },
                                                success: function (returnData) {
                                                    $('#mainModalTitle').html(returnData.title);
                                                    $('#mainModalBody').html(returnData.body);
                                                    $('#mainModalFooter').html(returnData.footer);
                                                    $('#mainModal').modal();
                                                    $('#a_name').prop('disabled', false);
                                                    $('#a_adds').prop('disabled', false);
                                                    $('#a_povince_id').prop('disabled', false);
                                                    $('#a_amphure_id').prop('disabled', false);
                                                    $('#a_district_id').prop('disabled', false);
                                                    $('#a_phone').prop('disabled', false);
                                                    $('#iframe').prop('disabled', false);
                                                    $('#a_floor').prop('disabled', true);
                                                    $('#a_room').prop('disabled', true);
                                                    $('#a_povince').prop('disabled', false);
                                                    $('#a_amphure').prop('disabled', false);
                                                    $('#a_district').prop('disabled', false);
                                                    $('#zipcode').prop('disabled', false);
                                                },
                                                error: function (xhr, status, error) {
                                                    $.ajax({
                                                        method: "post",
                                                        url: '../Manege_Apartment/getEditForm',
                                                        data: {
                                                            a_id: a_id
                                                        },
                                                        success: function (returnData) {
                                                            $('#mainModalTitle').html(returnData.title);
                                                            $('#mainModalBody').html(returnData.body);
                                                            $('#mainModalFooter').html(returnData.footer);
                                                            $('#mainModal').modal();
                                                            $('#a_name').prop('disabled', false);
                                                            $('#a_adds').prop('disabled', false);
                                                            $('#a_povince_id').prop('disabled', false);
                                                            $('#a_amphure_id').prop('disabled', false);
                                                            $('#a_district_id').prop('disabled', false);
                                                            $('#a_phone').prop('disabled', false);
                                                            $('#iframe').prop('disabled', false);
                                                            $('#a_floor').prop('disabled', true);
                                                            $('#a_room').prop('disabled', true);
                                                            $('#a_povince').prop('disabled', false);
                                                            $('#a_amphure').prop('disabled', false);
                                                            $('#a_district').prop('disabled', false);
                                                            $('#zipcode').prop('disabled', false);
                                                        },
                                                        error: function (xhr, status, error) {

                                                        }
                                                    });
                                                }
                                            });
                                        }
                                        function seting(a_id) {
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/getSetForm',
                                                data: {
                                                    a_id: a_id
                                                }
                                            }).done(function (returnData) {
                                                $('#mainModalTitle').html(returnData.title);
                                                $('#mainModalBody').html(returnData.body);
                                                $('#mainModalFooter').html(returnData.footer);
                                                $('#mainModal').modal();
                                                $('#r_name').prop('disabled', false); // เปิด disabled
                                                $('#r_u_id').prop('disabled', false); // เปิด disabled
                                                $('#r_type').prop('disabled', false); // เปิด disabled
                                                $('#pay_status').prop('disabled', false); // เปิด disabled
                                            });
                                        }

                                        function get_model(a_id) {
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/getEditForm',
                                                data: {
                                                    a_id: a_id
                                                },
                                                success: function (returnData) {
                                                    $('#mainModalTitle').html(returnData.title);
                                                    $('#mainModalBody').html(returnData.body);
                                                    $('#mainModalFooter').html(returnData.footer);
                                                    $('#mainModal').modal();
                                                    $('#a_name').prop('disabled', true);
                                                    $('#a_adds').prop('disabled', true);
                                                    $('#a_povince_id').prop('disabled', true);
                                                    $('#a_amphure_id').prop('disabled', true);
                                                    $('#a_district_id').prop('disabled', true);
                                                    $('#a_phone').prop('disabled', true);
                                                    $('#iframe').prop('disabled', true);
                                                    $('#a_floor').prop('disabled', true);
                                                    $('#a_room').prop('disabled', true);
                                                },
                                                error: function (xhr, status, error) {
                                                    $.ajax({
                                                        method: "post",
                                                        url: '../Manege_Apartment/getEditForm',
                                                        data: {
                                                            a_id: a_id
                                                        },
                                                        success: function (returnData) {
                                                            $('#mainModalTitle').html(returnData.title);
                                                            $('#mainModalBody').html(returnData.body);
                                                            $('#mainModalFooter').html(returnData.footer);
                                                            $('#mainModal').modal();
                                                            $('#a_name').prop('disabled', true);
                                                            $('#a_adds').prop('disabled', true);
                                                            $('#a_povince_id').prop('disabled', true);
                                                            $('#a_amphure_id').prop('disabled', true);
                                                            $('#a_district_id').prop('disabled', true);
                                                            $('#a_phone').prop('disabled', true);
                                                            $('#iframe').prop('disabled', true);
                                                            $('#a_floor').prop('disabled', true);
                                                            $('#a_room').prop('disabled', true);
                                                        },
                                                        error: function (xhr, status, error) {

                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    </script>


                                <?php } else { ?>
                                    <div class="nav-link waves-effect waves-dark profile-pic fs-5" onclick="getLoginForm()">
                                        <?= lang('login') ?>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php endif ?>
                        <?php if ($_SESSION[ 'user_role' ] == 2): ?>
                            <li class="nav-item dropdown u-pro ">
                                <?php if (isset ($_SESSION[ 'a_id' ])) { ?>
                                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic pl-1"
                                        onclick="showManageDormMenu()" data-toggle="dropdown" data-bs-display="static"
                                        aria-haspopup="true" aria-expanded="false">
                                        <div class="row m-0 p-0">
                                            <div>
                                                <div style="line-height: 41px;">
                                                    <i class="fas fa-cog"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu animated flipInY" style="right: 0; width:100px">
                                        <div id="manageDormMenu" class="dropdown-menu">
                                            <a href="#" onclick="get_model(<?= $_SESSION[ 'user_a_id' ] ?>)"
                                                class="dropdown-item"><i class="fas fa-eye"></i> ดูข้อมูลหอพัก</a>
                                            <a href="#" onclick="edit_model(<?= $_SESSION[ 'user_a_id' ] ?>)"
                                                class="dropdown-item"><i class="icon-pencil"></i> แก้ไขข้อมูลหอพัก</a>
                                            <a href="#" class="dropdown-item"
                                                onclick="seting(<?= $_SESSION[ 'user_a_id' ] ?>)"><i class="fas fa-cogs"></i>
                                                ตั่งค่าหอพัก</a>
                                        </div>
                                    </div>
                                    <script>
                                        function showChangeDormMenu() {
                                            document.getElementById("changeDormMenu").style.display = "block";
                                            document.getElementById("manageDormMenu").style.display = "none";
                                        }

                                        function showManageDormMenu() {
                                            document.getElementById("changeDormMenu").style.display = "none";
                                            document.getElementById("manageDormMenu").style.display = "block";
                                        }
                                        $(document).ready(function () {
                                            $('#selectDorm').click(function (event) {
                                                event.stopPropagation();
                                            });
                                        });
                                        $(document).ready(function () {
                                            // Attach change event to #selectDorm
                                            console.log(location.pathname);
                                            $('#selectDorm').on('change', function () {
                                                var formData = {
                                                    selectedDorm: $(this).val()
                                                };
                                                $.ajax({
                                                    method: "post",
                                                    url: 'Login/lond_sec',
                                                    data: formData,
                                                    success: function (returnData) {
                                                        location.reload();
                                                    },
                                                    error: function (xhr, status, error) {
                                                        $.ajax({
                                                            method: "post",
                                                            url: '../Login/lond_sec',
                                                            data: formData,
                                                            success: function (returnData) {
                                                                location.reload();
                                                            },
                                                            error: function (xhr, status, error) {

                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                        function saveFormSubmit() {
                                            $('#fMsg').addClass('text-warning');
                                            $('#fMsg').text('กำลังดำเนินการ ...');
                                            var formData = {};
                                            formData['a_status'] = 1;
                                            $('[name^="inputValue"]').each(function () {
                                                formData[this.id] = this.value;
                                            });
                                            console.log(formData);
                                            // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
                                            //   $('#fMsg').addClass('text-danger');
                                            //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
                                            //   !formData.username ? $('#username').get(0).focus() : '';
                                            //   !formData.role ? $('#role').get(0).focus() : '';
                                            //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
                                            //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
                                            //   !formData.prename ? $('#prename').get(0).focus() : '';
                                            //   !formData.id_card ? $('#id_card').get(0).focus() : '';

                                            //   $.toast({
                                            //     heading: 'พบข้อผิดพลาด',
                                            //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                                            //     position: 'top-right',
                                            //     loaderBg: '#FF5733',
                                            //     icon: 'error',
                                            //     hideAfter: 3500,
                                            //     stack: 6
                                            //   })
                                            //   return false;
                                            // }
                                            // console.log('good');
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
                                                    console.log(returnData);
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
                                                        $('#roomForm')[0].reset();
                                                        $('#mainModal').modal('hide');
                                                        loadList();
                                                    }
                                                });
                                            });
                                        }

                                        function saveeEditFormSubmit(a_id) {
                                            $('#fMsg').addClass('text-warning');
                                            $('#fMsg').text('กำลังดำเนินการ ...');
                                            var formData = {};
                                            formData['a_id'] = a_id;
                                            formData['a_status'] = 1;
                                            $('[name^="inputValue"]').each(function () {
                                                if (this.id != 'a_room' && this.id != 'a_floor') {
                                                    formData[this.id] = this.value;
                                                }
                                            });
                                            console.log(formData);
                                            // // if (!formData.id_card || !formData.prename || !formData.fname_th || !formData.lname_th || !formData.role || !formData.username) {
                                            //   $('#fMsg').addClass('text-danger');
                                            //   $('#fMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
                                            //   !formData.username ? $('#username').get(0).focus() : '';
                                            //   !formData.role ? $('#role').get(0).focus() : '';
                                            //   !formData.lname_th ? $('#lname_th').get(0).focus() : '';
                                            //   !formData.fname_th ? $('#fname_th').get(0).focus() : '';
                                            //   !formData.prename ? $('#prename').get(0).focus() : '';
                                            //   !formData.id_card ? $('#id_card').get(0).focus() : '';

                                            //   $.toast({
                                            //     heading: 'พบข้อผิดพลาด',
                                            //     text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                                            //     position: 'top-right',
                                            //     loaderBg: '#FF5733',
                                            //     icon: 'error',
                                            //     hideAfter: 3500,
                                            //     stack: 6
                                            //   })
                                            //   return false;
                                            // }
                                            // console.log('good');
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/edit',
                                                data: formData
                                            }).done(function (returnData) {
                                                // console.log(returnData);
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
                                                    $('#roomForm')[0].reset();
                                                    $('#mainModal').modal('hide');
                                                    loadList();
                                                }
                                            });
                                        }

                                        function changeStatus(a_id, status) {
                                            $.ajax({
                                                method: "POST",
                                                url: 'Manege_Apartment/updateStatus',
                                                data: {
                                                    a_id: a_id,
                                                    a_status: status
                                                }
                                            }).done(function (returnData) {
                                                if (returnData.status == 1) {
                                                    loadList();
                                                    $.toast({
                                                        heading: 'สำเร็จ',
                                                        text: returnData.msg,
                                                        position: 'top-right',
                                                        icon: 'success',
                                                        hideAfter: 3500,
                                                        stack: 6
                                                    });
                                                } else {
                                                    $.toast({
                                                        heading: 'สำเร็จ',
                                                        text: returnData.msg,
                                                        position: 'top-right',
                                                        icon: 'error',
                                                        hideAfter: 3500,
                                                        stack: 6
                                                    });
                                                }
                                            })
                                        }
                                        function edit_model(a_id) {
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/getEditForm',
                                                data: {
                                                    a_id: a_id
                                                },
                                                success: function (returnData) {
                                                    $('#mainModalTitle').html(returnData.title);
                                                    $('#mainModalBody').html(returnData.body);
                                                    $('#mainModalFooter').html(returnData.footer);
                                                    $('#mainModal').modal();
                                                    $('#a_name').prop('disabled', false);
                                                    $('#a_adds').prop('disabled', false);
                                                    $('#a_povince').prop('disabled', false);
                                                    $('#a_amphure').prop('disabled', false);
                                                    $('#a_district').prop('disabled', false);
                                                    $('#a_phone').prop('disabled', false);
                                                    $('#iframe').prop('disabled', false);
                                                    $('#a_floor').prop('disabled', true);
                                                    $('#a_room').prop('disabled', true);
                                                },
                                                error: function (xhr, status, error) {
                                                    $.ajax({
                                                        method: "post",
                                                        url: '../Manege_Apartment/getEditForm',
                                                        data: {
                                                            a_id: a_id
                                                        },
                                                        success: function (returnData) {
                                                            $('#mainModalTitle').html(returnData.title);
                                                            $('#mainModalBody').html(returnData.body);
                                                            $('#mainModalFooter').html(returnData.footer);
                                                            $('#mainModal').modal();
                                                            $('#a_name').prop('disabled', false);
                                                            $('#a_adds').prop('disabled', false);
                                                            $('#a_povince_id').prop('disabled', false);
                                                            $('#a_amphure_id').prop('disabled', false);
                                                            $('#a_district_id').prop('disabled', false);
                                                            $('#a_phone').prop('disabled', false);
                                                            $('#iframe').prop('disabled', false);
                                                            $('#a_floor').prop('disabled', true);
                                                            $('#a_room').prop('disabled', true);
                                                            $('#a_povince').prop('disabled', false);
                                                            $('#a_amphure').prop('disabled', false);
                                                            $('#a_district').prop('disabled', false);
                                                        },
                                                        error: function (xhr, status, error) {

                                                        }
                                                    });
                                                }
                                            });
                                        }
                                        function seting(a_id) {
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/getSetForm',
                                                data: {
                                                    a_id: a_id
                                                }
                                            }).done(function (returnData) {
                                                $('#mainModalTitle').html(returnData.title);
                                                $('#mainModalBody').html(returnData.body);
                                                $('#mainModalFooter').html(returnData.footer);
                                                $('#mainModal').modal();
                                                $('#r_name').prop('disabled', false); // เปิด disabled
                                                $('#r_u_id').prop('disabled', false); // เปิด disabled
                                                $('#r_type').prop('disabled', false); // เปิด disabled
                                                $('#pay_status').prop('disabled', false); // เปิด disabled
                                            });
                                        }

                                        function get_model(a_id) {
                                            $.ajax({
                                                method: "post",
                                                url: 'Manege_Apartment/getEditForm',
                                                data: {
                                                    a_id: a_id
                                                },
                                                success: function (returnData) {
                                                    $('#mainModalTitle').html(returnData.title);
                                                    $('#mainModalBody').html(returnData.body);
                                                    $('#mainModalFooter').html(returnData.footer);
                                                    $('#mainModal').modal();
                                                    $('#a_name').prop('disabled', true);
                                                    $('#a_adds').prop('disabled', true);
                                                    $('#a_povince_id').prop('disabled', true);
                                                    $('#a_amphure_id').prop('disabled', true);
                                                    $('#a_district_id').prop('disabled', true);
                                                    $('#a_phone').prop('disabled', true);
                                                    $('#iframe').prop('disabled', true);
                                                    $('#a_floor').prop('disabled', true);
                                                    $('#a_room').prop('disabled', true);
                                                },
                                                error: function (xhr, status, error) {
                                                    $.ajax({
                                                        method: "post",
                                                        url: '../Manege_Apartment/getEditForm',
                                                        data: {
                                                            a_id: a_id
                                                        },
                                                        success: function (returnData) {
                                                            $('#mainModalTitle').html(returnData.title);
                                                            $('#mainModalBody').html(returnData.body);
                                                            $('#mainModalFooter').html(returnData.footer);
                                                            $('#mainModal').modal();
                                                            $('#a_name').prop('disabled', true);
                                                            $('#a_adds').prop('disabled', true);
                                                            $('#a_povince_id').prop('disabled', true);
                                                            $('#a_amphure_id').prop('disabled', true);
                                                            $('#a_district_id').prop('disabled', true);
                                                            $('#a_phone').prop('disabled', true);
                                                            $('#iframe').prop('disabled', true);
                                                            $('#a_floor').prop('disabled', true);
                                                            $('#a_room').prop('disabled', true);
                                                        },
                                                        error: function (xhr, status, error) {

                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    </script>


                                <?php } else { ?>
                                    <div class="nav-link waves-effect waves-dark profile-pic fs-5" onclick="getLoginForm()">
                                        <?= lang('login') ?>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php endif ?>
                        <li class="nav-item dropdown u-pro">
                            <?php if (isset ($_SESSION[ 'user_fullname' ])) { ?>
                                <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic fs-5" href=""
                                    data-toggle="dropdown" data-bs-display="static" aria-haspopup="true"
                                    aria-expanded="false">
                                    <!-- <table>
                                        <tr>
                                            <td class="hidden-md-down pt-0 py-0">
                                                <h5><?php echo $_SESSION[ 'user_fullname' ]; ?><h5>
                                                        <span class="float-end" style="font-size: 14px;">
                                                            <?php if ($_SESSION[ 'user_role' ] == 3) {
                                                                echo 'supperadmin';
                                                            } else if ($_SESSION[ 'user_role' ] == 2) {
                                                                echo 'admin';
                                                            } else {
                                                                echo $_SESSION[ 'room' ];
                                                            } ?>
                                                        </span>
                                            </td>
                                            <td class="pb-1"><img src="<?= base_url() ?>assets/images/iconuser.png" alt="user" class=""></td>
                                        </tr>
                                    </table> -->
                                    <div class="row g-0">
                                        <div class="col text-right">
                                            <div style="line-height: 28px;">
                                                <?php echo $_SESSION[ 'user_fullname' ]; ?>
                                            </div>
                                            <div class="float-end" style="font-size: 14px; line-height: 20px;">
                                                <?php if ($_SESSION[ 'user_role' ] == 3) {
                                                    echo 'superadmin';
                                                } else if ($_SESSION[ 'user_role' ] == 2) {
                                                    echo 'admin';
                                                } else {
                                                    echo "ห้อง" . " " . $_SESSION[ 'room' ];
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <img src="<?= base_url() ?>assets/images/iconuser.png" alt="user" class="">
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu animated flipInY" style="right: 0; width:100px">
                                    <a class="dropdown-item" onclick="changePass(<?= $_SESSION[ 'user_id' ] ?>)"><i
                                            class="mdi mdi-key-change"></i>
                                        เปลี่ยนรหัสผ่าน</a>
                                    <a href="<?= base_url() ?>Logout" class="dropdown-item"><i class="mdi mdi-logout"></i>
                                        Logout</a>
                                </div>
                            <?php } else { ?>
                                <div class="nav-link waves-effect waves-dark profile-pic fs-5" onclick="getLoginForm()">
                                    <?= lang('login') ?>
                                </div>
                            <?php } ?>
                        </li>

                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- <li>
                            <div class="hide-menu text-center">
                                <div id="eco-spark"></div>
                                <small>TOTAL EARNINGS - JUNE 2020</small>
                                <h4>$2,478.00</h4>
                            </div>
                        </li> -->
                        <!-- <li> <a class="waves-effect waves-dark" href="<?= base_url() ?>Home" aria-expanded="false"><i class=" fas fa-home"></i><span class="hide-menu">หน้าหลัก</span></a></li> -->
                        <?php if ($_SESSION[ 'user_role' ] == 1): ?>
                            <li> <a class="waves-effect waves-dark" href="<?= base_url() ?>Home" aria-expanded="false"><i
                                        class="fas fa-home"></i><span class="hide-menu">แดชบอร์ท</span></a></li>
                            <li> <a class="waves-effect waves-dark" href="<?= base_url() ?>Log_month" aria-expanded="false"
                                    false"><i class="far fa-list-alt"></i><span
                                        class="hide-menu">ประวัติการใช้งานนำ้-ไฟ</span></a></li>
                            <li> <a class="waves-effect waves-dark" href="<?= base_url() ?>Payment" aria-expanded="false"><i
                                        class=" far fa-money-bill-alt"></i><span class="hide-menu">การชำระเงิน</span></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION[ 'user_role' ] > 1): ?>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="fas fa-building"></i><span
                                        class="hide-menu">จัดการหอพัก</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <?php if ($_SESSION[ 'user_role' ] > 2): ?>
                                        <li><a href="<?= base_url() ?>Manege_Apartment">จัดการหอพัก</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?= base_url() ?>Apartment">จัดการห้องพัก</a></li>
                                    <li><a href="<?= base_url() ?>Bill">คำนวนบิล</a></li>
                                </ul>
                            </li>
                            <li> <a class=" has-arrow waves-effect waves-dark" aria-expanded="false"><i
                                        class="fas fa-tachometer-alt"></i><span class="hide-menu">จัดการมิเตอร์</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url() ?>Meter/power_meter">มิเตอร์ไฟฟ้า</a></li>
                                    <li><a href="<?= base_url() ?>Meter/water_meter">มิเตอร์นำ้</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="fas fa-address-book"></i><span
                                        class="hide-menu">จัดการผู้เช่า</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url() ?>Users_register/">ลงทะเบียน</a></li>
                                    <li><a href="<?= base_url() ?>Users_register/list">จัดการผู้เช่า</a></li>
                                    <!-- <li><a href="table-layout.html">ผลงานพนักงาน</a></li>
                                  <li><a href="table-data-table.html">บันทึกกิจกรรม</a></li> -->
                                </ul>
                            </li>
                            <?php if ($_SESSION[ 'user_role' ] > 2): ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="fas fa-users"></i><span
                                        class="hide-menu">จัดการบุคลากร</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url() ?>Employee">จัดการบุคลากร</a></li>
                                    <!-- <li><a href="<?= base_url() ?>Users">จัดการสิทธ์การใช้งาน</a></li> -->
                                    <!-- <li><a href="table-layout.html">ผลงานพนักงาน</a></li>
                                  <li><a href="table-data-table.html">บันทึกกิจกรรม</a></li> -->
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"><i class="fas fa-clipboard"></i><span
                                        class="hide-menu">จัดการเอกสาร</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url() ?>Document/template">เพิ่มแบบฟอร์มสัญญาเช่า</a></li>
                                    <li><a href="<?= base_url() ?>Document">จัดการสัญญาเช่า</a></li>
                                    <li><a href="<?= base_url() ?>Document/receipt">ใบเสร็จรับเงินรายเดือน</a></li>
                                </ul>
                            </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false"> <i class="fas fa-chart-line"></i><span
                                        class="hide-menu">การวิเคราะห์ระบบ</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url() ?>Analysis/meter">วิเคราะห์มิเตอร์ผู้เช่า</a></li>
                                    <li><a href="<?= base_url() ?>Analysis/reveune">วิเคราะห์รายรับรายเดือน</a></li>
                                </ul>
                            </li>
                            <li> <a class="waves-effect waves-dark" href="<?= base_url() ?>SystemLog"
                                    aria-expanded="false"><i class="ti-server"></i><span class="hide-menu">System
                                        log</span></a></li>
                        <?php endif; ?>

                        <!-- <li> <a class="waves-effect waves-dark" href="<?= base_url() ?>logout" aria-expanded="false"><i class=" fas fa-sign-out-alt"></i><span class="hide-menu">ออกจากระบบ</span></a></li> -->


                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">
                            <?= $pageTitle ?>
                        </h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home/home">Home</a></li>
                                <?php if (isset ($subBreadcrumb)): ?>
                                    <?= $subBreadcrumb ?>
                                <?php endif; ?>
                                <?php if (isset ($breadcrumb)): ?>
                                    <li class="breadcrumb-item active">
                                        <?= $breadcrumb ?>
                                    </li>
                                <?php endif; ?>
                            </ol>
                            <?php if (isset ($newBtn)): ?>
                                <button type="button" class="btn btn-info  d-lg-block m-l-15" id="newBtn"><i
                                        class="fa fa-plus-circle"></i>
                                    <?= $newBtn ?>
                                </button>
                            <?php endif; ?>
                            <?php if (isset ($newBtnCustom)): ?>
                                <?= $newBtnCustom ?>
                            <?php endif; ?>
                            <?php if (isset ($MsgBtn)): ?>
                                <button type="button" class="btn btn-info  d-lg-block m-l-15" id="MsgBtn"><i
                                        class="fas fa-paper-plane"></i>
                                    <?= $MsgBtn ?>
                                </button>
                            <?php endif; ?>
                            <?php if (isset ($MsgBtnCustom)): ?>
                                <?= $MsgBtnCustom ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Info box Content -->
                <?= $pageContent ?>
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <!-- <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme working">1</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>

                        </div> -->
            </div>
        </div> -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer">
        © 2020 Thatasport.com by 92-tech
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- Modal -->
    <!-- if you want hide backdrop please add data-backdrop="static" -->
    <div class="modal fade bd-example-modal-xl" id="mainModal" tabindex="-1" role="dialog"
        aria-labelledby="modalCenterTitle" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl " role="document" id='modalSize'>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mainModalTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mainModalBody">
                    ...
                </div>
                <div class="modal-footer" id="mainModalFooter">
                    <i id="fMsgIcon"></i><span id="fMsg"></span>
                    <button type="button" class="btn btn-sm btn-primary">Save changes</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

</body>

</html>
<script>
    // function changePass(user_id) {
    //     $.ajax({
    //         method: "post",
    //         url: '../users/getChangePassForm',
    //         data: { user_id: user_id }
    //     }).done(function (returnData) {
    //         $('#mainModalTitle').html(returnData.title);
    //         $('#mainModalBody').html(returnData.body);
    //         $('#mainModalFooter').html(returnData.footer);
    //         $('#mainModal').modal();
    //     });
    // }  
</script>