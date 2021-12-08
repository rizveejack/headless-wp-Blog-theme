<?PHP 
$path = explode("/",$_SERVER['REQUEST_URI'])[1];

if ($path =="cart" or $path =="shop") {
    $newPath = HEADLESS_URL."/".$path;
    header('Location: '.$newPath);
}
elseif($path =="checkout"){
}
else{
    header('Location: '.HEADLESS_URL);
    die("This is Not authorize");
}
?>