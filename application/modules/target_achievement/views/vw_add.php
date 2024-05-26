<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_add">
                        <div class="form-group">
                            <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($sbu as $key => $value) : ?>
                                    <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sbu_target_id">Target SBU<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="sbu_target_id" name="sbu_target_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($target_sbu as $key => $value) : ?>
                                    <option value="<?= $value['id_target_sbu'] ?>"><?= '[' . number_format($value['target']) . ']' . ' ' . strtoupper($value['name_target'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="remaining_target">Sisa target keseluruhan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white">Rp</span>
                                </div>
                                <input type="text" class="form-control nominal" id="remaining_target" name="remaining_target" readonly disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name_quarter">Nama quarter<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_quarter" name="name_quarter" required>
                        </div>
                        <div class="form-group">
                            <label for="target">Target<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">Rp</span>
                                </div>
                                <input type="text" class="form-control nominal" id="target" name="target" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="<?= base_url('target_achievement') ?>" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#sbu_target_id").change(function() {
            console.log($('option:selected', this).val())
            $.ajax({
                url: siteUrl + "target_achievement/getRemainingTarget",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: $('option:selected', this).val()
                },
                success: function(results) {
                    $('#remaining_target').val(numeral(results).format('0,0'));
                }
            })
        });
    });
    $('#form_add').on('submit', function(e) {
        let form_data = new FormData($('#form_add')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "target_achievement/submitAdd",
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
</script>