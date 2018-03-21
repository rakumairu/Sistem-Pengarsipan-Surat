<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Demaspira Aulia">
    <meta name="linked-in:" content="https://www.linkedin.com/in/demaspira-aulia-0a943111b/">
    <meta name="github:" content="https://github.com/noobDedem">

    <title><?= $title; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/icons/icon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles_new.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themes.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome-all.css">
    <script type="text/javascript">

    </script>
  </head>
  <body>
  <?php // Sidenav ?>
  <div class="sideNav" id="sideNav">
    <div class="list-group">
      <div class="list-group-item" id="title">
        <h5 class="text-center">Arsip Surat</h5>
      </div>
      <a href="<?php echo base_url(); ?>settings">
        <div class="list-group-item" id="account">
          <div style="display:inline-block" class="align-top"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;</div>
          <div style="display:inline-block"><p class="text-muted">Selamat datang,</p> <?php echo $this->session->userdata('display_name'); ?></div>
        </div>
      </a>
      <?php //Admin Part ?>
      <?php if($this->session->userdata('level') == 3): ?>
        <a href="<?php echo base_url(); ?>users" class="list-group-item <?php
          if(isset($menu))
          {
            if ($menu == 'users') {echo 'active';}
          }
          ?>"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;Pengguna</a>
      <?php endif; ?>
      <?php //Petugas part ?>
      <?php if($this->session->userdata('level') == 1): ?>
        <a href="<?php echo base_url(); ?>suratmasuk" class="list-group-item <?php
          if(isset($menu))
          {
            if ($menu == 'surat_masuk') {echo 'active';}
          }
          ?>"><span class="fas fa-cloud-download-alt"></span>&nbsp;&nbsp;&nbsp;Surat Masuk</a>
        <a href="<?php echo base_url(); ?>suratkeluar" class="list-group-item
          <?php
          if(isset($menu))
          {
            if ($menu == 'surat_keluar') {echo 'active';}
          }
          ?>"><span class="fas fa-cloud-upload-alt"></span>&nbsp;&nbsp;&nbsp;Surat Keluar</a>
      <?php // Kepdin Part ?>
      <?php elseif($this->session->userdata('level') == 2): ?>
        <a href="<?php echo base_url(); ?>suratmasuk" class="list-group-item <?php
        if(isset($menu))
        {
          if ($menu == 'surat_masuk') {echo 'active';}
        }
        ?>"><span class="fas fa-cloud-download-alt"></span>&nbsp;&nbsp;&nbsp;Surat Masuk</a>
      <?php endif; ?>
      <a href="<?php echo base_url(); ?>logout" class="list-group-item"><span class="fas fa-sign-out-alt"></span>&nbsp;&nbsp;&nbsp;Keluar</a>
    </div>
  </div>

  <?php // Content ?>
  <div id="main">
    <?php // Header ?>
    <div id="top">
      <div id="hamburger" class="open" onclick="navButton()" style="display:inline">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <h5 class="text-left" style="display:inline"><?php
      if(isset($icon))
      {
        echo $icon;
      }
      ?>&nbsp;&nbsp;&nbsp;<?= $title; ?></h5>
    </div>

    <div id="content-utama">
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
