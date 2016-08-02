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
]

module.exports = function() {
    var controller = {
        listaDuvidas: function(req, res) {
            res.json(duvidas);
        }
    };
    return controller;
}