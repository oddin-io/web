var aulas = [
  {
    'id': 1,
    'subject': "Introdução",
    'status': 0,
    'created_at': "2015-07-28 18:30:25",
    'instruction':  {
      'id': 1,
      'class_number': 1,
      'start_date': "2015-07-28",
      'end_date': "2015-12-22"
    },
    'person': {
      'id': 1,
      'name': "João"
    }
  },
  {
    'id': 2,
    'subject': "Aula 2",
    'status': 0,
    'created_at': "2015-07-28 18:30:25",
    'instruction':  {
      'id': 1,
      'class_number': 1,
      'start_date': "2015-07-28",
      'end_date': "2015-12-22"
    },
    'person': {
      'id': 1,
      'name': "João"
    }
  },
  {
    'id': 3,
    'subject': "Aula 3",
    'status': 0,
    'created_at': "2015-07-28 18:30:25",
    'instruction': {
      'id': 1,
      'class_number': 1,
      'start_date': "2015-07-28",
      'end_date': "2015-12-22"
    },
    'person': {
      'id': 1,
      'name': "João"
    }
  }
];

module.exports = function () {
  return {
    listaAulas: function (req, res) {
      res.json(aulas);
    },
    mostraInfoAula: function (req, res) {
      var id = req.params.id;
      var aula = {};
      for (var i = 0; i < aulas.length; i++) {
        if (aulas[i].id == id) {
          aula = aulas[i];
          break;
        }
      }
      res.json(aula);
    }
  };
};
