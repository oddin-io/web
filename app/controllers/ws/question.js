var duvidas = [
  {
    "id": 1,
    "text": "Can I use nested for loops?",
    "anonymous": true,
    "created_at": "2016-08-01T17:42:16.987Z",
    "presentation": {
      "id": 1,
      "subject": "Teste",
      "status": 0
    },
    "person": {
      "id": 4,
      "name": "Célia"
    }
  },
  {
    "id": 2,
    "text": "Can I use nested for loops?",
    "anonymous": false,
    "created_at": "2016-08-01T17:42:16.987Z",
    "presentation": {
      "id": 1,
      "subject": "Teste",
      "status": 0
    },
    "person": {
      "id": 4,
      "name": "Célia"
    }
  },
  {
    "id": 3,
    "text": "Can I use nested for loops?",
    "anonymous": true,
    "created_at": "2016-08-01T17:42:16.987Z",
    "presentation": {
      "id": 1,
      "subject": "Teste",
      "status": 0
    },
    "person": {
      "id": 4,
      "name": "Célia"
    }
  }
];

function index(req, res) {
  res.json(duvidas);
}

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
