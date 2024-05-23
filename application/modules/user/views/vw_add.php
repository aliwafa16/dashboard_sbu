<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_add">
                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="re_password" placeholder="Re:Password" required>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="role_id" name="role_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($role as $key => $value) : ?>
                                    <option value="<?= $value['id_role'] ?>"><?= strtoupper($value['role'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="director_id">Director</label>
                            <select class="form-control js-example-basic-single" id="director_id" name="director_id">
                                <option value="">--Pilih--</option>
                                <?php foreach ($director as $key => $value) : ?>
                                    <option value="<?= $value['id_director'] ?>"><?= strtoupper($value['name'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="1" checked="true" name="is_active">
                                Aktif
                                <i class="input-helper"></i></label>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="<?= base_url('user') ?>" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#form_add').on('submit', function(e) {
        let form_data = new FormData($('#form_add')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "user/submitAdd",
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