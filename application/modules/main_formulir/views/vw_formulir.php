<?= empty($forms) ? '<h1 class="text-center">Oppss... item monitoring belum tersedia</h1><img src="' . base_url('assets/images/icon_404.png') . '" alt="" width="80px" class="mx-auto d-block mb-5">' : '' ?>
<div class="row mt-3 <?= (empty($forms)) ? 'd-none' : '' ?>">
    <div class="col-12">
        <div class="table-responsive">
            <table id="subcategory_table" class="display expandable-table table-bordered" style="width:100%">
                <thead>
                    <tr style="text-align: center">
                        <th style="width:7%">Aksi</th>
                        <th style="width: 20%">Action plan</th>
                        <th style="width: 8%">Status</th>
                        <th style="width: 8%">PIC</th>
                        <th style="width:5%">Tanggal mulai</th>
                        <th style="width:5%">Tanggal selesai</th>
                        <th style="width: 7%">Satuan target</th>
                        <th style="width: 5%">Target</th>
                        <th style="width: 5%">Realisasi</th>
                        <th style="width: 15%">% Reaslisasi</th>
                        <th style="width:10%">Catatan</th>
                    </tr>
                </thead>
                <form action="">
                    <tbody>
                        <?php foreach ($forms as $key => $value) : ?>
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
                                <?php
                                $percentage = $value_list['percentage'];
                                $progressBarClass = '';
                                if ($percentage < 50) {
                                    $progressBarClass = 'bg-danger';
                                } elseif ($percentage >= 50 && $percentage <= 74) {
                                    $progressBarClass = 'bg-warning';
                                } else {
                                    $progressBarClass = 'bg-success';
                                }
                                ?>
                                <tr>
                                    <td>
                                        <div class="text-center">
                                            <a href="<?= ($value_list['link_dokumen']) ? $value_list['link_dokumen'] : '#' ?>" class="btn btn-info btn-sm text-center my-1 <?= (!$value_list['link_dokumen']) ? 'disabled' : '' ?>" type="button" title="unduh dokumen"><i class="ti-receipt"></i></a>
                                            <button class="btn btn-success btn-sm text-center my-1" type="button" title="edit data"><i class="ti-settings" onclick="fnEdit(`<?= $value_list['uuid'] ?>`)"></i></button>
                                            <button onclick="fnDelete(`<?= $value_list['uuid'] ?>`)" class="btn btn-danger btn-sm text-center my-1" type="button" title="hapus"><i class="ti-brush-alt"></i></button>
                                        </div>
                                    </td>
                                    <td class="wrap-text"><?= $value_list['name_tools'] ?></td>
                                    <td class="text-center">
                                        <span class="bg-<?= $value_list['color'] ?> text-white p-1 rounded">
                                            <?= $value_list['status_name'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold">
                                        <?= ($value_list['pic_name'] ? $value_list['pic_name'] : 'Belum diset')  ?>
                                    </td>
                                    <td class="text-center"><?= ($value_list['start_date']) ? tgl_format_indo($value_list['start_date']) : '' ?></td>
                                    <td class="text-center"><?= ($value_list['end_date']) ? tgl_format_indo($value_list['end_date']) : ''  ?></td>
                                    <td class="text-center"><?= $value_list['ukuran_satuan'] ?></td>
                                    <td class="text-center"><?= $value_list['target_rate'] ?></td>
                                    <td class="text-center"><?= $value_list['actual'] ?></td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width:<?= ($value_list['percentage'] > 0)  ? $value_list['percentage'] . '%' : '%' ?>"><?= ($value_list['percentage'] > 0) ? $value_list['percentage'] . '%' : '0%'  ?></div>
                                        </div>
                                    </td>
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