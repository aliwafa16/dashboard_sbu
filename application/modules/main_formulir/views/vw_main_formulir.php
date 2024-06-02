<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-center"><?= $heading ?></p>
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-9">
                            <button href="#" type="button" class="btn btn-primary btn-icon-text my-1" data-toggle="modal" data-target="#addModal">
                                <i class="ti-layers btn-icon-prepend"></i>
                                Tambah Item Monitoring
                            </button>
                            <button href="#" type="button" class="btn btn-info btn-icon-text my-1" data-toggle="modal" data-target="#addDashboardModal">
                                <i class="ti-server btn-icon-prepend"></i>
                                Buat dashboard monitoring
                            </button>
                            <button href="#" type="button" class="btn btn-success btn-icon-text my-1" data-toggle="modal" data-target="#copyModal">
                                <i class="ti-layout btn-icon-prepend"></i>
                                Copy dashboard monitoring
                            </button>
                        </div>
                        <div class="col-md-2">
                            <form action="" id="form_periode">
                                <div class="form-group">
                                    <label for="periode_id">Periode</label>
                                    <select class="form-control periode_id" id="periode_id" name="periode_id">
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit" id="btn_submit_periode">
                                Cari
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
                <div id="formulir">
                    <div class="row text-center mb-5">
                        <div class="col-md-12">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDashboardModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Buat dashboard monitoring</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_dashboard" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="uuid" name="uuid">
                    <div class="form-group">
                        <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required style="width: 100% !important;">
                            <option value="">--Pilih--</option>
                            <?php foreach ($sbu as $key => $value) : ?>
                                <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="copyModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyModalLabel">Copy dashboard monitoring</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_copy" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="uuid" name="uuid">
                    <div class="form-group">
                        <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required style="width: 100% !important;">
                            <option value="">--Pilih--</option>
                            <?php foreach ($sbu as $key => $value) : ?>
                                <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sumber_periode">Sumber<span class="text-danger">*</span></label>
                                <select class="form-control" id="sumber_periode" name="sumber_periode" required>
                                    <option value="">--Pilih bulan--</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tujuan_periode">Tujuan<span class="text-danger">*</span></label>
                                <select class="form-control" id="tujuan_periode" name="tujuan_periode" required>
                                    <option value="">--Pilih bulan--</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tipe">Tipe<span class="text-danger">*</span></label>
                        <select class="form-control" id="tipe" name="tipe" required>
                            <option value="">--Pilih tipe--</option>
                            <option value="1">Copy Template</option>
                            <option value="2">Copy Template dengan value</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">TAMBAH <?= $heading ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="uuid" name="uuid">
                    <div class="form-group">
                        <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required style="width: 100% !important;">
                            <option value="">--Pilih--</option>
                            <?php foreach ($sbu as $key => $value) : ?>
                                <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="periode">Periode<span class="text-danger">*</span></label>
                        <select class="form-control" id="periode" name="periode" required>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_monitoring_id">Kategori Monitoring<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="category_monitoring_id" name="category_monitoring_id" required style="width: 100% !important;">
                            <option value="">--Pilih--</option>
                            <?php foreach ($category_monitoring as $key => $value) : ?>
                                <option value="<?= $value['id_category_monitoring'] ?>"><?= strtoupper($value['name_category_monitoring'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategory_monitoring_id">Sub Kategori Monitoring<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="subcategory_monitoring_id" name="subcategory_monitoring_id" required style="width: 100% !important;">
                            <option value="">--Pilih--</option>
                            <?php foreach ($subcategory_monitoring as $key => $value) : ?>
                                <option value="<?= $value['id_account_subcategory'] ?>"><?= strtoupper($value['name_subcategory'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name_tools">Nama Item<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_tools" name="name_tools" placeholder="Nama item monitoring" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="status" name="status" required style="width: 100% !important;" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($master_status as $key => $value) : ?>
                                <option value="<?= $value['id_master_status'] ?>"><?= strtoupper($value['status'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assigned_to">PIC<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="assigned_to" name="assigned_to" required style="width: 100% !important;" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($master_pic as $key => $value) : ?>
                                <option value="<?= $value['id_master_pic'] ?>"><?= strtoupper($value['pic'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="target_unit">Skala target<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="target_unit" name="target_unit" required style="width: 100% !important;" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($satuan_target as $key => $value) : ?>
                                <option value="<?= $value['id_ukuran_satuan'] ?>"><?= strtoupper($value['ukuran_satuan'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="target_rate">Target<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="target_rate" name="target_rate" step="0.1" value="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="actual">Realisasi<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="actual" name="actual" step="0.1" value="0.00" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link_dokumen">Link Dokumen</label>
                        <input type="text" class="form-control" id="link_dokumen" name="link_dokumen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">EDIT <?= $heading ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="from_edit" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="uuid" name="uuid">
                    <div class="form-group">
                        <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required style="width: 100% !important;">
                            <option value="">--Pilih--</option>
                            <?php foreach ($sbu as $key => $value) : ?>
                                <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name_tools">Nama Item<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_tools" name="name_tools" placeholder="Nama item monitoring" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="status" name="status" required style="width: 100% !important;" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($master_status as $key => $value) : ?>
                                <option value="<?= $value['id_master_status'] ?>"><?= strtoupper($value['status'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assigned_to">PIC<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="assigned_to" name="assigned_to" required style="width: 100% !important;" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($master_pic as $key => $value) : ?>
                                <option value="<?= $value['id_master_pic'] ?>"><?= strtoupper($value['pic'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="target_unit">Skala target<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" id="target_unit" name="target_unit" required style="width: 100% !important;" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($satuan_target as $key => $value) : ?>
                                <option value="<?= $value['id_ukuran_satuan'] ?>"><?= strtoupper($value['ukuran_satuan'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="target_rate">Target<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="target_rate" name="target_rate" step="0.1" value="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="actual">Realisasi<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="actual" name="actual" step="0.1" value="0.00" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link_dokumen">Link Dokumen</label>
                        <input type="text" class="form-control" id="link_dokumen" name="link_dokumen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Mendapatkan bulan saat ini (dari 0 - 11)
        const currentMonth = new Date().getMonth() + 1; // +1 karena getMonth() mengembalikan bulan dari 0-11
        document.getElementsByClassName('periode_id')[0].value = currentMonth;
        document.getElementById('periode').value = currentMonth;


        load_form(currentMonth)


        $("#category_monitoring_id").change(function() {
            $.ajax({
                url: siteUrl + "main_formulir/getSubcategoryAccount",
                method: "POST",
                dataType: "JSON",
                data: {
                    category_id: $('option:selected', this).val(),
                    sbu_id: $('#addModal #sbu_id').val(),
                    periode_id: $('#addModal #periode').val(),
                },
                success: function(results) {
                    let html = '';
                    results.forEach(element => {
                        html += `<option value="${element.id_account_subcategory}">${element.name_subcategory}</option>`;
                    });
                    $("#subcategory_monitoring_id").empty().append(html).trigger('change');
                }
            })
        });
    });

    function fnEdit(uuid) {
        console.log(uuid)
        $('#editModal').modal('show');
        $.ajax({
            type: 'POST',
            url: siteUrl + 'main_formulir/fnEdit',
            data: {
                uuid
            },
            dataType: 'json',
            success: function(results) {
                $('#editModal #uuid').val(results.uuid)
                $('#editModal #sbu_id').val(results.sbu_id).trigger('change')
                $('#editModal #name_tools').val(results.name_tools)
                $('#editModal #status').val(results.status).trigger('change')
                $('#editModal #assigned_to').val(results.assigned_to).trigger('change')
                $('#editModal #start_date').val(results.start_date)
                $('#editModal #end_date').val(results.end_date)
                $('#editModal #target_unit').val(results.target_unit).trigger('change')
                $('#editModal #target_rate').val(results.target_rate)
                $('#editModal #actual').val(results.actual)
                $('#editModal #notes').val(results.notes)
                $('#editModal #link_dokumen').val(results.link_dokumen)
            }
        });
    }

    function fnDelete(uuid) {
        cuteAlert({
            type: "question",
            title: 'Yakin melanjutkan ?',
            message: 'Data yang sudah dihapus tidak bisa dikembalikan',
            confirmText: 'Lanjutkan',
            cancelText: 'Batal'
        }).then((e) => {
            if (e === "confirm") {
                $.ajax({
                    url: siteUrl + 'main_formulir/submit_hapus',
                    type: 'POST',
                    data: {
                        uuid
                    },
                    dataType: 'JSON',
                    success: function(results) {
                        if (results.code != 200) {
                            errors(results)
                        } else {
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
                                    window.location.reload()
                                    $('#editModal').modal('hide')
                                    $('#from_edit')[0].reset();
                                }
                            }
                            toastr.success(`${results.message}`)
                        }
                    }
                })
            } else {
                console.log('gakjadi')
            }
        })
    }

    $('#from_edit').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData($('#from_edit')[0]);
        $.ajax({
            type: 'POST',
            url: siteUrl + 'main_formulir/submit_edit',
            data: data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {},
            success: function(results) {
                if (results.code != 200) {
                    errors(results)
                } else {
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
                            window.location.reload()
                            $('#editModal').modal('hide')
                            $('#from_edit')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        });
    })

    $('#form_copy').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData($('#form_copy')[0]);
        $.ajax({
            type: 'POST',
            url: siteUrl + 'main_formulir/submit_copy',
            data: data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {},
            success: function(results) {
                if (results.code != 200) {
                    errors(results)
                } else {
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
                            window.location.reload()
                            $('#editModal').modal('hide')
                            $('#from_edit')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        });
    })

    $('#form_add').on('submit', function(e) {
        let form_data = new FormData($('#form_add')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "main_formulir/submit_add",
            method: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function(results) {
                if (results.code != 200) {
                    errors(results)
                } else {
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
                            window.location.reload()
                            $('#addModal').modal('hide')
                            $('#form_add')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        })
    })

    $('#form_dashboard').on('submit', function(e) {
        let form_data = new FormData($('#form_dashboard')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "main_formulir/create_dashboard",
            method: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function(results) {
                if (results.code != 200) {
                    errors(results)
                } else {
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
                            window.location.reload()
                            $('#addModal').modal('hide')
                            $('#form_add')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        })
    })

    $('#form_periode').on('submit', function(e) {

        $('#btn_submit_periode').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`)
        $('#btn_submit_periode').attr('disabled', true)

        $('#formulir').html(`<div class="row text-center mb-5">
                        <div class="col-md-12">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>`)
        e.preventDefault()
        let periode_id = $('#periode_id').val();

        load_form(periode_id)
    })

    function load_form(periode_id) {
        $.ajax({
            url: siteUrl + 'main_formulir/load_form/',
            method: 'POST',
            dataType: 'JSON',
            data: {
                periode_id
            },
            success: function(results) {
                $('#formulir').html(results)
                $('#btn_submit_periode').html(`Cari`)
                $('#btn_submit_periode').attr('disabled', false)
            }
        })
    }
</script>