
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
<script src="<?=base_url('assets/')?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?=base_url('assets/')?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url('assets/')?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>dist/js/adminlte.js"></script>

<script>
let recorders = {}; // per-row recording state

function startRecording(inputId) {
    if (!recorders[inputId]) recorders[inputId] = { chunks: [], recorder: null, blob: null };

    navigator.mediaDevices.getUserMedia({ audio: true })
    .then(stream => {
        let rec = new MediaRecorder(stream);
        recorders[inputId].recorder = rec;
        recorders[inputId].chunks = [];

        rec.ondataavailable = e => { if(e.data.size>0) recorders[inputId].chunks.push(e.data); };

        rec.onstop = () => {
            recorders[inputId].blob = new Blob(recorders[inputId].chunks, { type: 'audio/webm' });
            let audioURL = URL.createObjectURL(recorders[inputId].blob);
            let audioEl = document.getElementById("audio_" + inputId);
            audioEl.src = audioURL;
            audioEl.style.display = "block";

            document.getElementById("saveBtn_" + inputId).disabled = false;
            document.getElementById("resetBtn_" + inputId).disabled = false;
        };

        rec.start();
        document.getElementById("recordBtn_" + inputId).disabled = true;
        document.getElementById("stopBtn_" + inputId).disabled = false;
    });
}

function stopRecording(inputId) {
    if(recorders[inputId] && recorders[inputId].recorder) {
        recorders[inputId].recorder.stop();
        document.getElementById("recordBtn_" + inputId).disabled = false;
        document.getElementById("stopBtn_" + inputId).disabled = true;
    }
}

function resetRecording(inputId) {
    if(recorders[inputId]) { recorders[inputId].chunks=[]; recorders[inputId].blob=null; }
    let audioEl = document.getElementById("audio_" + inputId);
    audioEl.src = ""; audioEl.style.display = "none";
    document.getElementById("saveBtn_" + inputId).disabled = true;
    document.getElementById("resetBtn_" + inputId).disabled = true;
}

function playPreview(inputId) {
    let audioEl = document.getElementById("audio_" + inputId);
    if(audioEl.src) audioEl.play(); else alert("No audio to play!");
}

function saveRecordingVocab(inputId, vocabs_id, field_name) {
    if(!recorders[inputId] || !recorders[inputId].blob) { 
        alert("No recording to save!"); 
        return; 
    }
    let formData = new FormData();
    formData.append("audio_data", recorders[inputId].blob, inputId+".webm");
    formData.append("vocabs_id", vocabs_id);
    formData.append("field_name", field_name);

    fetch("<?= base_url('admin/vocabs/upload_audio') ?>", { method: "POST", body: formData })
    .then(res => res.text())
    .then(res => {
        alert("Audio saved successfully");
        location.reload(); // Refresh page
    })
    .catch(err => console.error(err));
}

function saveRecordingVowel(inputId, vowel_id, field_name) {
    if(!recorders[inputId] || !recorders[inputId].blob) { 
        alert("No recording to save!"); 
        return; 
    }
    let formData = new FormData();
    formData.append("audio_data", recorders[inputId].blob, inputId+".webm");
    formData.append("vowel_id", vowel_id);
    formData.append("field_name", field_name);

    fetch("<?= base_url('admin/vowels/upload_audio') ?>", { method: "POST", body: formData })
    .then(res => res.text())
    .then(res => {
        alert("Audio saved successfully");
        location.reload(); // Refresh page
    })
    .catch(err => console.error(err));
}

function deleteRecordingGeneric(type, id, field_name, inputId) {
    let url = "", formData = new FormData();
    if(type === "vocabs"){ 
        url = "<?= base_url('admin/vocabs/delete_audio') ?>"; 
        formData.append("vocabs_id", id); 
    } else if(type === "vowels"){ 
        url = "<?= base_url('admin/vowels/delete_audio') ?>"; 
        formData.append("vowel_id", id); 
    }

    formData.append("field_name", field_name);

    fetch(url, { method: "POST", body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            alert("Audio deleted successfully");
            location.reload(); // Refresh page
        } else {
            alert("Failed to delete audio!");
        }
    })
    .catch(err => console.error(err));
}


// DataTable
$(function() {
    $('#example2').DataTable({ "paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false, "responsive": true });
});
</script>
</body>
</html>