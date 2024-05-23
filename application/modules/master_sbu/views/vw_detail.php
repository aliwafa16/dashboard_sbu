<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <div class="row align-items-center justify-content-between px-2">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold"><?= $sbu['name_sbu'] ?></h4>
                            <span>
                                <p class="font-weight-bold">Director : <?= $director['name'] ?></p>
                            </span>
                            <div class="">
                                <p class="text-wrap text-justify"><?= $sbu['description'] ?></p>
                            </div>
                        </div>
                        <div class="bg-info rounded text-light py-3 col-md-4 text-center">
                            <h3 class="font-weight-bold">Target : Rp. <?= number_format($target['target'])  ?></h3>
                            <p class="m-0">Periode : <?= tgl_format_indo($target['start_date']) ?> s.d <?= tgl_format_indo($target['end_date']) ?></p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="col">
                            <button type="button" class="btn btn-danger btn-icon-text mt-4" data-toggle="modal" data-target="#targetModal">
                                <i class="ti-target btn-icon-prepend"></i>
                                Setting target
                            </button>
                            <div class="table-responsive mt-3">
                                <table id="target_sbu_table" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Target</th>
                                            <th>Tanggal mulai</th>
                                            <th>Tanggal selesai</th>
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

<div class="modal fade" id="targetModal" tabindex="-1" aria-labelledby="targetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="targetModalLabel">Tambah data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="form_target_sbu">
                    <input type="hidden" name="uuid" id="uuid" value="<?= $this->uri->segment(3) ?>">
                    <label for="target">Target<span class="text-danger">*</span></label>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">Rp</span>
                        </div>
                        <input type="text" class="form-control nominal" id="target" name="target" placeholder="Target SBU" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Re:Password" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Re:date" required>
                    </div>
                    <div class="form-check form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="1" checked="true" name="is_active">
                            Aktif
                            <i class="input-helper"></i></label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="targetEditModal" tabindex="-1" aria-labelledby="targetEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="targetEditModalLabel">Edit data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="form_edit_target_sbu">
                    <input type="hidden" name="uuid" id="uuid" value="">
                    <input type="hidden" name="sbu_id" id="sbu_id" value="">

                    <label for="target">Target<span class="text-danger">*</span></label>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">Rp</span>
                        </div>
                        <input type="text" class="form-control nominal" id="target" name="target" placeholder="Target SBU" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Re:Password" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Re:date" required>
                    </div>
                    <div class="form-check form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="1" name="is_active">
                            Aktif
                            <i class="input-helper"></i></label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $("#target_sbu_table");
        grid_brand = table.DataTable({
            // scrollX: true,
            // scrollCollapse: true,
            aaSorting: [],
            initComplete: function(settings, json) {},
            retrieve: true,
            processing: true,
            ajax: {
                type: "GET",
                url: '<?= base_url() ?>master_sbu/loadTarget/<?= $this->uri->segment(3) ?>',
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
                        return `Rp. ${numeral(full.target).format('0,0')}`;
                    },
                    className: "text-center",
                },
                {
                    render: function(data, type, full, meta) {
                        return moment(full.start_date).format('LL')
                    },
                    className: "wrap-text",
                    width: "30%"
                },
                {
                    render: function(data, type, full, meta) {
                        return moment(full.end_date).format('LL')
                    },
                    className: "text-wrap",
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
                        return `<button onclick="editTarget('${full.uuid}')" class="btn btn-info" type="button"><i class="ti-pencil"></i></button>
                        <button onclick="hapusTarget('${full.uuid}')" class="btn btn-danger" type="button"><i class="ti-close"></i></button>`;
                    },
                    className: 'text-center',
                    width: '15%'

                },
            ],
        });
    })

    $('#form_target_sbu').on('submit', function(e) {
        let form_data = new FormData($('#form_target_sbu')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "master_sbu/addTarget",
            method: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: form_data,
            success: function(results) {
                if (results.code != 200) {
                    errors(results)
                } else {
                    success(results)
                }
            }
        })
    })

    function editTarget(uuid) {
        $('#targetEditModal').modal('show')
        $('#targetEditModal #uuid').val(uuid)
        $.ajax({
            url: siteUrl + "master_sbu/getTarget/" + uuid,
            method: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(results) {
                $('#targetEditModal #uuid').val(results.uuid)
                $('#targetEditModal #target').val(results.target)
                $('#targetEditModal #start_date').val(results.start_date)
                $('#targetEditModal #end_date').val(results.end_date)
                $('#targetEditModal #sbu_id').val(results.sbu_id)


                if (results.is_active == 1) {
                    $('#targetEditModal #is_active').prop('checked', true);
                }

            }
        })
    }

    $('#form_edit_target_sbu').on('submit', function(e) {
        let form_data = new FormData($('#form_edit_target_sbu')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "master_sbu/editTarget",
            method: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: form_data,
            success: function(results) {
                if (results.code != 200) {
                    errors(results)
                } else {
                    success(results)
                }
            }
        })
    })


    function hapusTarget(uuid) {
        cuteAlert({
            type: "question",
            title: 'Yakin melanjutkan ?',
            message: 'Data yang sudah dihapus tidak bisa dikembalikan',
            confirmText: 'Lanjutkan',
            cancelText: 'Batal'
        }).then((e) => {
            if (e === "confirm") {
                $.ajax({
                    url: siteUrl + 'master_sbu/hapusTarget',
                    type: 'POST',
                    data: {
                        uuid,
                        sbu_id: "<?= $this->uri->segment(3) ?>"
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