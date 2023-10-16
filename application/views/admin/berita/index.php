<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <?php if ($this->session->flashdata('flash')) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berita <strong>berhasil</strong>
                <?= $this->session->flashdata('flash'); ?>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>
            <form action="<?= base_url('admin/import_excel'); ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="upload_file" id="upload_file" class="form-control" accept=".csv, .xlsx, .xls">
              </div>
              <div class="form-group">
                <a class="btn btn-primary" href="<?= base_url('admin/export_excel'); ?>" target="_blank">Export Excel</a>
              </div>
            </form>
            <table class="table table-bordered table-stripedc:\xampp\htdocs\ci3-test\application\controllers\admin.php">
              <thead>
                <tr>
                  <th>No</th>
                  <th class="col-2">Judul</th>
                  <th class="col-4">Isi</th>
                </tr>
              </thead>
              <?php
              foreach ($konten as $brt) : ?>
                <tbody>
                  <tr>
                    <td><?= ++$start; ?></td>
                    <td><?= $brt->judul ?></td>
                    <td><?= htmlspecialchars_decode($brt->isi) ?></td>
                  </tr>
                </tbody>
              <?php endforeach ?>
            </table>
            <?= $this->pagination->create_links(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>