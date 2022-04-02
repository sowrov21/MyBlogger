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

    public function ID(){
      if($this->isLogged()){
       return $_SESSION['	user_id'];
      }
    }

    public function userData($user_id = null){
      $user_id  = (($user_id === null) ? $this->ID() : $user_id);
      $statement = $this->db->prepare("SELECT * FROM users WHERE  id = :id");
      $statement->bindParam(":id", $user_id, PDO::PARAM_INT);
      $statement->execute();
      return $statement->fetch(PDO::FETCH_OBJ);
    }

}