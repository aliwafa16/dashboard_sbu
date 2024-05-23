<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_edit">
                        <input type="hidden" name="uuid" value="<?= $role['uuid'] ?>">
                        <div class="form-group">
                            <label for="role">Role<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="role" name="role" placeholder="Role" required value="<?= $role['role'] ?>">
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="1" <?= ($role['is_active']) ? 'checked' : '' ?> name="is_active">
                                Aktif
                                <i class="input-helper"></i></label>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="<?= base_url('role') ?>" class="btn btn-light">Cancel</a>
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
            url: siteUrl + "role/submitEdit",
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