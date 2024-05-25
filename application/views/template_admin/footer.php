    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
        </div>
    </footer>
    <!-- partial -->
    </div>

    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="<?= ASSETS_URL ?>vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?= ASSETS_URL ?>vendors/chart.js/Chart.min.js"></script>
    <script src="<?= ASSETS_URL ?>vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="<?= ASSETS_URL ?>vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="<?= ASSETS_URL ?>js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?= ASSETS_URL ?>js/off-canvas.js"></script>
    <script src="<?= ASSETS_URL ?>js/hoverable-collapse.js"></script>
    <!-- <script src="<?= ASSETS_URL ?>js/template.js"></script> -->
    <script src="<?= ASSETS_URL ?>js/settings.js"></script>
    <script src="<?= ASSETS_URL ?>js/todolist.js"></script>
    <script src="<?= ASSETS_URL ?>vendors/select2/select2.min.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="<?= ASSETS_URL ?>js/dashboard.js"></script>
    <script src="<?= ASSETS_URL ?>js/Chart.roundedBarCharts.js"></script>
    <script src="<?= ASSETS_URL ?>js/select2.js"></script>
    <script src="<?= ASSETS_URL ?>js/file-upload.js"></script>
    <!-- End custom js for this page-->


    <!-- Toast -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Alerts -->
    <script src="<?= ASSETS_URL ?>alerts/cute-alert.js"></script>

    <!-- Numeral js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script>
        $('.nominal').on('keyup', function() {
            var n = parseInt($(this).val().replace(/\D/g, ''), 10);
            $(this).val(isNaN(n) ? '' : n.toLocaleString());
        });

        function success(data) {
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
                    window.location.href = siteUrl + data.url
                }
            }
            toastr.success(`${data.message}`)

        }

        function errors(data) {
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
            toastr.error(`${data.message}`)
        }
    </script>

    </body>

    </html>