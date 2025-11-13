<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Languages</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Languages</li>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?=($id > 0) ? 'Edit' : 'Add';?> Language</h3>
                <a href="<?=base_url('admin/languages')?>" class="btn btn-light btn-sm float-right text-dark" >
                    <i class="ion ion-arrow-left-c"></i>
                    Back
                </a>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" >
               <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="csv_file">Language Name</label>
                        <input type="text" name="data[title]" class="form-control" placeholder="Enter Language Name.." required
                        value="<?php if(isset($title)) { echo $title; } ?>" />
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="csv_file">Language Status <?=$status?></label>
                        <select class="form-control" name="data[status]" required>
                            <option value="">-- Select Status --</option>
                            <option value="1" <?= ($status == 1) ? 'selected' : ''?> >Enable</option>
                            <option value="2" <?= ($status == 2) ? 'selected' : ''?> >Disable</option>
                        </select>
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
            <?php if($this->session->flashdata('message')): ?>
              <div class="alert alert-success">
                <?= $this->session->flashdata('message') ?>
              </div>    
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('includes/footer') ?>