var materiais = [
  {
    "id": 1,
    "name": "example.pdf",
    "mime": "application/pdf",
    "checked": true,
    "uploaded_at": "asdf",
    "person": {
      "id": 1,
      "name": "Example"
    }
  },
  {
    "id": 2,
    "name": "example2.pdf",
    "mime": "application/pdf",
    "checked": true,
    "uploaded_at": "asdf",
    "person": {
      "id": 1,
      "name": "Example"
    }
  },
  {
    "id": 3,
    "name": "example3.pdf",
    "mime": "application/pdf",
    "checked": true,
    "uploaded_at": "asdf",
    "person": {
      "id": 1,
      "name": "Example"
    }
  }
];

function index(req, res, next) {
  console.log('instruction#index')
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
