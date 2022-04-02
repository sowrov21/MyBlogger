<?php
class Users{

    public $db;

    public function __construct(){

        $this->db = Database::instance();
    }

    public function checkExistingEmail($email){

        $statement = $this->db->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $statement->bindParam(":email",$email,PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function hash($password){

        return password_hash($password,PASSWORD_BCRYPT);
    }

    public function isLogged(){
        
      return ((isset($_SESSION['user_id']) )? true : false);
    }

}