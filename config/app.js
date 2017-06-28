const path = require('path')

const distFolder = path.resolve(__dirname, '../', 'dist')
const viewsPath = path.resolve(distFolder, 'views')

module.exports = function appConfig(app) {
  app.get('/', function (req, res) {
    res.sendFile(`${viewsPath}/index.html`)
  })

  app.get('/home', function (req, res) {
    res.sendFile(`${viewsPath}/home.html`)
  })

  app.get('/config', function (req, res) {
    res.jsonp({
      ws_url: (process.env.WS_URL) || 'http://ws-edupanel.herokuapp.com',
    })
  })

  app.get('/*', function (req, res) {
    const filename = req.path.substring(1)

    res.sendFile(`${distFolder}/${filename}`)
  })
}
