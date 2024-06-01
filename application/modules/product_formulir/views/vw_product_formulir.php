<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-center"><?= $heading ?></p>
                    <button href="#" type="button" class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#addModal">
                        <i class="ti-layers btn-icon-prepend"></i>
                        Tambah Brand / SBU Spesification
                    </button>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="subcategory_table" class="display expandable-table table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="width:7%">Aksi</th>
                                            <th style="width: 20%">Action plan</th>
                                            <th style="width: 8%">Status</th>
                                            <th style="width: 8%">PIC</th>
                                            <th style="width:5%">Tanggal mulai</th>
                                            <th style="width:5%">Tanggal selesai</th>
                                            <th style="width: 7%">Satuan target</th>
                                            <th style="width: 5%">Target</th>
                                            <th style="width: 5%">Realisasi</th>
                                            <th style="width: 15%">% Reaslisasi</th>
                                            <th style="width:10%">Catatan</th>
                                        </tr>
                                    </thead>
                                    <form action="">
                                        <tbody>
                                            <?php foreach ($forms as $key => $value) : ?>
                                                <tr>
                                                    <td class="" colspan="11" style="font-weight: bold; text-transform:uppercase; background-color:#EEF7FF">
                                                        <?= $value['category_name'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="" colspan="11" style="font-weight: bold; text-transform:uppercase; background-color:#DAF5FF">
                                                        <?= $value['subcategory_name'] ?>
                                                    </td>
                                                </tr>
                                                <?php foreach ($value['list_monitoring'] as $key_list => $value_list) : ?>
                                                    <?php
                                                    $percentage = $value_list['percentage'];
                                                    $progressBarClass = '';
                                                    if ($percentage < 50) {
                                                        $progressBarClass = 'bg-danger';
                                                    } elseif ($percentage >= 50 && $percentage <= 74) {
                                                        $progressBarClass = 'bg-warning';
                                                    } else {
                                                        $progressBarClass = 'bg-success';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="text-center">
                                                                <a href="<?= ($value_list['link_dokumen']) ? $value_list['link_dokumen'] : '#' ?>" class="btn btn-info btn-sm text-center my-1 <?= (!$value_list['link_dokumen']) ? 'disabled' : '' ?>" type="button" title="unduh dokumen"><i class="ti-receipt"></i></a>
                                                                <button class="btn btn-success btn-sm text-center my-1" type="button" title="edit data"><i class="ti-settings" onclick="fnEdit(`<?= $value_list['uuid'] ?>`)"></i></button>
                                                                <button onclick="fnDelete(`<?= $value_list['uuid'] ?>`)" class="btn btn-danger btn-sm text-center my-1" type="button" title="hapus"><i class="ti-brush-alt"></i></button>
                                                            </div>
                                                        </td>
                                                        <td class="wrap-text"><?= $value_list['name_tools'] ?></td>
                                                        <td class="text-center">
                                                            <span class="bg-<?= $value_list['color'] ?> text-white p-1 rounded">
                                                                <?= $value_list['status_name'] ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-center fw-bold">
                                                            <?= ($value_list['pic_name'] ? $value_list['pic_name'] : 'Belum diset')  ?>
                                                        </td>
                                                        <td class="text-center"><?= ($value_list['start_date']) ? tgl_format_indo($value_list['start_date']) : '' ?></td>
                                                        <td class="text-center"><?= ($value_list['end_date']) ? tgl_format_indo($value_list['end_date']) : ''  ?></td>
                                                        <td class="text-center"><?= $value_list['ukuran_satuan'] ?></td>
                                                        <td class="text-center"><?= $value_list['target_rate'] ?></td>
                                                        <td class="text-center"><?= $value_list['actual'] ?></td>
                                                        <td class="text-center">
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width:<?= ($value_list['percentage'] > 0)  ? $value_list['percentage'] . '%' : '%' ?>"><?= ($value_list['percentage'] > 0) ? $value_list['percentage'] . '%' : '0%'  ?></div>
                                                            </div>
                                                        </td>
                                                        <td><?= $value_list['notes'] ?></td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach ?>
                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        $("#sbu_id").change(function() {
            $.ajax({
                url: siteUrl + "account_formulir/getSubcategoryAccount",
                method: "POST",
                dataType: "JSON",
                data: {
                    sbu_id: $('option:selected', this).val(),
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
            url: siteUrl + 'account_formulir/fnEdit',
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
                    url: siteUrl + 'account_formulir/submit_hapus',
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
            url: siteUrl + 'account_formulir/submit_edit',
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
            url: siteUrl + "account_formulir/submit_add",
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
</script>