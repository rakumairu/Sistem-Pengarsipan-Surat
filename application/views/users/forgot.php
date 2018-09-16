<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Demaspira Aulia">
    <meta name="github:" content="https://github.com/noobDedem">

    <title>Lupa Kata Sandi</title>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/icons/icon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css">
  </head>
  <body>
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
            <div class="modal-content" style="background-color:#f8d7da">
              <div class="modal-body">
                <p class="text-danger text-center" style = "margin-top:16px">'.$this->session->flashdata("failed").'</p>
              </div>
            </div>
          </div>
        </div>'
      ?>
    <?php endif; ?>
    <?php if (form_error('email','','')): ?>
      <?php echo
        '<div class="modal fade" id="failed" tabindex="-1" role="dialog" aria-labelledby="modalFailedLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color:#f8d7da">
              <div class="modal-body" style="padding:0">
                '.form_error('email','<p class="text-danger text-center" style = "margin-top:16px">','</p>').'
              </div>
            </div>
          </div>
        </div>'
      ?>
    <?php endif; ?>
    <div class="row">
      <div class="col-md-4">
        <div id="container">
          <p>Silahkan tuliskan email anda, anda akan dikirimkan link untuk mereset password anda</p>
          <?php echo form_open('forgot'); ?>
          <div class="form-group">
            <input class="form-control <?php
            if (form_error('email','','')) {
              echo 'is-invalid';
            }
            ?>" type="email" name="email" value="<?php
            if (isset($_POST['email'])) {
              echo $_POST['email'];
            }
            ?>" placeholder="Email">
          </div>
          <button class="btn btn-outline-primary btn-block" type="submit" name="button">Kirim</button>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
  </body>
</html>
