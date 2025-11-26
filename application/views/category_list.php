<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Khmer Categories</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Khmer Categories</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Category</h3>
            <a class="btn btn-light btn-sm float-right text-dark" href='<?= site_url('admin/admin_category/create'); ?>'>
                <i class="ion ion-plus"></i>
                    Add Category
                </a>
          </div>
            <div class="card-body">
              <?php if (!empty($categories)): ?>
              <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    
                    <!-- <th width="300">Audio</th> -->
                    <th width="50">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($categories as $cat): ?>
                  <tr>
                    <td><?= $cat['id']; ?></td>
                    <td>
                      <div><b><?= $cat['name']; ?></b></div>
                    </td>
                     
                    
                    <td>
                      <a href="<?= site_url('admin/admin_category/edit/' . $cat['id']); ?>" class="btn btn-sm btn-info" >
                        <i class="ion ion-edit"></i>
                      </a>
                    </td>
            
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <?php else: ?>
                <p>No records found.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<?php $this->load->view('includes/footer') ?>