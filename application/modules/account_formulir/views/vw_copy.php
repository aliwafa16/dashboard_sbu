<div class="content-wrapper">
    <form id="form_copy" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title text-center">Sumber data</p>
                        <select class="form-control js-example-basic-single" id="sumber_data" name="sumber_data" required>
                            <option value="">--Pilih--</option>
                            <option value="0">MASTER DATA</option>
                            <?php foreach ($sbu as $key => $value) : ?>
                                <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title text-center">Tujuan data</p>
                        <select class="form-control js-example-basic-single" id="tujuan_data" name="tujuan_data" required>
                            <option value="">--Pilih--</option>
                            <?php foreach ($sbu as $key => $value) : ?>
                                <option value="<?= $value['id_sbu'] ?>"><?= strtoupper($value['name_sbu'])  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-1">
                <button type="submit" class="btn btn-primary">Copy</button>
            </div>
        </div>
    </form>
</div>

<script>
    $('#form_copy').on('submit', function(e) {
        e.preventDefault(); // Menambahkan prevent default untuk mencegah perilaku default
        let form_data = new FormData($('#form_copy')[0]);
        cuteAlert({
            type: "question",
            title: 'Yakin melanjutkan mengcopy data ?',
            message: 'Data akan dicopy secara keseluruhan',
            confirmText: 'Lanjutkan',
            cancelText: 'Batal'
        }).then((e) => {
            if (e === "confirm") {
                $.ajax({
                    url: siteUrl + 'account_item/submitCopy',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: form_data,
                    dataType: 'JSON',
                    success: function(results) {
                        // console.log(results)
                        if (results.code != 200) {
                            errors(results)
                        } else {
                            success(results)
                        }
                    }
                })
            } else {
                console.log('gakjadi')
            }
        })
    })
</script>