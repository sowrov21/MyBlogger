<?PHP

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $userIP   = json_decode($_POST['userID']);
    $country   = json_decode($_POST['country']);
    echo  $userIP; 
    echo  $country;
}