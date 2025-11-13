<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1 class="m-0">Vocab Vowels</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Vocabs Vowels</li>
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
            <div class="card-header"><h3 class="card-title">Vocab Vowels</h3>
            <a class="btn btn-light btn-sm float-right text-dark" href='<?= base_url('admin/vowels/add') ?>'>
                <i class="ion ion-plus"></i>
                    Add Vowel
                </a>
          </div>
            <div class="card-body">
              <?php if (!empty($vowels)): ?>
              <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Language</th>
                    <th>Translation</th>
                    <th>Roman</th>
                    <th width="300">Audio</th>
                    <th width="50">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($vowels as $v): ?>
                  <tr>
                    <td><?= $v['id'] ?></td>
                    <td>
                      <div><b>English</b></div>
                      <?php foreach ($v['langs'] as $lang) { ?>
                        <div><?=$lang['lang_name']?></div>
                    <?php } ?>
                    </td>
                    <td>
                      <div><b><?=$v['eng_word']?></b></div>
                    <?php
                      foreach ($v['langs'] as $lang) { ?>
                        <div><?=$lang['lang_word']?></div>
                    <?php } ?>
                    </td>
                     <td>
                      <div><b><?=$v['rom_word']?></b></div>
                      <?php
                        foreach ($v['langs'] as $lang) { ?>
                          <div><?=$lang['rom_word']?></div>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if($v['audio_file']) { ?>
                        <div>
                          <audio id="<?=$v['id']?>" src="<?=base_url('uploads/audio/'.$v['audio_file'])?>" controls ></audio>
                        </div>
                      <?php } ?>
                      <?php
                        foreach ($v['langs'] as $lang) { ?>
                        <?php if($lang['audio_file']) { ?>
                          <div>
                            <audio id="<?=$v['id']?>" src="<?=base_url('uploads/audio/'.$lang['audio_file'])?>" controls ></audio>
                          </div>
                        <?php } ?>
                      <?php } ?>
                    </td>
                    <td>
                      <a href="javascript:;" class="btn btn-danger del-row" data-id="<?=$v['id']?>" >
                        <i class="ion ion-ios-trash"></i>
                      </a>
                    </td>
                    <!-- <td>
                      <?= $v[$lang] ?>
                      <div class="controls">
                        <button id="recordBtn_<?= $inputId ?>" onclick="startRecording('<?= $inputId ?>')">🎙️</button>
                        <button id="stopBtn_<?= $inputId ?>" onclick="stopRecording('<?= $inputId ?>')" disabled>⏹️</button>
                        <button onclick="playPreview('<?= $inputId ?>')">▶️</button>
                        <button id="saveBtn_<?= $inputId ?>" onclick="saveRecordingVowel('<?= $inputId ?>', <?= $v['id'] ?>, '<?= $audioField ?>')" disabled>💾</button>
                        <button id="resetBtn_<?= $inputId ?>" onclick="resetRecording('<?= $inputId ?>')" disabled>🔄</button>
                        <?php if (!empty($v[$audioField])): ?>
                          <button onclick="deleteRecordingGeneric('vowels', <?= $v['id'] ?>, '<?= $audioField ?>', '<?= $inputId ?>')">🗑️</button>
                        <?php endif; ?>
                      </div>
                      <audio id="audio_<?= $inputId ?>" controls 
                             style="display: <?= !empty($v[$audioField]) ? 'block' : 'none' ?>; margin-top:10px; width:100%;" 
                             src="<?= !empty($v[$audioField]) ? base_url('uploads/audio/'.$v[$audioField]) : '' ?>"></audio>
                    </td> -->

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