<?php // IDEA: di bikin pake AJAX ?>
<!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>user">Ubah Data</a> -->
<!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>user">Ubah Kata Sandi</a> -->

<h3>Ubah Data</h3>
<?php echo form_open('settings'); ?>
<div class="form-group">
  <label>Nama Pengguna</label>
  <input class="form-control <?php
  if (form_error('display_name1','','')) {
    echo 'is-invalid';
  }
  ?>" type="text" name="display_name" placeholder="Nama pengguna yang ditampilkan pada sidebar"
  value="<?php
  if(isset($_POST['display_name']))
  {
    echo $_POST['display_name'];
  }
  else
  {
    echo $this->session->userdata('display_name');
  }
  ?>">
  <?php echo form_error('display_name','<p class="small text-danger" role="alert">','</p>'); ?>
</div>
<div class="form-group">
  <label>Email Pengguna</label>
  <input class="form-control <?php
  if (form_error('email','','')) {
    echo 'is-invalid';
  }
  ?>" type="email" name="email" placeholder="Email yang digunakan pengguna"
  value="<?php
  if(isset($_POST['email']))
  {
    echo $_POST['email'];
  }
  else
  {
    echo $this->session->userdata('email');
  }
  ?>">
  <?php echo form_error('email','<p class="small text-danger" role="alert">','</p>'); ?>
</div>
<button type="submit" name="data" class="btn btn-primary" value="data">Simpan</button>
<?php echo form_close(); ?>

<hr>

<h3>Ubah Kata Sandi</h3>
<?php echo form_open_multipart('settings'); ?>
<div class="form-group">
  <label>Kata Sandi Lama</label>
  <input class="form-control <?php
  if (form_error('password','','')) {
    echo 'is-invalid';
  }
  ?>" type="password" name="password" placeholder="Kata sandi lama"
  value="<?php
  if(isset($_POST['password']))
  {
    echo $_POST['password'];
  }
  ?>">
  <?php echo form_error('password','<p class="small text-danger" role="alert">','</p>'); ?>
</div>
<div class="form-group">
  <label>Kata Sandi Baru</label>
  <input class="form-control <?php
  if (form_error('new_password','','')) {
    echo 'is-invalid';
  }
  ?>" type="password" name="new_password" placeholder="Kata sandi yang ingin digunakan"
  value="<?php
  if(isset($_POST['new_password']))
  {
    echo $_POST['new_password'];
  }
  ?>">
  <?php echo form_error('new_password','<p class="small text-danger" role="alert">','</p>'); ?>
</div>
<div class="form-group">
  <label>Konfirmasi Kata Sandi Baru</label>
  <input class="form-control <?php
  if (form_error('confirmation','','')) {
    echo 'is-invalid';
  }
  ?>" type="password" name="confirmation" placeholder="Isikan kembali kata sandi yang ingin digunakan"
  value="<?php
  if(isset($_POST['confirmation']))
  {
    echo $_POST['confirmation'];
  }
  ?>">
  <?php echo form_error('confirmation','<p class="small text-danger" role="alert">','</p>'); ?>
</div>
<button type="submit" name="password_button" class="btn btn-primary" value="password">Simpan</button>
<?php echo form_close(); ?>
