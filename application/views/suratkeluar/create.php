<h2>Tambah Surat Keluar</h2>
<?php if ($this->session->flashdata('post_data')) {
  $_POST = $this->session->flashdata('post_data');
} ?>
<?php echo form_open_multipart('suratkeluar/create'); ?>
  <div class="form-group">
    <label style="margin-bottom:0px">Nomor Surat</label>
    <p class="text-muted" style="margin-bottom:0px"><small>Nomor surat terakhir : <?php echo $nomor_surat_terakhir['nomor_surat']; ?></small></p>
    <?php
    if ($nomor_surat_terakhir['nomor_surat'] != '') {
      $array = preg_split('#/#', $nomor_surat_terakhir['nomor_surat']);
      $old_number = (int)$array[0];
    }
    ?>
    <input class="form-control <?php
    if (form_error('nomor_surat','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="nomor_surat" placeholder="Nomor surat"
    value="<?php
    if(isset($_POST['nomor_surat']))
    {
      echo $_POST['nomor_surat'];
    } elseif($nomor_surat_terakhir['nomor_surat'] != '' && $old_number != 0) {
      $num = $old_number + 1;
      $output = (string)$num;
      for ($i=1; $i < sizeof($array); $i++) {
        $output = $output . '/' . $array[$i];
      }
      echo $output;
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
    ?></textarea>
    <?php echo form_error('bidang','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Dokumen</label><br>
    <input class="hidden" type="file" name="dokumen" id="upload-file">
    <?php
    if($this->session->flashdata('upload_error')) : ?>
      <?php echo $this->session->flashdata('upload_error'); ?>
    <?php endif; ?>
    <div class="text-muted">
      <small>(jenis file yang diperbolehkan adalah jpg, png, doc, docx atau pdf)</small>
    </div>
  </div>
  <input type="hidden" id="username" name="username" value="<?php echo $this->session->userdata('username');?>">
  <button type="submit" name="button" class="btn btn-primary">Simpan</button>
  <?php echo form_close(); ?>
