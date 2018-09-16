<h2>Ubah Surat Keluar</h2>
<?php if ($this->session->flashdata('post_data')) {
  $_POST = $this->session->flashdata('post_data');
} ?>
<?php echo form_open_multipart('suratkeluar/'.$id); ?>
  <div class="form-group">
    <label>Nomor Surat</label>
    <input class="form-control <?php
    if (form_error('nomor_surat','','')) {
      echo 'is-invalid';
    }
    ?>" type="text" name="nomor_surat" placeholder="Nomor surat" value="<?php
    if(isset($_POST['nomor_surat']))
    {
      echo $_POST['nomor_surat'];
    }
    else
    {
      echo $surat_keluar['nomor_surat'];
    }
    ?>">
    <?php echo form_error('nomor_surat','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Kepada</label>
    <input class="form-control <?php
    if (form_error('kepada','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="kepada" placeholder="Kepada" value="<?php
    if(isset($_POST['kepada']))
    {
      echo $_POST['kepada'];
    }
    else
    {
      echo $surat_keluar['kepada'];
    }
    ?>">
    <?php echo form_error('kepada','<p class="small text-danger" role="alert">','</p>'); ?>
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
      echo $surat_keluar['perihal'];
    }
    ?></textarea>
    <?php echo form_error('perihal','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Bidang</label>
    <textarea class="form-control <?php
    if (form_error('bidang','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="bidang" placeholder="Bidang"><?php
    if(isset($_POST['bidang']))
    {
      echo $_POST['bidang'];
    }
    else
    {
      echo $surat_keluar['bidang'];
    }
    ?></textarea>
    <?php echo form_error('bidang','<p class="small text-danger" role="alert">','</p>'); ?>
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
  <input type="hidden" name="dokumen" value="<?php echo $surat_keluar['dokumen']; ?>">
  <input type="hidden" name="tanggal_data" value="<?php echo $surat_keluar['tanggal_data']; ?>">
  <input type="hidden" id="username" name="username" value="<?php echo $this->session->userdata('username');?>">
  <button type="submit" name="button" class="btn btn-primary">Simpan</button>
  <?php echo form_close(); ?>
