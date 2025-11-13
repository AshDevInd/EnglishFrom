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
            <div class="card-header"><h3 class="card-title">Vocab Vowels</h3></div>
            <div class="card-body">
              <?php if (!empty($vowels)): ?>
              <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Combination</th>
                    <th>Khmer</th>
                    <th>Devanagari</th>
                    <th>Roman</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($vowels as $v): ?>
                  <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= $v['combination'] ?></td>

                    <?php
                      $languages = ['khmer', 'devanagari', 'roman'];
                      foreach ($languages as $lang):
                          $audioField = $lang.'_audio';
                          $inputId = $lang.'-'.$v['id'];
                    ?>
                    <td>
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
                    </td>
                    <?php endforeach; ?>

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