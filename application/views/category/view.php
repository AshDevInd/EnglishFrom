<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Category</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Category</li>
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
            <a class="btn btn-light btn-sm float-right text-dark" href='<?= base_url('admin/category/add') ?>'>
                <i class="ion ion-plus"></i>
                    Add Category
                </a>
          </div>
            <div class="card-body">
              <?php if (!empty($cats)): ?>
              <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Status</th>
                    <!-- <th width="300">Audio</th> -->
                    <th width="50">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cats as $v): ?>
                  <tr>
                    <td><?= $v['id'] ?></td>
                    <td>
                      <div><b><?=$v['cat_name']?></b></div>
                    </td>
                     <td>
                      <div><b><?=$v['pname'] ? $v['pname'] : '--'?></b></div>
                    </td>
                    <td>
                        <?=($v['status'] == 1) ? 'Active' : 'Inactive'; ?>
                    </td>
                    <td>
                      <a href="<?=base_url('admin/category/edit/'.$v['id'])?>" class="btn btn-sm btn-info" >
                        <i class="ion ion-edit"></i>
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

<script>
  $(document).ready(function() {
    $(".del-row").click(function(){
      let tr = $(this).closest('tr');
      let id = $(this).attr('data-id');

        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type:'post',
              url:'<?=base_url('admin/vowels/delrow')?>',
              data:"id="+id,
              success: function() {
                tr.fadeOut();
              }
            })
          }
        });
   
    })
  })
</script>
<?php $this->load->view('includes/footer') ?>