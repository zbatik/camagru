<?php
    class DB
	{
        protected $host = 'localhost';
        protected $db   = 'camagru';
        protected $user = 'root';
        protected $pass = 'password';
        protected $charset = 'utf8mb4';
        protected $dsn;
        protected static $pdo = null;
        protected $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        public function getConnection()
        {
            if (self::$pdo == null)
                self::$pdo = new PDO($this->dsn, $this->user, $this->pass, $this->options);
            return self::$pdo;
        }

        public function __construct()
        {
            $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $this->getConnection();
        }
    
        /*
        public function QueryUsername ($username) { 
            $stmt = self::$pdo->prepare('SELECT * FROM user WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user != null)
                return 1;
            else
                return 0;
        }*/

        public function ItemExists ($field, $equals) { 
            $return = $this->SelectWhere('user', $field, $equals);
            if ($return != null)
                return 1;
            else
                return 0;
        }

        public function SelectWhere ($table, $field, $equals) { 
            $stmt = self::$pdo->prepare("SELECT * FROM ".$table." WHERE ".$field." = ?");
            $stmt->execute([$equals]);
            $ret = $stmt->fetch();
            return $ret;
        }

        public function InsertIntoUser ($username, $email, $password, $token) {
            $stmt = self::$pdo->prepare("INSERT INTO user (username, email, password, token)
                VALUES (:username, :email, :password, :token)");
            
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'token' => $token
            ]);
        }

        public function InsertIntoGallery ($username, $photo_data, $time_stamp) {
            $stmt = self::$pdo->prepare("INSERT INTO gallery (username, photo_data, time_stamp)
                VALUES (:username, :photo_data, :time_stamp)");
            
            $stmt->execute([
                'username' => $username,
                'photo_data' => $photo_data,
                'time_stamp' => $time_stamp
            ]);
        }

        public function GetUserInfo ($field, $value) { 
            return $this->SelectWhere('user', $field, $value);
        }

        public function UpdateUserItem($setfield, $setval, $wherefield, $whereval) {
            $sql = "UPDATE user SET $setfield=:setval WHERE $wherefield=:whereval";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([
                "setval" => $setval,
                "whereval" => $whereval
            ]);
        }

        public function ActivateUser($username) {
            $sql = "UPDATE user SET validated=1 WHERE username=:username";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute(["username" => $username]);      
        }

        public function ResetPassword($email, $newpassword) {
            $sql = "UPDATE user SET password=:newpsw WHERE email=:email";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([
                "newpsw" => $newpassword,
                "email" => $email
            ]);    
        }
    }
?>