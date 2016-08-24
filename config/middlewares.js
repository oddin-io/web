const express = require('express')
const path = require('path')
const favicon = require('serve-favicon')
const logger = require('morgan')
const cookieParser = require('cookie-parser')
const bodyParser = require('body-parser')
const sassMiddleware = require('node-sass-middleware')

module.exports = function middlewareConfig(app) {
  app.use(favicon(path.join(__dirname, '../', 'public', 'favicon.ico')))
  app.use(logger('dev'))
  app.use(bodyParser.json())
  app.use(bodyParser.urlencoded({ extended: false }))
  app.use(cookieParser())
  app.use(sassMiddleware({
    src: path.join(__dirname, '../', 'public'),
    dest: path.join(__dirname, '../', 'public'),
    indentedSyntax: false,
    sourceMap: true,
  }))
  app.use(express.static(path.join(__dirname, '../', 'public')))
}
