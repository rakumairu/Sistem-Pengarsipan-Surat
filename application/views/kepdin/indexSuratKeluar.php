<h2 style="margin-bottom:0px">Daftar Surat Keluar</h2>
<p class="text-muted">Jumlah surat keluar saat ini sebanyak: <?=$jumlah; ?> surat</p>

<div class="d-inline" style="float:right">
  <?php echo form_open('suratkeluar/unduh'); ?>
  <input type="date" name="from" value="" max="<?php echo date('Y-m-d'); ?>" placeholder="tanggal awal">
  s/d
  <input type="date" name="till" value="" max="<?php echo date('Y-m-d'); ?>" placeholder="tanggal awal">
  <button type="submit" name="submit" class="btn btn-primary">Unduh Data</button>
  <?php echo form_close(); ?>
</div>

<div class="clearfix"></div>
<div style="float:right">
  <div class="text-muted">
    <small>(tanggal data dimasukkan, kosongkan apabila ingin mengunduh semua)</small>
  </div>
</div>

<br>
<hr>

<div id="table-data">
  <table class="table table-sm table-striped table-bordered table-hover" style="overflow: scroll" id="table-utama">
    <thead>
      <tr>
        <th class="align-middle" scope="col">No</th>
        <th class="align-middle" scope="col">Tanggal Keluar</th>
        <th class="align-middle" scope="col">Nomor Surat</th>
        <th class="align-middle" scope="col">Kepada</th>
        <th class="align-middle" scope="col">Perihal</th>
        <th class="align-middle" scope="col">Bidang</th>
        <th class="align-middle" scope="col">File</th>
        <th class="align-middle" scope="col">Petugas</th>
      </tr>
    </thead>
    <?php $no = 1; ?>
    <tbody>
      <?php foreach($surat_keluar as $surat): ?>
        <tr>
          <td style="text-align:center;"><?php echo $no; $no++; ?></td>
          <?php $tanggalKeluar = new DateTime($surat['tanggal_data']); ?>
          <td><?php echo date_format($tanggalKeluar, 'd/M/Y'); ?></td>
          <td><?php echo $surat['nomor_surat']; ?></td>
          <td><?php echo $surat['kepada']; ?></td>
          <td><?php echo $surat['perihal']; ?></td>
          <td><?php echo $surat['bidang']; ?></td>
          <td style="text-align:center;">
            <div  style="display:inline-block;">
              <?php if ($surat['dokumen'] == 'nodoc') {
                echo 'Tidak tersedia';
              } else {
                echo '<a href='
                .base_url().
                "assets/upload/"
                .$surat['dokumen'].
                ' class="btn btn-primary" target="_blank">Unduh</a>';
              } ?>
            </div>
          </td>
          <td><?php echo $surat['users_username']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
