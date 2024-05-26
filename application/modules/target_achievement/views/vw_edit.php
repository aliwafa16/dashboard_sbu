<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_edit">
                        <input type="hidden" name="uuid" value="<?= $target_quarter['uuid'] ?>">
                        <div class="form-group">
                            <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($sbu as $key => $value) : ?>
                                    <option value="<?= $value['id_sbu'] ?>" <?= ($target_quarter['sbu_id'] == $value['id_sbu']) ? 'selected' : '' ?>><?= strtoupper($value['name_sbu'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sbu_target_id">Target SBU<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="sbu_target_id" name="sbu_target_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($target_sbu as $key => $value) : ?>
                                    <option value="<?= $value['id_target_sbu'] ?>" <?= ($target_quarter['sbu_target_id'] == $value['id_target_sbu']) ? 'selected' : '' ?>><?= '[' . number_format($value['target']) . ']' . ' ' . strtoupper($value['name_target'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name_quarter">Nama quarter</label>
                            <input type="text" class="form-control" id="name_quarter" name="name_quarter" placeholder="Nama quater target" required value="<?= $target_quarter['name_quarter'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="target">Target<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">Rp</span>
                                </div>
                                <input type="text" class="form-control nominal" id="target" name="target" required value="<?= number_format($target_quarter['target'])  ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal mulai<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required value="<?= $target_quarter['start_date'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal selesai<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required value="<?= $target_quarter['end_date'] ?>">
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
    $('#form_edit').on('submit', function(e) {
        let form_data = new FormData($('#form_edit')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "target_achievement/submitEdit",
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