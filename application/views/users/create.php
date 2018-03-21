<h2>Tambah Pengguna</h2>
<?php echo form_open_multipart('users/create'); ?>
  <div class="form-group">
    <label>Username</label>
    <input class="form-control
    <?php
    if (form_error('username','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="username" placeholder="Username"
    value="<?php
    if(isset($_POST['username']))
    {
      echo $_POST['username'];
    }
    ?>">
    <?php echo form_error('username','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Kata Sandi</label>
    <input class="form-control
    <?php
    if (form_error('password','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="password" name="password" placeholder="Kata sandi"
    value="<?php
    if(isset($_POST['password']))
    {
      echo $_POST['password'];
    }
    ?>">
    <?php echo form_error('password','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Konfirmasi Kata Sandi</label>
    <input class="form-control
    <?php
    if (form_error('password_conf','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="password" name="password_conf" placeholder="Konfirmasi kata sandi"
    value="<?php
    if(isset($_POST['password_conf']))
    {
      echo $_POST['password_conf'];
    }
    ?>">
    <?php echo form_error('password_conf','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Jabatan</label>
    <select class="form-control <?php
    if (form_error('level','','')) {
      echo "is-invalid";
    }
    ?>" name="level">
      <option value="0">--Silahkan pilih jabatan pengguna--</option>
      <option value="3"<?php
      if (isset($_POST['level'])) {
        if ($_POST['level'] == 3) {
          echo 'selected';
        }
      }
      ?>>Admin</option>
      <option value="1"<?php
      if (isset($_POST['level'])) {
        if ($_POST['level'] == 1) {
          echo 'selected';
        }
      }
      ?>>Petugas</option>
      <option value="2"<?php
      if (isset($_POST['level'])) {
        if ($_POST['level'] == 2) {
          echo 'selected';
        }
      }
      ?>>Kepala Dinas</option>
    </select>
    <?php echo form_error('level','<p class="small text-danger" role="alert">','</p>'); ?>
    <!-- <input class="form-control
    <?php
    if (form_error('level','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="level" placeholder="Jabatan"
    value="<?php
    if(isset($_POST['level']))
    {
      echo $_POST['level'];
    }
    ?>">
    <?php echo form_error('level','<p class="small text-danger" role="alert">','</p>'); ?> -->
  </div>
  <div class="form-group">
    <label>Nama Tampilan</label>
    <input class="form-control
    <?php
    if (form_error('display_name','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="display_name" placeholder="Nama tampilan"
    value="<?php
    if(isset($_POST['display_name']))
    {
      echo $_POST['display_name'];
    }
    ?>">
    <?php echo form_error('display_name','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <div class="form-group">
    <label>Email</label>
    <input class="form-control
    <?php
    if (form_error('email','',''))
    {
      echo 'is-invalid';
    }
    ?>" type="text" name="email" placeholder="Email pengguna"
    value="<?php
    if(isset($_POST['email']))
    {
      echo $_POST['email'];
    }
    ?>">
    <?php echo form_error('email','<p class="small text-danger" role="alert">','</p>'); ?>
  </div>
  <button type="submit" name="button" class="btn btn-primary">Simpan</button>
<?php echo form_close(); ?>
