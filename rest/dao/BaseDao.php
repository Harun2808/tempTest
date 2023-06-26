<?php

class BaseDao {

    private $conn;

    public function __construct(){
        try {
            $servername = "db-mysql-nyc1-13993-do-user-3246313-0.b.db.ondigitalocean.com";
            $port = 25060;
            $username = "doadmin";
            $password = "AVNS_z6PG_c6BSn-5dB0CG5S";
            $database = "final-midterm2-2023";

            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => '/path/to/your/ca_file.pem',
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            );

            // Create new connection
            $dsn = "mysql:host=$servername;port=$port;dbname=$database;sslmode=REQUIRED";
            $this->conn = new PDO($dsn, $username, $password, $options);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

}
?>
