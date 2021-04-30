var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server, {
  cors: {
      origin: 'http://188.166.187.2:8082/'
  }});
var redis = require('redis');

 
port = '8890';
// server.listen( port, '188.166.187.2' );
server.listen( port, '188.166.187.2' );

io.on('connection', function (socket) {
 
  console.log("new client connected");
  var redisClient = redis.createClient();
  redisClient.subscribe('message');
 
  redisClient.on("message", function(channel, message) {
    console.log("mew message in queue "+ message + "channel");
    socket.emit(channel, message);
  });
 
  socket.on('disconnect', function() {
    redisClient.quit();
  });
 
});
