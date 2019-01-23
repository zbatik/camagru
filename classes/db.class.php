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

        public function InsertIntoGallery ($user_id, $photo_data, $time_stamp) {
            $stmt = self::$pdo->prepare("INSERT INTO gallery (user_id, photo_data, time_stamp)
                VALUES (:user_id, :photo_data, :time_stamp)");
            
            $stmt->execute([
                'user_id' => $user_id,
                'photo_data' => $photo_data,
                'time_stamp' => $time_stamp
            ]);
        }
        
        public function CountPosts () {
            $stmt = self::$pdo->prepare("SELECT count(*) as total FROM gallery");
            $stmt->execute();
            $ret = $stmt->fetch();
            return $ret["total"];
        }

        public function AddLike ($photo_id, $user_id) {
            $stmt = self::$pdo->prepare("INSERT INTO likes (photo_id, user_id)
                VALUES (:photo_id, :user_id)");
            
            $stmt->execute([
                'user_id' => $user_id,
                'photo_id' => $photo_id
            ]);
        }

        public function AddComment ($photo_id, $user_id, $comment, $time_stamp) {
            $stmt = self::$pdo->prepare("INSERT INTO comments (photo_id, user_id, comment, time_stamp)
                VALUES (:photo_id, :user_id, :comment, :time_stamp)");
            
            $stmt->execute([
                'user_id' => $user_id,
                'photo_id' => $photo_id,
                'comment' => $comment,
                'time_stamp' => $time_stamp
            ]);
        }

        public function DeleteLike ($photo_id, $user_id) {
            $stmt = self::$pdo->prepare("DELETE FROM likes WHERE photo_id=:photo_id AND user_id=:user_id");
            $stmt->execute([
                "photo_id" => $photo_id,
                "user_id" => $user_id
                ]); 
        }

        public function DeletePhoto ($photo_id) {
            $stmt1 = self::$pdo->prepare("DELETE FROM likes WHERE photo_id=:photo_id");
            $stmt1->execute(["photo_id" => $photo_id]); 

            $stmt2 = self::$pdo->prepare("DELETE FROM gallery WHERE id=:photo_id");
            $stmt2->execute(["photo_id" => $photo_id]);

            $stmt3 = self::$pdo->prepare("DELETE FROM comments WHERE photo_id=:photo_id");
            $stmt3->execute(["photo_id" => $photo_id]);
        }

        public function SelectAllPhotos($off) { 
           
            $stmt = self::$pdo->prepare("SELECT * FROM gallery
                    ORDER BY time_stamp DESC 
                    LIMIT 5 
                    OFFSET :off");
           $stmt->execute(["off" => $off]);
           return $stmt;
           // OG attempt
            // $stmt = self::$pdo->prepare("SELECT * FROM gallery
            // LEFT JOIN 
            // (SELECT photo_id, COUNT(photo_id) AS likes
            // FROM likes 
            // GROUP BY photo_id ) AS COUNTED
            // ON
            // COUNTED.photo_id = gallery.id
            // ORDER BY time_stamp DESC");
            // $stmt->execute();
            // // $ret = $stmt->fetch(PDO::FETCH_ASSOC);
            // return $stmt;
        }

        public function SelectComments($photo_id) { 
            $stmt = self::$pdo->prepare("SELECT username, comment, email
            FROM comments
            INNER JOIN user ON user.id=comments.user_id
            WHERE photo_id=:photo_id
            ORDER BY time_stamp DESC"
            );
            $stmt->execute(["photo_id" => $photo_id]);
            return $stmt;
        }
        public function QueryEmailFromPhotoID($photo_id) {
            $stmt = self::$pdo->prepare("SELECT email, receive_notifications
            FROM user
            JOIN gallery ON user.id=gallery.user_id
            WHERE photo_id=:photo_id"
            );
            $stmt->execute(["photo_id" => $photo_id]);
            return $stmt;
        }
        public function SelectUserPhotos($user_id) { 
            $stmt = self::$pdo->prepare("SELECT * FROM gallery
            WHERE user_id=:user_id
            ORDER BY time_stamp DESC");
            $stmt->execute(["user_id" => $user_id]);
            return $stmt;
        }

        public function GetUserInfo ($field, $value) { 
            return $this->SelectWhere('user', $field, $value);
        }

        public function IsLiked ($user_id, $photo_id) { 
            $stmt = self::$pdo->prepare("SELECT * FROM likes WHERE photo_id=:photo_id AND user_id=:user_id");
            $stmt->execute([
                "photo_id" => $photo_id,
                "user_id" => $user_id
                ]);   
            $ret = $stmt->fetch();
            if ($ret == null)
                return 0;
            else
                return 1;
        }

        public function UpdateUserItem($setfield, $setval, $wherefield, $whereval) {
            try {
            $sql = "UPDATE user SET $setfield=:setval WHERE $wherefield=:whereval";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([
                "setval" => $setval,
                "whereval" => $whereval
            ]);
                return 1;
            } catch (PDOException $e) {
                return 0;
            }
        }

        public function UpdateEmailNotificationPreferences($user_id, $preference) {
            $sql = "UPDATE user SET receive_notifications=:preference WHERE id=:user_id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([
                "user_id" => $user_id,
                "preference" => $preference
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