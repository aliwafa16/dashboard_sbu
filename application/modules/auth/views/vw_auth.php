<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= APP_TITLE ?><?= $title ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/feather/feather.css">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= ASSETS_URL ?>images/favicon.png" />

    <!-- Jquery -->
    <script src="<?= ASSETS_URL ?>vendors/jquery/jquery.min.js"></script>
    <script>
        siteUrl = "<?= base_url() ?>"
    </script>

    <!-- TOAST -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="<?= ASSETS_URL ?>images/logo.svg" alt="logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" id="form_login" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="password" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <!-- <script src="<?= ASSETS_URL ?>vendors/js/vendor.bundle.base.js"></script> -->
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?= ASSETS_URL ?>js/off-canvas.js"></script>
    <script src="<?= ASSETS_URL ?>js/hoverable-collapse.js"></script>
    <script src="<?= ASSETS_URL ?>js/template.js"></script>
    <script src="<?= ASSETS_URL ?>js/settings.js"></script>
    <script src="<?= ASSETS_URL ?>js/todolist.js"></script>
    <!-- endinject -->


    <!-- Toast -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
            console.log('okkkk')
        })

        $('#form_login').on('submit', function(e) {
            let form_data = new FormData($('#form_login')[0]);
            e.preventDefault()
            $.ajax({
                url: siteUrl + "auth/login",
                method: "POST",
                dataType: "JSON",
                processData: false,
                contentType: false,
                data: form_data,
                success: function(results) {
                    if (results.code != 200) {
                        errors(results.message)
                    } else {
                        success(results.message)
                    }
                }
            })
        })


        function success(msg) {

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "200",
                "hideDuration": "300",
                "timeOut": "2000",
                "extendedTimeOut": "300",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                onHidden: function() {
                    window.location.href = '<?= base_url('dashboard') ?>'
                }
            }
            toastr.success(`${msg}`)

        }

        function errors(msg) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "200",
                "hideDuration": "600",
                "timeOut": "5000",
                "extendedTimeOut": "600",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.error(`${msg}`)
        }
    </script>
</body>

</html>