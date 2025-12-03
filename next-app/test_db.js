const mysql = require('mysql2');

const connection = mysql.createConnection({
  socketPath: '\\\\.\\pipe\\MySQL',
  user: 'root',
  password: '',
  database: 'testbtx2025'
});

connection.connect((err) => {
  if (err) {
    console.error('Error connecting: ' + err.stack);
    return;
  }
  console.log('Connected as id ' + connection.threadId);
  connection.end();
});
