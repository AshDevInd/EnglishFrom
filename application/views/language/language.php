<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Languages</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Languages</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <?php if ($this->session->flashdata('message')): ?>
      <div class="alert alert-success">
        <i class="ion ion-checkmark"></i> &nbsp;
        <?= $this->session->flashdata('message') ?>
      </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger">
        <i class="ion ion-close"></i> &nbsp;
        <?= $this->session->flashdata('error') ?> 
      </div>
      <?php endif; ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">List of Languages</h3>
                <a class="btn btn-light btn-sm float-right text-dark" href='<?= base_url('admin/languages/add') ?>'>
                <i class="ion ion-plus"></i>
                    Add Language
                </a>   
            </div>
            <div class="card-body">
              <?php if (!empty($languages)): ?>
                <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                  <thead>
                    <tr>
                      <th>Language</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($languages as $row): ?>
                      <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?php
                          if($row['status'] == 1) {
                            echo "Enable";
                          } else {
                            echo "Disable";
                          } 
                        ?></td>

                        <td>

                        <a class="btn btn-info btn-sm" href='<?= base_url('admin/languages/edit/'.$row['id']) ?>'>
                            <i class="ion ion-edit"></i>
                            Edit
                            </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php else: ?>
                <p>No records found in the Vowels table.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('includes/footer') ?>