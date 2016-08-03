module.exports = function(app) {
  var controller = app.controllers.participante;
  app.get('/participants', controller.listaParticipantes);
};
