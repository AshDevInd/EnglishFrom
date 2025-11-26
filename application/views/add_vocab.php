<?php $this->load->view('includes/header') ?>
<?php $this->load->view('includes/sidebar') ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Vocab</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Vocab</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Flash Success Message -->
                    <?php
                    $message = $this->session->flashdata('message');
                    if (!empty($message)):
                    ?>
                        <div id="flash_msg" class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="icon fas fa-check"></i>
                            <?= $message ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Flash Error Message -->
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="icon fas fa-ban"></i>
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Vocab</h3>
                            <a href="<?= base_url('admin/vocabs/index') ?>" class="btn btn-light btn-sm float-right text-dark">
                                <i class="ion ion-arrow-left-c"></i> Back
                            </a>
                        </div>

                        <!-- form start -->
                        <form method="post" enctype="multipart/form-data" id="vocab_form">
                            <input type="hidden" name="temp_id" id="temp_id" value="<?= $temp_id ?>">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Serial Number <span class="text-danger">*</span></label>
                                            <input type="text" name="serial_number" class="form-control"
                                                placeholder="Enter serial number (e.g., 34)" required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Khmer Category <span class="text-danger">*</span></label>
                                            <select name="data[parent]" class="form-control" required>
                                                <option value="0">--- None ---</option>
                                                <?php foreach ($cats as $cat): ?>
                                                    <option value="<?= $cat['id'] ?>">
                                                        <?= $cat['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Combination <span class="text-danger">*</span></label>
                                            <input type="text" name="combination" class="form-control"
                                                placeholder="Enter combination (e.g., ក + ា)" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Vowel <span class="text-danger">*</span></label>
                                            <input type="text" name="vowel" class="form-control"
                                                placeholder="Enter vowel (e.g., ា)" required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Khmer <span class="text-danger">*</span></label>
                                            <input type="text" name="khmer" class="form-control"
                                                placeholder="Enter khmer (e.g., អឿ)" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Devanagari <span class="text-danger">*</span></label>
                                            <input type="text" name="devanagari" class="form-control"
                                                placeholder="Enter devanagari (e.g., उअ)" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Roman <span class="text-danger">*</span></label>
                                            <input type="text" name="roman" class="form-control"
                                                placeholder="Enter roman (e.g., Ua)" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>IPA <span class="text-danger">*</span></label>
                                            <input type="text" name="ipa" class="form-control"
                                                placeholder="Enter IPA (e.g., aː)" required>
                                        </div>
                                    </div>

                                    <!-- Khmer Main Audio Section -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Khmer Main Audio</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="audio_option" id="audio_record" value="record" checked>
                                                <label class="form-check-label" for="audio_record">Record</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="audio_option" id="audio_upload" value="upload">
                                                <label class="form-check-label" for="audio_upload">Upload</label>
                                            </div>

                                            <!-- Hidden input to store recorded/uploaded filename -->
                                            <input type="hidden" name="khmer_audio" id="khmer_audio" value="">

                                            <!-- Record Section -->
                                            <div id="record_section" class="mt-2">
                                                <?php
                                                $audioField = 'khmer_audio';
                                                $inputId = 'khmer-main';
                                                ?>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-secondary" id="recordBtn_<?= $inputId ?>"
                                                        onclick="startRecording('<?= $inputId ?>')">
                                                        🎙️ Record
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" id="stopBtn_<?= $inputId ?>"
                                                        onclick="stopRecording('<?= $inputId ?>')" disabled>
                                                        ⏹️ Stop
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-info"
                                                        onclick="playPreview('<?= $inputId ?>')">
                                                        ▶️ Play
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" id="saveBtn_<?= $inputId ?>"
                                                        onclick="saveRecordingVocab('<?= $inputId ?>', '<?= $audioField ?>')" disabled>
                                                        💾 Save
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" id="resetBtn_<?= $inputId ?>"
                                                        onclick="resetRecording('<?= $inputId ?>')" disabled>
                                                        🔄 Reset
                                                    </button>
                                                </div>
                                                <audio id="audio_<?= $inputId ?>" controls style="display:none; margin-top:10px; width:100%;"></audio>
                                            </div>

                                            <!-- Upload Section -->
                                            <div id="upload_section" class="mt-2" style="display:none;">
                                                <input type="file" name="khmer_audio_file" id="khmer_audio_file" class="form-control-file" accept="audio/*">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Khmer My Version Audio Section -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Khmer My Version (Record Only)</label>

                                            <!-- Hidden input to store recorded filename -->
                                            <input type="hidden" name="khmer_my_version_audio" id="khmer_my_version_audio" value="">

                                            <?php
                                            $audioField2 = 'khmer_my_version_audio';
                                            $inputId2 = 'khmer-my-version';
                                            ?>
                                            <div class="btn-group mt-2" role="group">
                                                <button type="button" class="btn btn-sm btn-secondary" id="recordBtn_<?= $inputId2 ?>"
                                                    onclick="startRecording('<?= $inputId2 ?>')">
                                                    🎙️ Record
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" id="stopBtn_<?= $inputId2 ?>"
                                                    onclick="stopRecording('<?= $inputId2 ?>')" disabled>
                                                    ⏹️ Stop
                                                </button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="playPreview('<?= $inputId2 ?>')">
                                                    ▶️ Play
                                                </button>
                                                <button type="button" class="btn btn-sm btn-success" id="saveBtn_<?= $inputId2 ?>"
                                                    onclick="saveRecordingVocab('<?= $inputId2 ?>', '<?= $audioField2 ?>')" disabled>
                                                    💾 Save
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" id="resetBtn_<?= $inputId2 ?>"
                                                    onclick="resetRecording('<?= $inputId2 ?>')" disabled>
                                                    🔄 Reset
                                                </button>
                                            </div>
                                            <audio id="audio_<?= $inputId2 ?>" controls style="display:none; margin-top:10px; width:100%;"></audio>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <a href="<?= base_url('admin/vocabs/index') ?>" class="btn btn-default">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<footer class="main-footer">
    <strong>Copyright &copy; <?= (date('Y') - 1) . ' - ' . date('Y') ?> <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
    </div>
</footer>

<aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- jQuery -->
<script src="<?= base_url('assets/') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>

<script>
    let mediaRecorder = {};
    let audioChunks = {};
    let audioBlob = {};

    // Start recording
    function startRecording(inputId) {
        navigator.mediaDevices.getUserMedia({
                audio: true
            })
            .then(stream => {
                mediaRecorder[inputId] = new MediaRecorder(stream);
                audioChunks[inputId] = [];

                mediaRecorder[inputId].ondataavailable = event => {
                    audioChunks[inputId].push(event.data);
                };

                mediaRecorder[inputId].onstop = () => {
                    audioBlob[inputId] = new Blob(audioChunks[inputId], {
                        type: 'audio/mp3'
                    });
                    const audioUrl = URL.createObjectURL(audioBlob[inputId]);
                    document.getElementById('audio_' + inputId).src = audioUrl;
                    document.getElementById('audio_' + inputId).style.display = 'block';

                    // Enable save and reset buttons
                    document.getElementById('saveBtn_' + inputId).disabled = false;
                    document.getElementById('resetBtn_' + inputId).disabled = false;
                };

                mediaRecorder[inputId].start();

                // Update button states
                document.getElementById('recordBtn_' + inputId).disabled = true;
                document.getElementById('stopBtn_' + inputId).disabled = false;
            })
            .catch(error => {
                alert('Error accessing microphone: ' + error.message);
            });
    }

    // Stop recording
    function stopRecording(inputId) {
        if (mediaRecorder[inputId] && mediaRecorder[inputId].state !== 'inactive') {
            mediaRecorder[inputId].stop();
            mediaRecorder[inputId].stream.getTracks().forEach(track => track.stop());

            // Update button states
            document.getElementById('recordBtn_' + inputId).disabled = false;
            document.getElementById('stopBtn_' + inputId).disabled = true;
        }
    }

    // Play preview
    function playPreview(inputId) {
        const audio = document.getElementById('audio_' + inputId);
        if (audio.src) {
            audio.play();
        } else {
            alert('No audio to play. Please record first.');
        }
    }

    // Reset recording
    function resetRecording(inputId) {
        if (confirm('Are you sure you want to reset this recording?')) {
            audioChunks[inputId] = [];
            audioBlob[inputId] = null;

            const audio = document.getElementById('audio_' + inputId);
            audio.src = '';
            audio.style.display = 'none';

            // Reset button states
            document.getElementById('recordBtn_' + inputId).disabled = false;
            document.getElementById('stopBtn_' + inputId).disabled = true;
            document.getElementById('saveBtn_' + inputId).disabled = true;
            document.getElementById('resetBtn_' + inputId).disabled = true;
        }
    }

    // Save recording to server via AJAX (without page refresh)
    function saveRecordingVocab(inputId, fieldName) {
        if (!audioBlob[inputId]) {
            alert('No audio recorded. Please record audio first.');
            return;
        }

        const tempId = document.getElementById('temp_id').value;

        const formData = new FormData();
        formData.append('audio_data', audioBlob[inputId], 'recording.mp3');
        formData.append('temp_id', tempId);
        formData.append('field_name', fieldName);

        // Show loading indicator
        const saveBtn = document.getElementById('saveBtn_' + inputId);
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '⏳ Saving...';
        saveBtn.disabled = true;

        fetch('<?= base_url("admin/vocabs/upload_audio_temp") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // CRITICAL FIX: Set the hidden input value DIRECTLY using the field name
                    const hiddenInput = document.getElementById(fieldName);
                    if (hiddenInput) {
                        hiddenInput.value = data.filename;
                        console.log('Set ' + fieldName + ' = ' + data.filename);
                    } else {
                        console.error('Hidden input not found: ' + fieldName);
                    }

                    alert('Recording saved! Filename: ' + data.filename + '\nClick Submit to save all data.');

                    // Update audio player
                    const audio = document.getElementById('audio_' + inputId);
                    audio.src = '<?= base_url("uploads/audio/vocabs/temp/") ?>' + data.filename;
                    audio.style.display = 'block';

                    // Reset button states
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = true;
                    document.getElementById('resetBtn_' + inputId).disabled = false;
                } else {
                    alert('Failed to save: ' + (data.message || 'Unknown error'));
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
    }


    $(document).ready(function() {
        // Toggle between record and upload sections
        $('input[name="audio_option"]').change(function() {
            if ($(this).val() === 'record') {
                $('#record_section').show();
                $('#upload_section').hide();
                $('#khmer_audio_file').val('');
            } else {
                $('#record_section').hide();
                $('#upload_section').show();
            }
        });


        // Fade out flash success message after 5 seconds
        setTimeout(function() {
            $('#flash_msg').fadeOut('slow');
        }, 5000);

        // Prevent form submission on Enter key in text inputs
        $('input[type="text"]').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
<script>
    // DataTable
    $(function() {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>
</body>

</html>