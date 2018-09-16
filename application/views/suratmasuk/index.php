<h2 style="margin-bottom:0px">Daftar Surat Masuk</h2>
<p class="text-muted">Jumlah surat masuk saat ini sebanyak: <?=$jumlah; ?> surat</p>

<div class="d-inline">
  <a class="btn btn-primary" href="<?php base_url(); ?>suratmasuk/create">Tambah Surat Masuk</a>
</div>

<div class="d-inline" style="float:right">
  <?php echo form_open('suratmasuk/unduh'); ?>
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

<div id="table-data" style="overflow-x:scroll">
  <table class="table table-sm table-striped table-bordered table-hover" id="table-utama">
    <thead>
      <tr>
        <th class="align-middle" scope="col">No</th>
        <th class="align-middle" scope="col">Tanggal Masuk</th>
        <th class="align-middle" scope="col">Nomor Surat</th>
        <th class="align-middle" scope="col">Tanggal Undangan</th>
        <th class="align-middle" scope="col">Asal Surat</th>
        <th class="align-middle" scope="col">Perihal</th>
        <th class="align-middle" scope="col">Keterangan</th>
        <th class="align-middle" scope="col">Tujuan</th>
        <th class="align-middle" scope="col">Status</th>
        <th class="align-middle" scope="col">Detail</th>
        <th class="align-middle" scope="col">File</th>
        <th class="align-middle" scope="col">CRUD</th>
      </tr>
    </thead>
    <?php $no = 1; ?>
    <tbody>
      <?php foreach($surat_masuk as $surat): ?>
        <tr>
          <td style="text-align:center;"><?php echo $no; $no++; ?></td>
          <?php $tanggalMasuk = new DateTime($surat['tanggal_data']); ?>
          <td><?php echo date_format($tanggalMasuk, 'd/M/Y'); ?></td>
          <td><?php echo $surat['nomor_surat']; ?></td>
          <?php $tanggalUndangan = new DateTime($surat['tanggal_undangan']); ?>
          <td><?php echo date_format($tanggalUndangan, 'd/M/Y'); ?></td>
          <td><?php echo $surat['asal_surat']; ?></td>
          <td><?php echo $surat['perihal']; ?></td>
          <td><?php echo $surat['keterangan']; ?></td>
          <td><?php echo $surat['tujuan']; ?></td>
          <td><?php if ($surat['status'] == 1) {
              echo 'Belum di disposisi';
            } elseif ($surat['status'] == 0) {
              echo 'Sudah di disposisi';
            } elseif ($surat['status'] == 2) {
              echo 'Ditolak';
            } ?>
          </td>
          <td style="text-align:center;">
            <div style="display:inline-block;">
              <?php if ($surat['detail_disposisi'] == '') {
                echo 'Tidak ada detail';
              } else {
                echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDetail'.$surat['id'].'">Detail</button>';
              } ?>
            </div>
          </td>
          <?php // Modal detail ?>
          <div class="modal fade" id="modalDetail<?php echo $surat['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalDetailLabel">Detail Disposisi</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p><?php echo $surat['detail_disposisi']; ?></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
          </div>
          <td style="text-align:center;">
            <div style="display:inline-block;">
              <?php if ($surat['dokumen'] == 'nodoc') {
                echo 'Tidak tersedia';
              } else {
                echo '<a href="'
                .base_url()
                .'assets/upload/'
                .$surat['dokumen']
                .'" class="btn btn-primary btn-sm" target="_blank">Unduh</a>';
              } ?>
            </div>
            </td>
            <td style="text-align:center;">
              <?php if($surat['status'] != 0): ?>
                <div class="btn-group-vertical btn-group-sm content" role="group" style="display:inline-block;">
                  <a href="<?php echo base_url(); ?>suratmasuk/<?php echo $surat['id']; ?>" class="btn btn-warning">Ubah</a>

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
                          <?php echo form_open('suratmasuk/delete/'.$surat['id']); ?>
                          <p>Anda yakin ingin menghapus data surat masuk <?php echo $surat['nomor_surat']; ?></p>
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
            <?php else: echo "Tidak dapat diubah"; ?>
            <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
