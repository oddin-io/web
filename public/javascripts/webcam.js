var video = document.querySelector('video#gum')

navigator.getUserMedia = navigator.getUserMedia
  || navigator.webkitGetUserMedia || navigator.mozGetUserMedia
  || navigator.msGetUserMedia || navigator.oGetUserMedia

if (navigator.getUserMedia) {
  navigator.getUserMedia({ video: true, audio: true }, handleVideo, videoError)
}

function handleVideo(stream) {
  video.src = window.URL.createObjectURL(stream)
}

function videoError(e) {
  console.log('Something went wrong', e)
}
