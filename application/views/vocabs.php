<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Vocabs</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Vocabs</li>
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
            <div class="card-header">
              <h3 class="card-title">Vocabs</h3>
              <a class="btn btn-light btn-sm float-right text-dark" href='<?= site_url('admin/vocabs/create'); ?>'>
                <i class="ion ion-plus"></i>
                Add Vocabs
              </a>
            </div>
            <div class="card-body">
              <?php if (!empty($vocabs)): ?>
                <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                  <thead>
                    <tr>
                      <th>Vowel</th>
                      <th>Combination</th>
                      <th class="no-sort">Khmer</th>
                      <th class="no-sort">My Version</th>
                      <th>Devanagari</th>
                      <th>Roman</th>
                      <th>IPA</th>
                      <th class="no-sort" width="50">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($vocabs as $row): ?>
                      <tr>
                        <td><?= htmlspecialchars($row['vowel']) ?></td>
                        <td><?= htmlspecialchars($row['combination']) ?></td>

                        <?php
                        $languages = ['khmer'];
                        foreach ($languages as $lang):
                          $audioField = $lang . '_audio';
                          $inputId = $lang . '-' . $row['id'];
                        ?>
                          <td>
                            <?= $row[$lang] ?>
                            <div class="controls">
                              <?php /* enable if you want row‑level recording
                              <button id="recordBtn_<?= $inputId ?>" type="button" onclick="startRecording('<?= $inputId ?>')">🎙️</button>
                              <button id="saveBtn_<?= $inputId ?>" type="button" onclick="saveRecordingVocab('<?= $inputId ?>', <?= $row['id'] ?>, '<?= $audioField ?>')" disabled>💾</button>
                              <button id="resetBtn_<?= $inputId ?>" type="button" onclick="resetRecording('<?= $inputId ?>')" disabled>🔄</button>
                              <?php if (!empty($row[$audioField])): ?>
                                <button type="button" onclick="deleteRecordingGeneric('vocabs', <?= $row['id'] ?>, '<?= $audioField ?>', '<?= $inputId ?>')">🗑️</button>
                              <?php endif; ?>
                              <button id="stopBtn_<?= $inputId ?>" type="button" onclick="stopRecording('<?= $inputId ?>')" disabled>⏹️</button>
                              <button type="button" onclick="playPreview('<?= $inputId ?>')">▶️</button>
                              */ ?>
                            <audio id="audio_<?= $inputId ?>" controls style="display: <?= !empty($row[$audioField]) ? 'block' : 'none' ?>; margin-top:10px;"
                                   src="<?= !empty($row[$audioField]) ? base_url('uploads/audio/vocabs/' . $row[$audioField]) : '' ?>"></audio>
                            </div>
                          </td>
                        <?php endforeach; ?>

                        <!-- Khmer My Version audio column -->
                        <td>
                          <div class="controls">
                            <?php /* enable recording from list if you want
                            <button id="recordBtn_khmermyversion-<?= $row['id'] ?>" type="button" onclick="startRecording('khmermyversion-<?= $row['id'] ?>')">🎙️</button>
                            
                            <button id="stopBtn_khmermyversion-<?= $row['id'] ?>" type="button" onclick="stopRecording('khmermyversion-<?= $row['id'] ?>')" disabled>⏹️</button>
                            <button type="button" onclick="playPreview('khmermyversion-<?= $row['id'] ?>')">▶️</button>
                            <button id="saveBtn_khmermyversion-<?= $row['id'] ?>" type="button" onclick="saveRecordingVocab('khmermyversion-<?= $row['id'] ?>', <?= $row['id'] ?>, 'khmer_my_version_audio')" disabled>💾</button>
                            <button id="resetBtn_khmermyversion-<?= $row['id'] ?>" type="button" onclick="resetRecording('khmermyversion-<?= $row['id'] ?>')" disabled>🔄</button>
                            <?php if (!empty($row['khmer_my_version_audio'])): ?>
                              <button type="button" onclick="deleteRecordingGeneric('vocabs', <?= $row['id'] ?>, 'khmer_my_version_audio', 'khmermyversion-<?= $row['id'] ?>')">🗑️</button>
                            <?php endif; ?>
                            */ ?>
                          <audio id="audio_khmermyversion-<?= $row['id'] ?>" controls
                                 style="display:<?= !empty($row['khmer_my_version_audio']) ? 'block' : 'none' ?>; margin-top:10px;"
                                 src="<?= !empty($row['khmer_my_version_audio']) ? base_url('uploads/audio/vocabs/' . $row['khmer_my_version_audio']) : '' ?>"></audio>
                          </div>
                        </td>

                        <td><?= htmlspecialchars($row['devanagari']) ?></td>
                        <td><?= htmlspecialchars($row['roman']) ?></td>
                        <td><?= htmlspecialchars($row['ipa']) ?></td>

                        <td>
                          <a href="<?= base_url('admin/vocabs/edit/' . $row['id']) ?>" class="btn btn-sm btn-primary">
                            <i class="ion ion-edit"></i>
                          </a>
                          |
                          <a href="<?= base_url('admin/vocabs/soft_delete/' . $row['id']) ?>"
                             class="btn btn-sm btn-danger"
                             onclick="return confirm('Are you sure you want to delete this vocab?');">
                            <i class="ion ion-ios-trash"></i>
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
