<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <a href="<?= base_url('master_category/add') ?>" type="button" class="btn btn-primary btn-icon-text">
                        <i class="ti-layers btn-icon-prepend"></i>
                        Tambah
                    </a>
                    <!-- <button type="button" class="btn btn-danger btn-icon-text">
                        <i class="ti-upload btn-icon-prepend"></i>
                        Upload
                    </button> -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="master_category_table" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori Monitoring</th>
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
<script>
    $(document).ready(function() {
        var table = $("#master_category_table");
        grid_brand = table.DataTable({
            // scrollX: true,
            // scrollCollapse: true,
            aaSorting: [],
            initComplete: function(settings, json) {},
            retrieve: true,
            processing: true,
            ajax: {
                type: "GET",
                url: siteUrl + 'master_category/load',
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
                        return full.name_category_monitoring
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return full.description
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
                        return `<a href="${siteUrl}master_category/edit/${full.uuid}" class="btn btn-info" type="button"><i class="ti-receipt"></i></a>
                        <button onclick="hapus('${full.uuid}')" class="btn btn-danger" type="button"><i class="ti-close"></i></button>`;
                    },
                    className: 'text-center',
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
                    url: siteUrl + 'master_category/hapus',
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
</script>