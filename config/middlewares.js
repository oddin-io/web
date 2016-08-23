const express = require('express')
const bodyParser = require('body-parser')
const cookieParser = require('cookie-parser')
const methodOverride = require('method-override')

module.exports = function middlewareConfig(app) {
  app.use(express.static('public'))
  app.use(bodyParser.urlencoded({ extended: true }))
  app.use(bodyParser.json())
  app.use(methodOverride())
  app.use(cookieParser())
}
