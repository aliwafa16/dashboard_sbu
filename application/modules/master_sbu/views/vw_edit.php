<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_edit">
                        <input type="hidden" name="uuid" value="<?= $sbu['uuid'] ?>">
                        <div class="form-group">
                            <label for="name_sbu">Nama SBU<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_sbu" name="name_sbu" placeholder="Nama" required value="<?= $sbu['name_sbu'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $sbu['description'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="director_id">Director<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="director_id" name="director_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($director as $key => $value) : ?>
                                    <option value="<?= $value['id_director'] ?>" <?= ($sbu['director_id'] == $value['id_director']) ? 'selected' : '' ?>><?= strtoupper($value['name'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="1" <?= ($sbu['is_active']) ? 'checked' : '' ?> name="is_active">
                                Aktif
                                <i class="input-helper"></i></label>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="<?= base_url('master_sbu') ?>" class="btn btn-light">Cancel</a>
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
            url: siteUrl + "master_sbu/submitEdit",
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