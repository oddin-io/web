var request = require('request');

var disciplinas = [
  {
    'id': 1,
    'class_number': 1,
    'start_date': "2015-07-28",
    'end_date': "2015-12-22",
    'event': {
      'id': 1,
      'code': "ADS",
      'name': "Análise e Desenvolvimento de Sistemas",
      'workload': "2100.7"
    },
    'lecture': {
      'id': 1,
      'code': "BD1",
      'name': "Banco de Dados I",
      'workload': "79.2"
    }
  },
  {
    'id': 2,
    'class_number': 2,
    'start_date': "2015-07-28",
    'end_date': "2015-12-22",
    'event': {
      'id': 1,
      'code': "ADS",
      'name': "Análise e Desenvolvimento de Sistemas",
      'workload': "2100.7"
    },
    'lecture': {
      'id': 2,
      'code': "LP1",
      'name': "Linguagem de Programação I",
      'workload': "79.2"
    }
  },
  {
    'id': 3,
    'class_number': 3,
    'start_date': "2015-07-28",
    'end_date': "2015-12-22",
    'event': {
      'id': 1,
      'code': "ADS",
      'name': "Análise e Desenvolvimento de Sistemas",
      'workload': "2100.7"
    },
    'lecture': {
      'id': 3,
      'code': "ISO",
      'name': "Introdução a Sistemas Operacionais",
      'workload': "79.2"
    }
  }
];

function listaDisciplinas(req, res) {
  var session = req.cookies.session;

  request(
    {
      uri: 'http://rws-edupanel.herokuapp.com/instructions',
      method: 'GET',
      headers: {
        'x-session-token': session.token
      }
    }, function (error, response, body) {
      if (response.statusCode == 401) {
        res.status(401);
        res.end();
      }
      else {
        res.json(JSON.parse(body));
      }
    }
  );
}

function mostraInfoDisciplinas(req, res) {
  var id = req.params.id;
  var disciplina = {};
  for (var i = 0; i < disciplinas.length; i++) {
    if (disciplinas[i].id == id) {
      disciplina = disciplinas[i];
      break;
    }
  }
  res.json(disciplina);
}

module.exports = function () {
  return {
    listaDisciplinas: listaDisciplinas,
    mostraInfoDisciplina: mostraInfoDisciplinas
  };
};
