<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <a href="<?= base_url('target_achievement/add') ?>" type="button" class="btn btn-primary btn-icon-text">
                        <i class="ti-layers btn-icon-prepend"></i>
                        Tambah
                    </a>
                    <button type="button" class="btn btn-info btn-icon-text" data-toggle="modal" data-target="#pencapaianModal">
                        <i class="ti-money btn-icon-prepend"></i>
                        Tambah pencapaian
                    </button>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="subcategory_table" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SBU</th>
                                            <th>Target SBU</th>
                                            <th>Nama Quarter</th>
                                            <th>Target</th>
                                            <th>Pencapaian</th>
                                            <th>Tanggal mulai</th>
                                            <th>Tanggal selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pencapaianModal" aria-labelledby="pencapaianModalLabel" aria-hidden="true" style="overflow: hidden;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pencapaianModalLabel">Tambah data pencapaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formPencapaian" enctype="multipart/form-data">
                <div class="modal-body">
                    <label for="quarter_id">Quarter pencapaian<span class="text-danger">*</span></label>
                    <div class="form-group">
                        <select class="form-control js-example-basic-single" id="quarter_id" name="quarter_id" required style="width:448px">
                            <option value="">--Pilih--</option>
                            <?php foreach ($quarter as $key => $value) : ?>
                                <option value="<?= $value['id_quarter'] ?>">
                                    <?= '[' . number_format($value['target']) . ']' . ' ' . strtoupper($value['name_quarter']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal pencapaian<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">Rp</span>
                            </div>
                            <input type="text" class="form-control nominal" id="nominal" name="nominal" required>
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


<script>
    $(document).ready(function() {
        $("#quarter_id").select2({
            dropdownParent: $("#pencapaianModal")
        });

        var table = $("#subcategory_table");
        grid_brand = table.DataTable({
            // scrollX: true,
            // scrollCollapse: true,
            aaSorting: [],
            initComplete: function(settings, json) {},
            retrieve: true,
            processing: true,
            ajax: {
                type: "GET",
                url: '<?= base_url() ?>target_achievement/load',
                data: function(d) {
                    no = 0;
                },
                dataSrc: "",
            },
            columns: [{
                    render: function(data, type, full, meta) {
                        no += 1;

                        return no;
                    },
                    className: "text-center",
                    width: "1%",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.name_sbu.toUpperCase();
                    },
                    className: "wrap-text",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.name_target.toUpperCase();
                    },
                    className: "wrap-text",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.name_quarter.toUpperCase();
                    },
                    className: "wrap-text",
                },
                {
                    render: function(data, type, full, meta) {
                        return `Rp. ${numeral(full.target).format('0,0')}`;
                    },
                    className: "wrap-text",
                },
                {
                    render: function(data, type, full, meta) {
                        return `Rp. ${numeral(full.achievement).format('0,0')}`;
                    },
                    className: "wrap-text",
                },
                {
                    render: function(data, type, full, meta) {
                        return moment(full.start_date).format('LL')
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return moment(full.end_date).format('LL')
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        // return `<a href="${siteUrl}target_achievement/edit/${full.uuid}" class="btn btn-info btn-sm btn-icon" type="button"><i class="ti-receipt"></i></a>
                        // <button onclick="changePassword('${full.uuid}')" class="btn btn-success btn-sm btn-icon" type="button"><i class="ti-key"></i></button>
                        // <button onclick="hapus('${full.uuid}')" class="btn btn-danger btn-sm btn-icon" type="button"><i class="ti-close"></i></button>`;

                        return `<div><a href="${siteUrl}target_achievement/edit/${full.uuid}" class="btn btn-info" type="button"><i class="ti-receipt"></i></a>
                                <button onclick="hapus('${full.uuid}')" class="btn btn-danger" type="button"><i class="ti-close"></i></button>
                                <a href="${siteUrl}target_achievement/history_achievement/${full.uuid}" class="btn btn-success" type="button"><i class="ti-more-alt"></i></a><div>
                                `
                    },
                    className: "text-center",
                    width: '15%'

                },
            ],
        });
    })


    function hapus(uuid) {
        cuteAlert({
            type: "question",
            title: 'Yakin melanjutkan ?',
            message: 'Data yang sudah dihapus tidak bisa dikembalikan',
            confirmText: 'Lanjutkan',
            cancelText: 'Batal'
        }).then((e) => {
            if (e === "confirm") {
                $.ajax({
                    url: siteUrl + 'target_achievement/hapus',
                    type: 'POST',
                    data: {
                        uuid
                    },
                    dataType: 'JSON',
                    success: function(results) {
                        // console.log(results)
                        if (results.code != 200) {
                            errors(results)
                        } else {
                            success(results)
                        }
                    }
                })
            } else {
                console.log('gakjadi')
            }
        })
    }

    $('#unduhTemplate').on('click', function() {
        window.location.href = siteUrl + 'target_achievement/unduhTemplate'
    })


    $('#formPencapaian').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData($('#formPencapaian')[0]);
        $.ajax({
            type: 'POST',
            url: siteUrl + 'target_achievement/addAchievement',
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
                            grid_brand.ajax.reload()
                            $('#pencapaianModal').modal('hide')
                            $('#formPencapaian')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        });
    })

    $('#formUpload').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData($('#formUpload')[0]);
        $.ajax({
            type: 'POST',
            url: siteUrl + 'target_achievement/import',
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
                            grid_brand.ajax.reload()
                            $('#pencapaianModal').modal('hide')
                            $('#formUpload')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        });
    })
</script>