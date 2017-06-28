function dist(app) {
  app.get('/dist/*', function renderPartial(req, res) {
    const filename = req.path.substring(1)

    res.render(filename)
  })
}

function index(app) {
  app.get('/', function index(req, res) {
    res.render('index')
  })

  app.get('/recover-password', function recoverPassword() {
    console.log('recover-password')
  })
}

function config(app) {
  app.get('/config', function customConfig(req, res) {
    res.jsonp({
      ws_url: (process.env.WS_URL) || 'http://ws-edupanel.herokuapp.com'
    })
  })
}

function home(app) {
  app.get('/home', function (req, res) {
    res.render('home')
  })
}

function lecture(app) {
  app.get('/lectures/:id', function index(req, res) {
    res.render('home')
  })
}

function presentation(app) {
  app.get('/presentations/:id', function index(req, res) {
    res.render('home')
  })
}

function partials(app) {
  app.get('/partials/*', function renderPartial(req, res) {
    const filename = req.path.substring(1)

    res.render(filename)
  })
}

function components(app) {
  app.get('/components/:filename', function renderPartial(req, res) {
    const filename = req.params.filename

    res.render(`components/${filename}`)
  })
}


module.exports = function routesConfig(app) {
  dist(app)
  index(app)
  config(app)
  home(app)
  lecture(app)
  presentation(app)
  partials(app)
  components(app)
}
