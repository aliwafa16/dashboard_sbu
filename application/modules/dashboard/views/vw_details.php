 <div class="content-wrapper">
     <div class="row justify-content-center">
         <div class="col-md-12 grid-margin stretch-card">
             <div class="card">
                 <div class="card-body">
                     <p class="card-title"><?= $heading ?></p>
                     <div class="row align-items-center justify-content-between px-2">
                         <div class="col-md-6">
                             <h4 class="font-weight-bold"><?= $sbu['name_sbu'] ?></h4>
                             <span>
                                 <p class="font-weight-bold">Director : <?= $director['name'] ?></p>
                             </span>
                             <div class="">
                                 <p class="text-wrap text-justify"><?= $sbu['description'] ?></p>
                             </div>
                         </div>
                         <div class="bg-info rounded text-light py-3 col-md-4 text-center">
                             <h3 class="font-weight-bold">Target : Rp. <?= number_format($target['target'])  ?></h3>
                             <p class="m-0">Periode : <?= tgl_format_indo($target['start_date']) ?> s.d <?= tgl_format_indo($target['end_date']) ?></p>
                         </div>
                     </div>
                     <div class="row px-2 py-2">
                         <div class="col">
                             <div class="table-responsive mt-3">
                                 <table id="target_sbu_table" class="display expandable-table" style="width:100%">
                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>Nama</th>
                                             <th>Target</th>
                                             <th>Tanggal mulai</th>
                                             <th>Tanggal selesai</th>
                                             <th>Status</th>
                                         </tr>
                                     </thead>
                                 </table>
                             </div>
                         </div>
                     </div>
                     <div class="row px-2 py-2">
                         <div class="col">
                             <div class="table-responsive mt-3">
                                 <table id="produk_sbu_table" class="display expandable-table" style="width:100%">
                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>Nama produk</th>
                                             <th>Deskripsi</th>
                                             <th>Status</th>
                                         </tr>
                                     </thead>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row mt-3">
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
                                     <td class=" text-center" colspan="11" style="background-color: #CEE6F3;font-size: 1.4em;font-weight: bold;text-transform:uppercase"><?= $value['name_sbu'] ?></td>
                                 </tr>
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

                             <?php foreach ($formProduk as $key => $value) : ?>
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
 </div>

 <script>
     $(document).ready(function() {
         var table = $("#target_sbu_table");
         grid_brand = table.DataTable({
             // scrollX: true,
             // scrollCollapse: true,
             aaSorting: [],
             initComplete: function(settings, json) {},
             retrieve: true,
             processing: true,
             ajax: {
                 type: "GET",
                 url: '<?= base_url() ?>master_sbu/loadTarget/<?= $this->uri->segment(3) ?>',
                 data: function(d) {
                     no = 0;
                 },
                 dataSrc: "",
             },
             columns: [{
                     render: function(data, type, full, meta) {
                         no += 1;

                         return no;
                     },
                     className: "text-center",
                     width: "1%",
                 },
                 {
                     render: function(data, type, full, meta) {
                         return full.name_target
                     },
                     className: "text-center",
                 },
                 {
                     render: function(data, type, full, meta) {
                         return `Rp. ${numeral(full.target).format('0,0')}`;
                     },
                     className: "text-center",
                 },
                 {
                     render: function(data, type, full, meta) {
                         return moment(full.start_date).format('LL')
                     },
                     className: "wrap-text",
                 },
                 {
                     render: function(data, type, full, meta) {
                         return moment(full.end_date).format('LL')
                     },
                     className: "text-wrap",
                 },
                 {
                     render: function(data, type, full, meta) {
                         let status = '';

                         if (full.is_active == 1) {
                             status = `<button class="btn btn-success btn-sm" type="button">Aktif</button>`
                         } else {
                             status = `<button class="btn btn-danger btn-sm" type="button">Tidak Aktif</button>`

                         }
                         return status
                     },
                     className: "text-center",
                 },
             ],
         });

         var table2 = $("#produk_sbu_table");
         grid_brand2 = table2.DataTable({
             // scrollX: true,
             // scrollCollapse: true,
             aaSorting: [],
             initComplete: function(settings, json) {},
             retrieve: true,
             processing: true,
             ajax: {
                 type: "GET",
                 url: '<?= base_url() ?>master_sbu/loadProduk/<?= $this->uri->segment(3) ?>',
                 data: function(d) {
                     no = 0;
                 },
                 dataSrc: "",
             },
             columns: [{
                     render: function(data, type, full, meta) {
                         no += 1;

                         return no;
                     },
                     className: "text-center",
                     width: "1%",
                 },
                 {
                     render: function(data, type, full, meta) {
                         return full.name_product
                     },
                     className: "text-center",
                 },
                 {
                     render: function(data, type, full, meta) {
                         return full.description
                     },
                     className: "wrap-text"
                 },
                 {
                     render: function(data, type, full, meta) {
                         let status = '';

                         if (full.is_active == 1) {
                             status = `<button class="btn btn-success btn-sm" type="button">Aktif</button>`
                         } else {
                             status = `<button class="btn btn-danger btn-sm" type="button">Tidak Aktif</button>`

                         }
                         return status
                     },
                     className: "text-center",
                 },
             ],
         });
     })
 </script>