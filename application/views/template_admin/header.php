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
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS_URL ?>js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= ASSETS_URL ?>images/favicon.png" />


    <!-- Jquery -->
    <script src="<?= ASSETS_URL ?>vendors/jquery/jquery.min.js"></script>

    <!-- Select 2 -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/select2/select2.min.css">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <!-- Alert -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>alerts/style.css">


    <!-- TOAST -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- Moment js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/id.js"></script>
    <script>
        siteUrl = "<?= base_url() ?>"
        moment.locale('id');
    </script>

    <style>
        .select2-container .select2-selection--single {
            height: auto !important;
            padding: 8px !important
        }
    </style>
</head>

<body>