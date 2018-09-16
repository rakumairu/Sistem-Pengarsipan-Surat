<h2 style="margin-bottom:0px">Daftar Surat Keluar</h2>
<p class="text-muted">Jumlah surat keluar saat ini sebanyak: <?=$jumlah; ?> surat</p>

<div class="d-inline">
  <a class="btn btn-primary" href="<?php base_url(); ?>suratkeluar/create">Tambah Surat Keluar</a>
</div>

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
        <th class="align-middle" scope="col">CRUD</th>
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
            <div style="display:inline-block;">
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
          <td style="text-align:center;">
            <div class="btn-group-vertical btn-group-sm" role="group" style="display:inline-block;">
              <a href="<?php echo base_url(); ?>suratkeluar/<?php echo $surat['id']; ?>" class="btn btn-warning">Ubah</a>

              <?php // Modal delete ?>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $surat['id']; ?>">Hapus</button>

              <div class="modal fade" id="modalDelete<?php echo $surat['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalDeleteLabel">Hapus Data <?php echo $surat['nomor_surat']; ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php echo form_open('suratkeluar/delete/'.$surat['id']); ?>
                      <p>Anda yakin ingin menghapus data surat keluar <?php echo $surat['nomor_surat']; ?></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display:inline">Batal</button>
                      <button type="submit" class="btn btn-danger" style="display:inline">Hapus</button>
                      <?php echo form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
