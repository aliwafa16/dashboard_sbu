<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <a href="<?= base_url('account_item/add') ?>" type="button" class="btn btn-primary btn-icon-text">
                        <i class="ti-layers btn-icon-prepend"></i>
                        Tambah
                    </a>
                    <button type="button" class="btn btn-danger btn-icon-text" data-toggle="modal" data-target="#uploadModal">
                        <i class="ti-upload btn-icon-prepend"></i>
                        Upload
                    </button>
                    <a href="<?= base_url('account_item/copy') ?>" type="button" class="btn btn-info btn-icon-text">
                        <i class="ti-reload btn-icon-prepend"></i>
                        Copy master data
                    </a>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="subcategory_table" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SBU</th>
                                            <th>Produk</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Item monitoring</th>
                                            <th>Deskripsi</th>
                                            <th>Status</th>
                                            <th>Create At</th>
                                            <th>Update At</th>
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

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload <?= $heading ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpload" enctype="multipart/form-data">
                <div class="modal-body">
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
                        <label>File upload</label>
                        <input type="file" name="file_excel" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload file">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <span><a href="#" type="button" id="unduhTemplate">Unduh Template</a></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
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
                url: '<?= base_url() ?>account_item/load',
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
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.name_product
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.name_category_monitoring.toUpperCase();
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.name_subcategory;
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.item_monitoring;
                    },
                    className: "text-center",
                },

                {
                    render: function(data, type, full, meta) {
                        return full.description;
                    },
                    className: "wrap-text",
                },
                {
                    render: function(data, type, full, meta) {
                        let status = '';

                        if (full.is_active == 1) {
                            status = `<button class="btn btn-success btn-sm" type="button">Aktif</button>`
                        } else {
                            status = `<button class="btn btn-danger btn-sm" type="button">Tidak Aktif</button>`

                        }
                        return status
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return "-";
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return "-";
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        // return `<a href="${siteUrl}account_item/edit/${full.uuid}" class="btn btn-info btn-sm btn-icon" type="button"><i class="ti-receipt"></i></a>
                        // <button onclick="changePassword('${full.uuid}')" class="btn btn-success btn-sm btn-icon" type="button"><i class="ti-key"></i></button>
                        // <button onclick="hapus('${full.uuid}')" class="btn btn-danger btn-sm btn-icon" type="button"><i class="ti-close"></i></button>`;

                        return `<div><a href="${siteUrl}account_item/edit/${full.uuid}" class="btn btn-info" type="button"><i class="ti-receipt"></i></a>
                                <button onclick="hapus('${full.uuid}')" class="btn btn-danger" type="button"><i class="ti-close"></i></button><div>`
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
                    url: siteUrl + 'account_item/hapus',
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
        window.location.href = siteUrl + 'account_item/unduhTemplate'
    })

    $('#formUpload').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData($('#formUpload')[0]);
        $.ajax({
            type: 'POST',
            url: siteUrl + 'account_item/import',
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
                            $('#uploadModal').modal('hide')
                            $('#formUpload')[0].reset();
                        }
                    }
                    toastr.success(`${results.message}`)
                }
            }
        });
    })
</script>