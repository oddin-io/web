const path = require('path')

const distFolder = path.resolve(__dirname, '../', 'dist')
const viewsPath = path.resolve(distFolder, 'views')

function index(app) {
  app.get('/', function index(req, res) {
    res.sendFile(`${viewsPath}/index.html`)
  })

  app.get('/recover-password', function recoverPassword() {
    console.log('recover-password')
  })
}

function config(app) {
  app.get('/config', function customConfig(req, res) {
    res.jsonp({
      ws_url: (process.env.WS_URL) || 'http://ws-edupanel.herokuapp.com',
    })
  })
}

function home(app) {
  app.get('/home', function (req, res) {
    res.sendFile(`${viewsPath}/home.html`)
  })
}

function lecture(app) {
  app.get('/lectures/:id', function index(req, res) {
    res.sendFile(`${viewsPath}/home.html`)
  })
}

function presentation(app) {
  app.get('/presentations/:id', function index(req, res) {
    res.sendFile(`${viewsPath}/home.html`)
  })
}

function partials(app) {
  app.get('/partials/*', function renderPartial(req, res) {
    const filename = req.path.substring(1)

    res.sendFile(`${viewsPath}/${filename}.html`)
  })
}

function components(app) {
  app.get('/components/:filename', function renderPartial(req, res) {
    const filename = req.params.filename

    res.sendFile(`${viewsPath}/components/${filename}.html`)
  })
}

function files(app) {
  app.get('/*', function renderPartial(req, res) {
    const filename = req.path.substring(1)

    res.sendFile(`${distFolder}/dependencies/${filename}`)
  })
}


module.exports = function routesConfig(app) {
  index(app)
  config(app)
  home(app)
  lecture(app)
  presentation(app)
  partials(app)
  components(app)

  files(app)
}
