<?PHP

class Database {
   
    /** 
    *public $public = 'I am public field or veriable';
    *private $private = 'I am private field or veriable';
    *protected $protected = 'I am protected field or veriable';
    */
    /** 
    *----------------self VS this Operetor in PHP-----------------
    *The self and this are two different operators which are used to represent current class and current object respectively. 
    *self is used to access static or class variables or methods and this is used to access non-static or object variables or 
    *to access a property belonging to the object of the class.
    */

    public  $pdo;
    public static $instance;

   public function __construct(){

         $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER_NAME,DB_PASS);
   }

   public static function instance(){   // This method will store the instance of the class into this instance variable so that we can get the values without creating the class object from the class

        if(self::$instance === null){

            self::$instance = new self; // same as self::$instance = new Database();
        }
        return  self::$instance;

   }
   public function __call($name, $arguments) // __call() fuction will check wheather any undefined function is callled or not ? and return that undefined function name and arguments Every functio start with double undrscore is known as Magic Function.
   {
       //var_dump($name);
       var_dump($arguments);
       //return call_user_func_array(array($this->pdo,$method_name),$arguments);
   }




}


