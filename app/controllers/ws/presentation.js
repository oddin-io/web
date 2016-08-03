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

function index(req, res, next) {

}

function show(req, res, next) {

}

function create(req, res, next) {

}

function update(req, res, next) {

}

function destroy(req, res, next) {

}

module.exports = function (app) {
  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy
  };
};
