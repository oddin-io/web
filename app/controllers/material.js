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

module.exports = function() {
    var controller = {
        listaMateriais: function(req, res) {
            res.json(materiais);
        }
    };
    return controller;
}

