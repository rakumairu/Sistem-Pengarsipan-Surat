<h2 style="margin-bottom:0px">Daftar Surat Masuk</h2>
<p class="text-muted" style="margin-bottom:0px">Jumlah surat masuk saat ini sebanyak: <?=$jumlah; ?> surat</p>
<p class="text-muted">Jumlah surat masuk yang belum di disposisi: <?=$disposisi; ?> surat</p>

<hr>

<?php // Table Data ?>
<div id="table-data" style="overflow-x:scroll">
  <table class="table table-sm table-striped table-bordered table-hover" id="table-utama">
    <thead>
      <tr>
        <th class="align-middle" scope="col">No</th>
        <th class="align-middle" scope="col">Nomor Surat</th>
        <th class="align-middle" scope="col">Tanggal Undangan</th>
        <th class="align-middle" scope="col">Asal Surat</th>
        <th class="align-middle" scope="col">Perihal</th>
        <th class="align-middle" scope="col">Keterangan</th>
        <th class="align-middle" scope="col">Tujuan</th>
        <th class="align-middle" scope="col">Status</th>
        <th class="align-middle" scope="col">Detail</th>
        <th class="align-middle" scope="col">File</th>
        <th class="align-middle" scope="col">Disposisi</th>
        <th class="align-middle" scope="col">Petugas</th>
      </tr>
    </thead>
    <?php $no = 1; ?>
    <tbody>
      <?php foreach($surat_masuk as $surat): ?>
        <tr>
          <th scope="row"><?php echo $no;$no++; ?></th>
          <td><?php echo $surat['nomor_surat']; ?></td>
          <td><?php echo $surat['tanggal_undangan']; ?></td>
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
          <td>
            <?php if ($surat['detail_disposisi'] == '') {
              echo 'Tidak ada detail';
            } else {
              echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetail'.$surat['id'].'">Detail</button>';
            } ?>

            <?php // Modal Detail ?>
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

          </td>
          <td>
            <?php if ($surat['dokumen'] == 'nodoc') {
              echo 'Tidak tersedia';
              } else {
              echo '<a href="'
              .base_url()
              .'assets/upload/'
              .$surat['dokumen']
              .'" class="btn btn-primary" target="_blank">Unduh</a>';
              } ?>
            </td>
            <td>
              <div class="btn-group-vertical btn-group-sm" role="group">
                <?php // Modal Setuju ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAccept<?php echo $surat['id']; ?>">Setujui</button>

                <div class="modal fade" id="modalAccept<?php echo $surat['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalAcceptLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalAcceptLabel">Setujui Disposisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo form_open('suratmasuk/disposisi/'.$surat['id']); ?>
                        <div class="form-gorup">
                          <label>Detail</label>
                          <textarea class="form-control" name="detail_disposisi"></textarea>
                          <input type="hidden" name="nomor_surat" value="<?php echo $surat['nomor_surat']; ?>">
                          <input type="hidden" name="tanggal_undangan" value="<?php echo $surat['tanggal_undangan']; ?>">
                          <input type="hidden" name="asal_surat" value="<?php echo $surat['asal_surat']; ?>">
                          <input type="hidden" name="perihal" value="<?php echo $surat['perihal']; ?>">
                          <input type="hidden" name="keterangan" value="<?php echo $surat['keterangan']; ?>">
                          <input type="hidden" name="tujuan" value="<?php echo $surat['tujuan']; ?>">
                          <input type="hidden" name="dokumen" value="<?php echo $surat['dokumen']; ?>">
                          <input type="hidden" name="tanggal_data" value="<?php echo $surat['tanggal_data']; ?>">
                          <input type="hidden" name="status" value="0">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <?php echo form_close(); ?>
                      </div>
                    </div>
                  </div>
                </div>

                <?php // Modal tolak ?>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalReject<?php echo $surat['id']; ?>">Tolak</button>

                <div class="modal fade" id="modalReject<?php echo $surat['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalRejectLabel">Tolak Disposisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo form_open('suratmasuk/disposisi/'.$surat['id']); ?>
                        <div class="form-gorup">
                          <label>Detail</label>
                          <textarea class="form-control" name="detail_disposisi"></textarea>
                          <input type="hidden" name="nomor_surat" value="<?php echo $surat['nomor_surat']; ?>">
                          <input type="hidden" name="tanggal_undangan" value="<?php echo $surat['tanggal_undangan']; ?>">
                          <input type="hidden" name="asal_surat" value="<?php echo $surat['asal_surat']; ?>">
                          <input type="hidden" name="perihal" value="<?php echo $surat['perihal']; ?>">
                          <input type="hidden" name="keterangan" value="<?php echo $surat['keterangan']; ?>">
                          <input type="hidden" name="tujuan" value="<?php echo $surat['tujuan']; ?>">
                          <input type="hidden" name="dokumen" value="<?php echo $surat['dokumen']; ?>">
                          <input type="hidden" name="tanggal_data" value="<?php echo $surat['tanggal_data']; ?>">
                          <input type="hidden" name="status" value="2">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <?php echo form_close(); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td><?php echo $surat['display_name']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
