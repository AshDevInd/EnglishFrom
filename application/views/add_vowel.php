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
            <h1 class="m-0">Vowel</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vowel</li>
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
                <h3 class="card-title"><?=($id > 0) ? 'Edit' : 'Add';?> Vowel</h3>
                <a href="<?=base_url('admin/vowels')?>" class="btn btn-light btn-sm float-right text-dark" >
                    <i class="ion ion-arrow-left-c"></i>
                    Back
                </a>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" >
               <div class="card-body">
                <div class="row">
                    <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="csv_file">E Name</label>
                        <input type="text" name="data[title]" class="form-control" placeholder="Enter Language Name.." required
                        value="<?php if(isset($title)) { echo $title; } ?>" />
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="csv_file">Language Status <?=$status?></label>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="csv_file">Language Status <?=$status?></label>
                    </div>
                    </div> -->

                    <table class="table table-bordered">
                        <tr>
                            <th>Language</th>
                            <th>Word</th>
                            <th>Roman</th>
                            <th>Audio</th>
                        </tr>
                        </tr>
                        <tr>
                            <td>English</td>
                            <td><input type="text" name="data[eng_word]" class="form-control" placeholder="Enter Combination.." required
                                value="<?php if(isset($combination)) { echo $combination; } ?>" /></td>
                            <td><input type="text" name="data[rom_word]" class="form-control" placeholder="Enter Roman.." required
                                value="<?php if(isset($roman)) { echo $roman; } ?>" /></td>
                            <td><input type="file" name="english_audio" class="form-control" /></td>
                        </tr>
                        <?php foreach($languages as $language): ?>
                        <tr>
                            <td><?= $language['title']; ?> 
                              <input type="hidden" name="lang_id[]" value="<?=$language['id']?>" />
                              <input type="hidden" name="lang[]" value="<?= $language['title']; ?>" />
                            </td>
                            <td><input type="text" name="word[]" class="form-control" placeholder="Enter Word.." required
                                value="<?php if(isset(${'word_'.$language['id']})) { echo ${'word_'.$language['id']}; } ?>" /></td>
                            <td><input type="text" name="roms[]" class="form-control" placeholder="Enter Roman.." required
                                value="<?php if(isset(${'roman_'.$language['id']})) { echo ${'roman_'.$language['id']}; } ?>" /></td>
                            <td><input type="file" name="audio_<?=$language['id']?>" class="form-control" /></td>
                        </tr>
                        <?php endforeach; ?>                                
                    </table>
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