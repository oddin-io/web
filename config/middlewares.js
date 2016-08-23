const path = require('path')
const express = require('express')
const bodyParser = require('body-parser')
const cookieParser = require('cookie-parser')
const sassMiddleware = require('node-sass-middleware')

module.exports = function middlewareConfig(app) {
  app.use(express.static(path.join(__dirname, '../', 'public')))
  app.use(bodyParser.urlencoded({ extended: true }))
  app.use(bodyParser.json())
  app.use(cookieParser())
  app.use(sassMiddleware({
    src: path.join(__dirname, '../', 'public'),
    dest: path.join(__dirname, '../', 'public'),
    indentedSyntax: true,
    sourceMap: true,
  }))
}
