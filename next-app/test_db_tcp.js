const mysql = require('mysql2');

const connection = mysql.createConnection({
  host: '192.168.100.5',
  port: 3306,
  user: 'root',
  password: '',
  database: 'testbtx2025'
});

connection.connect((err) => {
  if (err) {
    console.error('Connection Failed: ' + err.message);
    process.exit(1);
  }
  console.log('Connection Successful!');
  connection.end();
});
