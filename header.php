<?PHP 
$newURL = "http://localhost:3000";
$path = explode("/",$_SERVER['REQUEST_URI'])[1];

if ($path !=="checkout") {
    header('Location: '.$newURL);
    die("This is Not authorize");
}
?>