const router = require('express').Router()
const path = require('path')

const distFolder = path.resolve(__dirname, '../', 'dist')

router.get('/', function (req, res) {
  res.sendFile(`${distFolder}/index.html`)
})

router.get('/home', function (req, res) {
  res.sendFile(`${distFolder}/home.html`)
})

router.get('/config', function (req, res) {
  res.jsonp({
    ws_url: process.env.WS_URL,
  })
})

router.get('/*', function (req, res) {
  const filename = req.path.substring(1)

  res.sendFile(`${distFolder}/${filename}`)
})

module.exports = router
