<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_edit">
                        <input type="hidden" name="uuid" value="<?= $director['uuid'] ?>">
                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="<?= $director['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required value="<?= $director['name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Hp<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="no_hp" required value="<?= $director['no_hp'] ?>">
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="1" <?= ($director['is_active']) ? 'checked' : '' ?> name="is_active">
                                Aktif
                                <i class="input-helper"></i></label>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="<?= base_url('director') ?>" class="btn btn-light">Cancel</a>
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
            url: siteUrl + "director/submitEdit",
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