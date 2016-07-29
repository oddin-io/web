var aulas = [
    {
        "id":1,
        "doubts": {
            "1": {
                "person": {
                    "id": 6,
                    "name": "João"
                },
                "likes": 18,
                "contributions": 1,
                "like": false,
                "date": "2016-05-23",
                "time": "16:31:34",
                "id": 1,
                "status": 0,
                "text": "oi oi oi!!!",
                "anonymous": false,
                "presentationid": 1
            },
            "2": {
                "person": {
                    "id": 6,
                    "name": "João"
                },
                "likes": 18,
                "contributions": 0,
                "like": false,
                "date": "2016-05-23",
                "time": "16:31:34",
                "id": 2,
                "status": 0,
                "text": "oi oi oi!!!",
                "anonymous": false,
                "presentationid": 1
            },
            "3": {
                "person": {
                    "id": 6,
                    "name": "João"
                },
                "likes": 18,
                "contributions": 2,
                "like": false,
                "date": "2016-05-23",
                "time": "16:31:34",
                "id": 3,
                "status": 0,
                "text": "oi oi oi!!!",
                "anonymous": false,
                "presentationid": 1
            }
        }
    },
    {
        "id":2,
        "doubts": {
            "1": {
                "person": {
                    "id": 6,
                    "name": "João"
                },
                "likes": 18,
                "contributions": 3,
                "like": false,
                "date": "2016-05-23",
                "time": "16:31:34",
                "id": 1,
                "status": 0,
                "text": "oi oi oi!!!",
                "anonymous": false,
                "presentationid": 2
            },
            "2": {
                "person": {
                    "id": 6,
                    "name": "João"
                },
                "likes": 18,
                "contributions": 6,
                "like": false,
                "date": "2016-05-23",
                "time": "16:31:34",
                "id": 2,
                "status": 0,
                "text": "oi oi oi!!!",
                "anonymous": false,
                "presentationid": 2
            },
            "3": {
                "person": {
                    "id": 6,
                    "name": "João"
                },
                "likes": 18,
                "contributions": 8,
                "like": false,
                "date": "2016-05-23",
                "time": "16:31:34",
                "id": 3,
                "status": 0,
                "text": "oi oi oi!!!",
                "anonymous": false,
                "presentationid": 2
            }
        }
    }
];

module.exports = function() {
    var controller = {
        listaDuvidas: function(req, res) {
            var _id = req.params.id;
            var doubts = {};
            for(var i = 0; i < aulas.length; i++) {
                if(aulas[i].id == _id)
                {
                    doubts.doubts = aulas[i].doubts;
                    break;
                }
            }
            res.json(doubts);
        }
    };
    return controller;
}