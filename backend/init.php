<?PHP
    //require_once 'classes/Database.php';
    session_start();
    spl_autoload_register( function($class_name){

        require_once "classes/".$class_name.".php"; 

    });
//Define conatant
    define("DB_HOST","localhost");
    define("DB_NAME","blogger");
    define("DB_USER_NAME","root");
    define("DB_PASS","");
    define("BASE_URL","http://localhost/MyBlogger/");
/*
 //creating object or instance of Database Class

 //$db = new Database();
 //echo $db->public;
 //$db->private;
 //$db->protected;

 class init extends Database{

    function __construct()
    {
        $db = new Database();

        echo $db->protected;
    }
  
 }

 $i = new init();
*/

$userObj = new Users;
$dashObj = new Dashboard;

