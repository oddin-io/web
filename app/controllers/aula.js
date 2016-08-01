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

module.exports = function() {
    var controller = {
        //listaAulas: function(req, res) {
        //    var id = req.params.id;
        //    var aulas;
        //    for(var i = 0; i < disciplinas.length; i++) {
        //        if(disciplinas[i].id == id)
        //        {
        //            aulas = disciplinas[i].aulas;
        //            break;
        //        }
        //    }
        //    res.json(aulas);
        //}
        listaAulas: function(req, res) {
            res.json(aulas);
        }
    };
    return controller;
}
