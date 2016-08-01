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
        //listaMateriais: function(req, res) {
        //    var _id = req.params.id;
        //    var materiais;
        //    for(var i = 0; i < disciplinas.length; i++) {
        //        if(disciplinas[i]._id == _id)
        //        {
        //            materiais = disciplinas[i].materiais;
        //            break;
        //        }
        //    }
        //    res.json(materiais);
        //}
        listaMateriais: function(req, res) {
            res.json(materiais);
        }
    };
    return controller;
}

