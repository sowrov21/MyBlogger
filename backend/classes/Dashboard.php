<?PHP 
  class Dashboard{
    protected $db;
    protected $user;

    public function __construct(){
        $this->db   = Database::instance();
        $this->user = new Users;
    }

    public function blogAuth($blogID){
       $user_id   = $this->user->ID();
       $statement = $this->db->prepare("SELECT * FROM `blogs` `B`, `blogsAuth` `A`
                                                 LEFT JOIN `users` `U` ON `A`.`userID` = `U`.`id` 
                                                 WHERE `B`.`blogID` = `A`.`blogID` AND `B`.`blogID` = :blogID
                                                 AND `U`.`id` = :id ");
        $statement->bindParam(":blogID", $blogID,PDO::PARAM_INT);
        $statement->bindParam(":id", $user_id,PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
  }