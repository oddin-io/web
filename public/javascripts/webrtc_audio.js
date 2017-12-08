'use strict';

var mediaSource = new MediaSource()
var mediaRecorder
var recordedBlobs
var sourceBuffer

var gumAudio
var recordedAudio
var recordButton
var playButton
var uploadButton
var recording

var constraints = {
  audio: true,
  video: false,
};

function handleSuccess(stream) {
  console.log('getUserMedia() got stream: ', stream);
  window.stream = stream;
  if (window.URL) {
    gumAudio.src = window.URL.createObjectURL(stream);
  } else {
    gumAudio.src = stream;
  }
  return stream
}

function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

function handleSourceOpen() {
  console.log('MediaSource opened')
  sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"')
  console.log('Source buffer: ', sourceBuffer)
}

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
    uploadButton.disabled = false;
    recordButton.style.backgroundColor = "#2e7d32";
  }
}

function startRecording() {
  var options = {mimeType: 'audio/webm;codecs=vp9'};
  recordedBlobs = [];
  if (!MediaRecorder.isTypeSupported(options.mimeType)) {
    console.log(options.mimeType + ' is not Supported');
    options = {mimeType: 'audio/webm;codecs=vp8'};
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
      console.log(options.mimeType + ' is not Supported');
      options = {mimeType: 'audio/webm'};
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
  recordButton.style.backgroundColor = "#c62828";
  recordButton.textContent = 'Parar';
  recording.style.display = ""
  playButton.disabled = true;
  uploadButton.disabled = true;
  mediaRecorder.onstop = handleStop;
  mediaRecorder.ondataavailable = handleDataAvailable;
  mediaRecorder.start(10); // collect 10ms of data
  console.log('MediaRecorder started', mediaRecorder);
}

function stopRecording() {
  mediaRecorder.stop();
  recording.style.display = "none"
  console.log('Recorded Blobs: ', recordedBlobs);
  recordedAudio.controls = true;
}

function play() {
  var superBuffer = new Blob(recordedBlobs, {type: 'audio/webm'});
  recordedAudio.src = window.URL.createObjectURL(superBuffer);
}

function upload() {
  var blob 
  window.blob = new Blob(recordedBlobs, { type: 'audio/webm' })
}

export default function () {
  //window.isSecureContext could be used for Chrome
  //var isSecureOrigin = location.protocol === 'https:' ||
  //location.hostname === 'localhost'

  gumAudio = document.querySelector('audio#gumAudio');
  recordedAudio = document.querySelector('audio#recordedAudio');
  recordButton = document.querySelector('button#recordAudio');
  playButton = document.querySelector('button#playAudio');
  uploadButton = document.querySelector('button#uploadAudio');
  recording = document.querySelector('div#recordingAudio');
  recording.style.display = "none"

  mediaSource.addEventListener('sourceopen', handleSourceOpen, false)
  recordButton.onclick = toggleRecording;
  playButton.onclick = play;
  uploadButton.onclick = upload;

  //if (!isSecureOrigin) {
  //  alert('getUserMedia() must be run from a secure origin: HTTPS or localhost.' +
  //    '\n\nChanging protocol to HTTPS')
  //  location.protocol = 'HTTPS'
  //}

  recordedAudio.addEventListener('error', function(ev) {
    console.error('MediaRecording.recordedMedia.error()');
    alert('Your browser can not play\n\n' + recordedAudio.src
      + '\n\n media clip. event: ' + JSON.stringify(ev));
  }, true);

  return new Promise((resolve, reject) => {
    navigator.mediaDevices.getUserMedia(constraints)
      .then((stream) => {
        resolve(handleSuccess(stream))
      })
      .catch((err) => {
        reject(err)
      })
  })
}