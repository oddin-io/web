module.exports = function (http) {
    var io = require('socket.io')(http);

    var instruction = io.of("socket/instruction")
        , presentation = io.of("socket/presentation");

    presentation.on("connection", function (client) {
        var room = url.parse(client.request.headers.referer).path;

        client.join(room);
        client.on("new question", function (data) {
            presentation.to(room).emit("new question", data);
        });

        client.on("new answer", function (data) {
            presentation.to(room).emit("new answer", data);
        });

        client.on("new question vote", function (data) {
            presentation.to(room).emit("new question vote", data);
        });

        client.on("delete question vote", function (data) {
            presentation.to(room).emit("delete question vote", data);
        });

        client.on("new answer accept", function (data) {
            presentation.to(room).emit("new answer accept", data);
        });

        client.on("delete answer accept", function (data) {
            presentation.to(room).emit("delete answer accept", data);
        });
    });

    instruction.on("connection", function (client) {
        var room = url.parse(client.request.headers.referer).path;

        client.join(room);
        client.on("new presentation", function (data) {
            instruction.to(room).emit("new presentation", data);
        });
    });

    return io;
};
