<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Demaspira Aulia">
    <meta name="linked-in:" content="https://www.linkedin.com/in/demaspira-aulia-0a943111b/">
    <meta name="github:" content="https://github.com/noobDedem">

    <title>Arsip Surat</title>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/icons/icon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themes.css">
  </head>
  <?php // FIXME: diubah jadi statis?>
  <?php // FIXME: ganti css nya ?>
  <?php if ($this->session->flashdata('success')||$this->session->flashdata('failed')) {
    echo '<body class="body-flashdata body-login">';
  } else {
    echo '<body class="body body-login">';
  } ?>
    <?php // Main container ?>
  	<div class="row">
  		<div class="col-md-4 offset-md-4">
        <?php //flash message ?>
        <?php //success ?>
        <?php if($this->session->flashdata('success')) : ?>
          <?php echo
            '<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="modalSuccessLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color:#d4edda">
                  <div class="modal-body">
                    <p class="text-success text-center" style = "margin-top:16px">'.$this->session->flashdata("success").'</p>
                  </div>
                </div>
              </div>
            </div>'
          ?>
        <?php endif; ?>

        <?php //failed ?>
        <?php if($this->session->flashdata('failed')) : ?>
          <?php echo
            '<div class="modal fade" id="failed" tabindex="-1" role="dialog" aria-labelledby="modalFailedLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color:#fff3cd">
                  <div class="modal-body">
                    <p class="text-warning text-center" style = "margin-top:16px">'.$this->session->flashdata("failed").'</p>
                  </div>
                </div>
              </div>
            </div>'
          ?>
        <?php endif; ?>

        <?php // Login card ?>
        <div class="card text-center">
          <?php // Card Header ?>
          <h4 class="card-header"><strong>Arsip Surat</strong></h4>
          <?php // Card Body ?>
          <div class="card-body">
            <?php // Login form ?>
            <?php echo form_open('login'); ?>
              <div class="form-group">
                <input class="form-control" placeholder="Nama pengguna" name="username" type="text" autofocus="">
                <?php echo form_error('username','<p class="small text-danger" role="alert">','</p>'); ?>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Kata sandi" name="password" type="password">
                <?php echo form_error('password','<p class="small text-danger" role="alert">','</p>'); ?>
              </div>
              <button class="btn btn-primary btn-block" type="submit">Masuk</button>
            <?php echo form_close(); ?>
          </div>
          <?php // Footer ?>
          <div class="card-footer text-muted">
            <a href="http://www.semarangkab.go.id/skpd/disdik/" target="_blank">Dinas Pendidikan Kabupaten Semarang</a>
          </div>
        </div>
  		</div>
  	</div>
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
  </body>
</html>
