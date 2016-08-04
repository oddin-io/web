var app = require('./config/express')();
var http = require('http').Server(app);
var socket = require('./app/socket/socket')(http);

http.listen(app.get('port'), function () {
  console.log('Oddin rodando na porta ' + app.get('port'));
});
