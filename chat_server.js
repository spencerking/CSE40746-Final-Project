var app = require('express')();
var http = require('http').Server(app);
var bp = require('body-parser');
var io = require('socket.io')(http);
var db = require('oracledb');

var conn_attrs = {
  user: 'guest',
  password: 'guest',
  connectString: 'localhost/XE'
};
var online_users = [];

app.use(bp.json());

app.get('/', function(req, res) {
  res.end('Hi');
});

// User starts chat with seller
app.post('/chat', function(req, res) {
  var b_id = req.body.buyer_id;
  var s_id = req.body.seller_id;
  db.getConnection(conn_attrs, function(err, conn) {
    if (err) { console.error(err.message); return; }
    var start_date = new Date();
    conn.execute(
      'INSERT INTO chat ' +
      'VALUES (:buyer_id, :seller_id, :start_date, :update_date)',
      [b_id, s_id, start_date, start_date],
      function(err, result) {
        if (err) {
          console.error(err.message);
          res.end('Error: Failed to create chat');
          return;
        }
        console.log(result.rows);
        res.end('Chat created');
      }
    );
  });
});

io.on('connection', function(socket) {
  // User connects
  socket.on('user_connect', function(user_id) {
    // TODO: query database for chats with this user_id,
    //       send chat dictionary to user
    console.log('User connected');
    db.getConnection(conn_attrs, function(err, conn) {
      if (err) { console.error(err.message); return; }
      conn.execute(
        'SELECT chat_id, buyer_id, seller_id, start_date, update_date ' +
        'FROM chat ' +
        'WHERE buyer_id = :id OR seller_id = :id',
        [user_id],
        function(err, result) {
          if (err) {
            console.error(err.message);
            socket.emit('user_connect_error');
            return;
          }
          socket.emit(result.rows);
          console.log(result.rows);
          console.log('User found in database');
        }
      );
    });
  });

  // User selects chat
  socket.on('select_chat', function(socket) {
    // TODO: query database for messages for this chat
    //       send message dictionary to user
  });

  // User sends message
  socket.on('msg', function(chat_id, user_id, date, msg) {
    // TODO: add message to database,
    //       send message to other user
    db.getConnection(conn_attrs, function(err, conn) {
      if (err) { console.error(err.message); return; }
      conn.execute(
        'INSERT INTO messages ' +
        'VALUES (:chat_id, :user_id, :message_date, :message_text',
        [chat_id, user_id, date, msg],
        function(err, result) {
          if (err) {
            console.error(err.message);
            socket.emit('msg_error');
            return;
          }
          console.log(result.rows);
          console.log('Message received');
        }
      );
    });
  });
});

http.listen(8163, function() {
  console.log('Chat service listening on 8163');
});