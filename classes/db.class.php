<?php
    class DB
	{
        protected $host = 'localhost';
        protected $db   = 'camagru';
        protected $user = 'root';
        protected $pass = 'password';
        protected $charset = 'utf8mb4';
        protected $dsn;
        protected $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        public function __construct()
        {
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        }

        public function PDOInstance () {
            $pdo = new PDO($this->$dsn, $this->$user, $this->$pass, $this->$options);
            return ($pdo);
        }
    
        public function QueryUsername ($username) { 
            $pdo = $this->PDOInstance;
            $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user != null)
                return 1;
            else
                return 0;
        }
    }
?>