const express = require('express')
const path = require('path')
const favicon = require('serve-favicon')
const logger = require('morgan')

module.exports = function middlewareConfig(app) {
  app.use(favicon(path.join(__dirname, '../', 'public', 'favicon.ico')))
  app.use(logger('dev'))
  app.use(express.static(path.join(__dirname, '../', 'public')))
}
