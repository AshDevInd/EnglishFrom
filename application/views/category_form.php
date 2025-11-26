<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <?php if ($saved == 1) { ?>
          <div class="col-md-12">
            <div class="alert alert-success">
              Record saved!
            </div>
          </div>
        <?php } ?>
        <div class="col-sm-6">
          <h1 class="m-0">Khmer Category</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Khmer Category</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php if ($success) { ?>
            <div class="alert alert-success">Record saved successfully!</div>
          <?php } ?>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><?= ($id > 0) ? 'Edit' : 'Add'; ?> Khmer Category</h3>
              <a href="<?= base_url('admin/admin_category') ?>" class="btn btn-light btn-sm float-right text-dark">
                <i class="ion ion-arrow-left-c"></i>
                Back
              </a>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="csv_file">Category Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter Category Name.." required
                        value="<?= isset($cat) ? $cat['name'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="csv_file">Vowel</label>
                      <input type="text" name="vowel" class="form-control"  placeholder="Enter Vowel.." required value="<?= isset($cat) ? $cat['vowel'] : ''; ?>">
                    </div>
                  </div>
                  
                
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

          <!-- /.card -->
          <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-success">
              <?= $this->session->flashdata('message') ?>
            </div>
          <?php endif; ?>
          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
              <?= $this->session->flashdata('error') ?>
            </div>
          <?php endif; ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>





<?php $this->load->view('includes/footer') ?>