<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-center"><?= $heading ?></p>
                    <button href="#" type="button" class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#sbuspecificationModal">
                        <i class="ti-layers btn-icon-prepend"></i>
                        Tambah Brand / SBU Spesification
                    </button>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="subcategory_table" class="display expandable-table table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="width:3%">Dokumen</th>
                                            <th style="width: 35%">Action plan</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width:10%">PIC</th>
                                            <th style="width:7%">Tanggal mulai</th>
                                            <th style="width:7%">Tanggal selesai</th>
                                            <th>Satuan target</th>
                                            <th style="width:5%" s>Target & KPI (no & pax)</th>
                                            <th style="width:5%">Realisasi</th>
                                            <th>% Reaslisasi</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <form action="">
                                        <tbody>
                                            <?php foreach ($forms as $key => $value) : ?>
                                                <tr>
                                                    <td class=" text-center" colspan="11" style="background-color: #CEE6F3;font-size: 1.4em;font-weight: bold;text-transform:uppercase"><?= $value['name_sbu'] ?></td>
                                                </tr>
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
                                                    <tr>
                                                        <td><a href="${siteUrl}account_item/edit/${full.uuid}" class="btn btn-info btn-sm text-center" type="button"><i class="ti-receipt"></i></a></td>
                                                        <td><input type="text" class="form-control" value="<?= $value_list['name_tools'] ?>" name="name_tools" disabled></td>
                                                        <td>
                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <?php foreach ($master_status as $key_status => $value_status) : ?>
                                                                    <option value="<?= $value_status['id_master_status'] ?>" <?= ($value_status['id_master_status'] == $value_list['status']) ? 'selected' : '' ?>><?= $value_status['status'] ?></option>
                                                                <?php endforeach; ?>
                                                                <?php ?>
                                                            </select>
                                                        </td>
                                                        <td><?= $value_list['assigned_to'] ?></td>
                                                        <td><?= $value_list['start_date'] ?></td>
                                                        <td><?= $value_list['end_date'] ?></td>
                                                        <td><?= $value_list['target_unit'] ?></td>
                                                        <td><?= $value_list['target_rate'] ?></td>
                                                        <td><?= $value_list['actual'] ?></td>
                                                        <td><?= $value_list['percentage'] ?></td>
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

<div class="modal fade" id="sbuspecificationModal" tabindex="-1" aria-labelledby="sbuspecificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sbuspecificationModalLabel">Tambah Form Brand/SBU Spesification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_sbu" enctype="multipart/form-data">
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
    $('#form_sbu').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData($('#form_sbu')[0]);
        $.ajax({
            type: 'POST',
            url: siteUrl + 'account_formulir/add_form_sbu',
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