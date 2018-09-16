<h2>Ubah Surat Masuk</h2>
<?php if ($this->session->flashdata('post_data')) {
  $_POST = $this->session->flashdata('post_data');
} ?>
<?php echo form_open_multipart('suratmasuk/'.$id); ?>
  <div class="form-group">
    <label>Nomor Surat</label>
    <input class="form-control <?php
    if (form_error('nomor_surat','','')) {
      echo 'is-invalid';
    }
    ?>" type="text" name="nomor_surat" placeholder="Nomor surat"
    value="<?php
    if(isset($_POST['nomor_surat']))
    {
      echo $_POST['nomor_surat'];
    }
    else
    {
      echo $surat_masuk['nomor_surat'];
    }
    ?>">
    <?php echo form_error('nomor_surat','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Tanggal Undangan</label>
    <input class="form-control <?php
    if (form_error('tanggal_undangan','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="date" name="tanggal_undangan" placeholder="Tanggal undangan" max="<?php echo date('Y-m-d'); ?>"
    value="<?php
    if(isset($_POST['tanggal_undangan']))
    {
      echo $_POST['tanggal_undangan'];
    }
    else
    {
      echo $surat_masuk['tanggal_undangan'];
    }
    ?>">
    <?php echo form_error('tanggal_undangan','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Asal Surat/ Undangan</label>
    <textarea class="form-control <?php
    if (form_error('asal_surat','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="asal_surat" placeholder="Asal surat/ undangan"><?php
    if(isset($_POST['asal_surat']))
    {
      echo $_POST['asal_surat'];
    }
    else
    {
      echo $surat_masuk['asal_surat'];
    }
    ?></textarea>
    <?php echo form_error('asal_surat','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Perihal</label>
    <textarea class="form-control <?php
    if (form_error('perihal','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="perihal" placeholder="Perihal surat"><?php
    if(isset($_POST['perihal']))
    {
      echo $_POST['perihal'];
    }
    else
    {
      echo $surat_masuk['perihal'];
    }
    ?></textarea>
    <?php echo form_error('perihal','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Keterangan</label>
    <textarea class="form-control <?php
    if (form_error('keterangan','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="keterangan" placeholder="Keterangan surat"><?php
    if(isset($_POST['keterangan']))
    {
      echo $_POST['keterangan'];
    }
    else
    {
      echo $surat_masuk['keterangan'];
    }
    ?></textarea>
    <?php echo form_error('keterangan','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Tujuan</label>
    <input class="form-control <?php
    if (form_error('tujuan','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="tujuan" placeholder="Tujuan surat"
    value="<?php
    if(isset($_POST['tujuan']))
    {
      echo $_POST['tujuan'];
    }
    else
    {
      echo $surat_masuk['tujuan'];
    }
    ?>">
    <?php echo form_error('tujuan','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Dokumen</label><br>
    <input class="hidden" type="file" name="dokumen_new" id="upload-file">
    <?php
    if($this->session->flashdata('upload_error')) : ?>
      <?php echo $this->session->flashdata('upload_error'); ?>
    <?php endif; ?>
    <div class="text-muted">
      <small>(jenis file yang diperbolehkan adalah jpg, png, doc, docx atau pdf)</small>
    </div>
  </div>
  <input type="hidden" name="dokumen" value="<?php echo $surat_masuk['dokumen']; ?>">
  <input type="hidden" name="tanggal_data" value="<?php echo $surat_masuk['tanggal_data']; ?>">
  <input type="hidden" name="status" value="1">
  <input type="hidden" name="detail_disposisi" value="<?php echo $surat_masuk['detail_disposisi']; ?>">
  <input type="hidden" id="username" name="username" value="<?php echo $this->session->userdata('username');?>">
  <button type="submit" name="button" class="btn btn-primary">Simpan</button>
  <?php echo form_close(); ?>
