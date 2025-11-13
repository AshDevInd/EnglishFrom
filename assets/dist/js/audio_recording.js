let mediaRecorder;
let currentChunks = [];
let currentVowelId = null;
let currentField = null;

function startRecordingUI(vowelId, field) {
    if (mediaRecorder && mediaRecorder.state === 'recording') {
        alert("Please stop current recording before starting a new one.");
        return;
    }

    currentVowelId = vowelId;
    currentField = field;
    currentChunks = [];

    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.ondataavailable = function (e) {
                currentChunks.push(e.data);
            };

            mediaRecorder.onstop = function () {
                let blob = new Blob(currentChunks, { type: 'audio/wav' });
                let url = URL.createObjectURL(blob);

                // Create audio preview
                const audioElement = document.getElementById(`audio-preview-${field}-${vowelId}`);
                audioElement.src = url;
                audioElement.style.display = 'inline';

                // Enable save button
                document.getElementById(`save-btn-${field}-${vowelId}`).onclick = function () {
                    saveRecording(blob, vowelId, field);
                };
            };

            mediaRecorder.start();

            document.getElementById(`record-btn-${field}-${vowelId}`).disabled = true;
            document.getElementById(`stop-btn-${field}-${vowelId}`).disabled = false;
        })
        .catch(error => {
            console.error("Error accessing microphone: ", error);
            alert("Microphone access is required to record audio.");
        });
}

function stopRecordingUI(vowelId, field) {
    if (mediaRecorder && mediaRecorder.state === 'recording') {
        mediaRecorder.stop();
        document.getElementById(`stop-btn-${field}-${vowelId}`).disabled = true;
        document.getElementById(`record-btn-${field}-${vowelId}`).disabled = false;
    }
}

function saveRecording(blob, vowelId, field) {
    const formData = new FormData();
    formData.append("audio_data", blob);
    formData.append("vowel_id", vowelId);
    formData.append("field_name", field);

    fetch("/your_controller/upload_audio", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert("Audio saved successfully.");
    })
    .catch(error => {
        console.error("Error saving audio: ", error);
        alert("Failed to save audio.");
    });
}
