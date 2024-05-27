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
                            <label for="name_subcategory">Nama Sub Kategori<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_subcategory" name="name_subcategory" placeholder="Nama sub kategori" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_monitoring_id">Kategori<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="category_monitoring_id" name="category_monitoring_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($category_monitoring as $key => $value) : ?>
                                    <option value="<?= $value['id_category_monitoring'] ?>"><?= strtoupper($value['name_category_monitoring'])  ?></option>
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
                        <a href="<?= base_url('account_subcategory') ?>" class="btn btn-light">Cancel</a>
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
            url: siteUrl + "account_subcategory/submitAdd",
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