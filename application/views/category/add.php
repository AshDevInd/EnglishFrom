<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <?php if($saved == 1) { ?>
          <div class="col-md-12">
            <div class="alert alert-success">
              Record saved!
            </div>
          </div>
          <?php } ?>
          <div class="col-sm-6">
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
            <?php if($success) { ?>
              <div class="alert alert-success" >Record saved successfully!</div>
              <?php } ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?=($id > 0) ? 'Edit' : 'Add';?> Category</h3>
                <a href="<?=base_url('admin/category')?>" class="btn btn-light btn-sm float-right text-dark" >
                    <i class="ion ion-arrow-left-c"></i>
                    Back
                </a>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" >
               <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="csv_file">Category Name</label>
                        <input type="text" name="data[cat_name]" class="form-control" placeholder="Enter Category Name.." required
                        value="<?php if(isset($row)) { echo $row['cat_name']; } ?>" />
                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="csv_file">Parent Category</label>
                            <select name="data[parent]" class="form-control" required>
                                <option value="0">--- None ---</option>
                                <?php foreach ($cats as $cat) { ?>
                                    <?php if($cat['id'] != $row['id']) { ?>
                                        <option value="<?=$cat['id']?>" <?=($row['parent'] == $cat['id']) ? 'selected' : '';?>><?=$cat['cat_name']?></option>
                                    <?php } ?>
                                <?php } ?>
                                <!-- <option></option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="csv_file">Status</label>
                            <select name="data[status]" class="form-control" required>
                                <option value="">--- Select Status ---</option>
                                <option value="1" <?=($row['status'] == 1) ? 'selected' : '';?>>Active</option>
                                <option value="0" <?=(!empty($row) && $row['status'] == 0) ? 'selected' : '';?>>Inactive</option>
                                <!-- <option></option> -->
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="csv_file">Language Status <?=$status?></label>
                        <input type="file" name="ufile" class="form-control" />
                    </div>
                    </div> -->

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