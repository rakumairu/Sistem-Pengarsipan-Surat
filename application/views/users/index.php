<h2 style="margin-bottom:8px">Daftar Pengguna</h2>

<div class="d-inline">
  <a class="btn btn-primary" href="<?php base_url(); ?>users/create" style="margin-bottom:12px;">Tambah Pengguna</a>
</div>

<div id="table-data" style="overflow-x:scroll">
  <table class="table table-sm table-striped table-bordered table-hover" id="table-utama">
    <thead>
      <tr>
        <th class="align-middle" scope="col">No</th>
        <th class="align-middle" scope="col">Username</th>
        <th class="align-middle" scope="col">Level</th>
        <th class="align-middle" scope="col">Display Name</th>
        <th class="align-middle" scope="col">Email</th>
      </tr>
    </thead>
    <?php $no = 1; ?>
    <tbody>
      <?php foreach($users as $user): ?>
        <tr>
          <td><?php echo $no; $no++; ?></td>
          <td><?php echo $user['username']; ?></td>
          <td><?php
          if ($user['level'] == 1) {
            echo 'Petugas';
          } elseif ($user['level'] == 3) {
            echo 'Administrator';
          } elseif ($user['level'] == 2) {
            echo 'Kepala Dinas';
          } ?>
          </td>
          <td><?php echo $user['display_name']; ?></td>
          <td><?php echo $user['email']; ?></td>
          <td>
            <div class="btn-group-vertical btn-group-sm" role="group">
              <?php // Modal delete ?>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $user['username']; ?>">Hapus</button>

              <div class="modal fade" id="modalDelete<?php echo $user['username']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalDeleteLabel">Hapus Pengguna <?php echo $user['username']; ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php echo form_open('users/delete/'.$user['username']); ?>
                      <p>Anda yakin ingin menghapus pengguna <?php echo $user['username']; ?></p>
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
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
