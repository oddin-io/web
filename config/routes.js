const index = require('../routes/index')
const config = require('../routes/config')
const auth = require('../routes/auth')
const home = require('../routes/home')
const lecture = require('../routes/lecture')
const presentation = require('../routes/presentation')
const partials = require('../routes/partials')
const components = require('../routes/components')

module.exports = function routesConfig(app) {
  app.use('/', index)
  app.use('/', config)
  app.use('/', auth)
  app.use('/', home)
  app.use('/', lecture)
  app.use('/', presentation)
  app.use('/', partials)
  app.use('/', components)
}
