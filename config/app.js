const settings = require('./settings')
const middlewares = require('./middlewares')
const routes = require('./routes')

module.exports = function appConfig(app) {
  settings(app)
  middlewares(app)
  routes(app)
}
