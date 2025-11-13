<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Archive</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Archive</li>
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
            <div class="card-header"><h3 class="card-title">Archive</h3>
            <a class="btn btn-light btn-sm float-right text-dark" href='<?= base_url('admin/archive/add') ?>'>
                <i class="ion ion-plus"></i>
                    Add Archive
                </a>
          </div>
            <div class="card-body">
              <?php if (!empty($archives)): ?>
              <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Archive Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <!-- <th width="300">Audio</th> -->
                    <th width="100">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($archives as $v): ?>
                  <tr>
                    <td><?= $v['id'] ?></td>
                    <td>
                      <div><b><?=$v['archive_name']?></b></div>
                    </td>
                    <td>
                      <div><?=$v['cat_name']?></div>
                    </td>
                    <td>
                        <?=($v['status'] == 1) ? 'Active' : 'Inactive'; ?>
                    </td>
                    <td>
                      <?php if($this->session->userdata['LoginSession']['type'] == 1 && $v['verify_sts']  == 0) { ?>
                      <a href="javascript:;" class="btn btn-sm btn-success conf" title="Approve" data-id="<?=$v['id']?>" data-path="<?=$v['path_name']?>" >
                        <i class="ion ion-checkmark"></i>
                      </a>
                      <?php } else { ?>
                      <a href="<?=base_url('admin/archive/edit/'.$v['id'])?>" class="btn btn-sm btn-info" title="Edit" >
                        <i class="ion ion-edit"></i>
                      </a>
                      <?php } ?>
                      <?php if($v['verify_sts']  == 0) { ?>
                        <a href="<?=base_url('uploads/tmp/'.$v['path_name'])?>" class="btn btn-sm btn-primary view" target="_blank" title="View Detail" >
                          <i class="ion ion-eye"></i>
                        </a>
                      <?php } else { ?>
                        <a href="<?=base_url($v['path_name'])?>" class="btn btn-sm btn-primary view" target="_blank" title="View Detail" >
                          <i class="ion ion-eye"></i>
                        </a>
                      <?php } ?>

                      <?php if($this->session->userdata['LoginSession']['type'] == 1 ) { ?>
                        <a href="javascript:;" class="btn btn-sm btn-danger del-row" title="Delete" data-id="<?=$v['id']?>" >
                          &nbsp;<i class="ion ion-ios-trash"></i>&nbsp;
                        </a>
                        <?php } ?>
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
              url:'<?=base_url('admin/archive/delrow')?>',
              data:"id="+id,
              success: function() {
                tr.fadeOut();
              }
            })
          }
        });
   
    })

    $(".conf").click(function() {
        let tr = $(this);
        let id = $(this).attr('data-id');
        let path = $(this).attr('data-path');
        let v = $(this).siblings('.view');
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Approve it!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type:'post',
              url:'<?=base_url('admin/archive/approve')?>',
              data:"id="+id,
              success: function() {
                tr.fadeOut();
                v.attr('href', '<?=base_url()?>'+path);

                 Swal.fire({
                  title: "Approved!",
                  text: "Archive has been approved.",
                  icon: "success"
                });
              }
            })
          }
        });
    })
  })
</script>
<?php $this->load->view('includes/footer') ?>