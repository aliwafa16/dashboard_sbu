<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><?= $heading ?></p>
                    <form class="forms-sample" id="form_edit">
                        <input type="hidden" name="uuid" value="<?= $item_account['uuid'] ?>">
                        <div class="form-group">
                            <label for="sbu_id">Nama SBU<span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" id="sbu_id" name="sbu_id" required>
                                <option value="">--Pilih--</option>
                                <?php foreach ($sbu as $key => $value) : ?>
                                    <option value="<?= $value['id_sbu'] ?>" <?= ($item_account['sbu_id'] == $value['id_sbu']) ? 'selected' : '' ?>><?= strtoupper($value['name_sbu'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item_monitoring">Nama Sub Kategori<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="item_monitoring" name="item_monitoring" placeholder="Nama sub kategori" required value="<?= $item_account['item_monitoring'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $item_account['description'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_monitoring_id">Kategori</label>
                            <select class="form-control js-example-basic-single" id="category_monitoring_id" name="category_monitoring_id">
                                <option value="">--Pilih--</option>
                                <?php foreach ($category_monitoring as $key => $value) : ?>
                                    <option value="<?= $value['id_category_monitoring'] ?>" <?= ($item_account['category_monitoring_id'] == $value['id_category_monitoring']) ? 'selected' : '' ?>><?= strtoupper($value['name_category_monitoring'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subcategory_account_id">Sub kategori</label>
                            <select class="form-control js-example-basic-single" id="subcategory_account_id" name="subcategory_account_id">
                                <option value="">--Pilih--</option>
                                <?php foreach ($subcategory_monitoring as $key => $value) : ?>
                                    <option value="<?= $value['id_account_subcategory'] ?>" <?= ($item_account['subcategory_account_id'] == $value['id_account_subcategory']) ? 'selected' : '' ?>><?= strtoupper($value['name_subcategory'])  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="1" <?= ($item_account['is_active']) ? 'checked' : '' ?> name="is_active">
                                Aktif
                                <i class="input-helper"></i></label>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="<?= base_url('account_item') ?>" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#category_monitoring_id").change(function() {
            console.log($('option:selected', this).val())
            $.ajax({
                url: siteUrl + "account_item/getSubCategoryByCategory",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: $('option:selected', this).val(),
                    sbu_id: $('#sbu_id').val()
                },
                success: function(results) {
                    let html = '';
                    results.forEach(element => {
                        html += `<option value="${element.id_account_subcategory}">${element.name_subcategory}</option>`;
                    });
                    $("#subcategory_account_id").empty().append(html).trigger('change');
                }
            })
        });
    });

    $('#form_edit').on('submit', function(e) {
        let form_data = new FormData($('#form_edit')[0]);
        e.preventDefault()
        $.ajax({
            url: siteUrl + "account_item/submitEdit",
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