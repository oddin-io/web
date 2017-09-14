'use strict';

var mediaRecorder;
var recordedBlobs;
var sourceBuffer;

var gumAudio = document.querySelector('audio#gumAudio');
var recordedAudio = document.querySelector('audio#recordedAudio');

var recordButton = document.querySelector('button#recordAudio');
var playButton = document.querySelector('button#playAudio');
var downloadButton = document.querySelector('button#downloadAudio');

recordButton.onclick = toggleRecording;
playButton.onclick = play;
downloadButton.onclick = download;

var constraints = window.constraints = {
  audio: true,
  video: false
};

function handleSuccess(stream) {
  console.log('getUserMedia() got stream: ', stream);
  window.stream = stream;
  if (window.URL) {
    gumAudio.src = window.URL.createObjectURL(stream);
  } else {
    gumAudio.src = stream;
  }
}

function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

navigator.mediaDevices.getUserMedia(constraints).
    then(handleSuccess).catch(handleError);

recordedAudio.addEventListener('error', function(ev) {
  console.error('MediaRecording.recordedMedia.error()');
  alert('Your browser can not play\n\n' + recordedAudio.src
    + '\n\n media clip. event: ' + JSON.stringify(ev));
}, true);

function handleDataAvailable(event) {
  if (event.data && event.data.size > 0) {
    recordedBlobs.push(event.data);
  }
}

function handleStop(event) {
  console.log('Recorder stopped: ', event);
}

function toggleRecording() {
  if (recordButton.textContent === 'Gravar') {
    startRecording();
  } else {
    stopRecording();
    recordButton.textContent = 'Gravar';
    playButton.disabled = false;
    downloadButton.disabled = false;
  }
}

function startRecording() {
  recordedBlobs = [];
  var options = {mimeType: 'audio/mp3;codecs=vp9'};
  if (!MediaRecorder.isTypeSupported(options.mimeType)) {
    console.log(options.mimeType + ' is not Supported');
    options = {mimeType: 'audio/mp3;codecs=vp9'};
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
      console.log(options.mimeType + ' is not Supported');
      options = {mimeType: 'audio/mp3'};
      if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        console.log(options.mimeType + ' is not Supported');
        options = {mimeType: ''};
      }
    }
  }
  try {
    mediaRecorder = new MediaRecorder(window.stream, options);
  } catch (e) {
    console.error('Exception while creating MediaRecorder: ' + e);
    alert('Exception while creating MediaRecorder: '
      + e + '. mimeType: ' + options.mimeType);
    return;
  }
  console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
  recordButton.textContent = 'Parar';
  playButton.disabled = true;
  downloadButton.disabled = true;
  mediaRecorder.onstop = handleStop;
  mediaRecorder.ondataavailable = handleDataAvailable;
  mediaRecorder.start(10); // collect 10ms of data
  console.log('MediaRecorder started', mediaRecorder);
}

function stopRecording() {
  mediaRecorder.stop();
  console.log('Recorded Blobs: ', recordedBlobs);
  recorded.controls = true;
}

function play() {
  var superBuffer = new Blob(recordedBlobs, {type: 'audio/webm'});
  recorded.src = window.URL.createObjectURL(superBuffer);
}