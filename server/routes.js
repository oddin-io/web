const router = require('express').Router()
const distDir = require('../fileMappings').distDir

router.get('/', function (req, res) {
  res.sendFile(`${distDir}/index.html`)
})

router.get('/home', function (req, res) {
  res.sendFile(`${distDir}/home.html`)
})

router.get('/config', function (req, res) {
  res.jsonp({
    ws_url: process.env.WS_URL,
  })
})

router.get('/*', function (req, res) {
  const filename = req.path.substring(1)

  res.sendFile(`${distDir}/${filename}`)
})

module.exports = router
