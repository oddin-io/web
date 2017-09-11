/* globals MediaRecorder */
// DOM Elements for handling
var gumVideo
var recordedVideo
var recordButton
var playButton
var downloadButton

// Media handlers
var mediaSource = new MediaSource()
var mediaRecorder
var recordedBlobs
var sourceBuffer
var constraints = {
  audio: true,
  video: true,
}

function handleSuccess(stream) {
  recordButton.disabled = false
  console.log('getUserMedia() got stream: ', stream)
  window.stream = stream
  if (window.URL) {
    gumVideo.src = window.URL.createObjectURL(stream)
  } else {
    gumVideo.src = stream
  }

  return stream
}

function handleError(error) {
  console.log('navigator.getUserMedia error: ', error)
}

function handleSourceOpen() {
  console.log('MediaSource opened')
  sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"')
  console.log('Source buffer: ', sourceBuffer)
}

function handleDataAvailable(event) {
  if (event.data && event.data.size > 0) {
    recordedBlobs.push(event.data)
  }
}

function handleStop(event) {
  console.log('Recorder stopped: ', event)
}

function toggleRecording() {
  if (recordButton.textContent === 'Gravar') {
    startRecording()
  } else {
    stopRecording()
    recordButton.textContent = 'Gravar'
    playButton.disabled = false
    downloadButton.disabled = false
  }
}

function startRecording() {
  var options = { mimeType: 'video/webm;codecs=vp9' }
  recordedBlobs = []
  if (!MediaRecorder.isTypeSupported(options.mimeType)) {
    console.log(options.mimeType + ' is not Supported')
    options = { mimeType: 'video/webm;codecs=vp8' }
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
      console.log(options.mimeType + ' is not Supported')
      options = { mimeType: 'video/webm' }
      if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        console.log(options.mimeType + ' is not Supported')
        options = { mimeType: '' }
      }
    }
  }
  try {
    mediaRecorder = new MediaRecorder(window.stream, options)
  } catch (e) {
    console.error('Exception while creating MediaRecorder: ' + e)
    alert('Exception while creating MediaRecorder: '
      + e + '. mimeType: ' + options.mimeType)
    return
  }
  console.log('Created MediaRecorder', mediaRecorder, 'with options', options)
  recordButton.textContent = 'Parar'
  playButton.disabled = true
  downloadButton.disabled = true
  mediaRecorder.onstop = handleStop
  mediaRecorder.ondataavailable = handleDataAvailable
  mediaRecorder.start(10) // collect 10ms of data
  console.log('MediaRecorder started', mediaRecorder)
}

function stopRecording() {
  mediaRecorder.stop()
  console.log('Recorded Blobs: ', recordedBlobs)
  recordedVideo.controls = true
}

function play() {
  var superBuffer = new Blob(recordedBlobs, { type: 'video/webm' })
  recordedVideo.src = window.URL.createObjectURL(superBuffer)
}

function download() {
  var blob = new Blob(recordedBlobs, { type: 'video/webm' })
  var url = window.URL.createObjectURL(blob)
  var a = document.createElement('a')
  a.style.display = 'none'
  a.href = url
  a.download = 'test.webm'
  document.body.appendChild(a)
  a.click()
  setTimeout(function () {
    document.body.removeChild(a)
    window.URL.revokeObjectURL(url)
  }, 100)
}

export default function () {
  // window.isSecureContext could be used for Chrome
  var isSecureOrigin = location.protocol === 'https:' ||
  location.hostname === 'localhost'

  gumVideo = document.querySelector('video#gum')
  recordedVideo = document.querySelector('video#recorded')
  recordButton = document.querySelector('button#record')
  playButton = document.querySelector('button#play')
  downloadButton = document.querySelector('button#download')

  mediaSource.addEventListener('sourceopen', handleSourceOpen, false)
  recordButton.onclick = toggleRecording
  playButton.onclick = play
  //downloadButton.onclick = download

  if (!isSecureOrigin) {
    alert('getUserMedia() must be run from a secure origin: HTTPS or localhost.' +
      '\n\nChanging protocol to HTTPS')
    location.protocol = 'HTTPS'
  }

  recordedVideo.addEventListener('error', function (ev) {
    console.error('MediaRecording.recordedMedia.error()')
    alert('Your browser can not play\n\n' + recordedVideo.src
    + '\n\n media clip. event: ' + JSON.stringify(ev))
  }, true)

  return new Promise((resolve) => {
    navigator.mediaDevices.getUserMedia(constraints)
      .then(function (stream) {
        resolve(handleSuccess(stream))
      })
  })
}
