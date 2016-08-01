var participantes = [
    {
        "id": 1,
        "name": "Célia",
        "online": 0
    },
    {
        "id": 2,
        "name": "Rafael",
        "online": 1
    },
    {
        "id": 3,
        "name": "Bruno",
        "online": 1
    }
];

module.exports = function() {
    var controller = {
        //listaParticipantes: function(req, res) {
        //    var _id = req.params.id;
        //    var participantes;
        //    for(var i = 0; i < disciplinas.length; i++) {
        //        if(disciplinas[i]._id == _id)
        //        {
        //            participantes = disciplinas[i].participantes;
        //            break;
        //        }
        //    }
        //    res.json(participantes);
        //}
        listaParticipantes: function(req, res) {
            res.json(participantes);
        }
    };
    return controller;
}