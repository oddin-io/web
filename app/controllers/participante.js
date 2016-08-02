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
        listaParticipantes: function(req, res) {
            res.json(participantes);
        }
    };
    return controller;
}