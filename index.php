<!DOCTYPE html>
<html lang="en">
<body>


<?php
include "handlers/hello.php";
include "handlers/random.php";
include "handlers/today.php";

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

if($uri_segments[1] && is_callable($uri_segments[1])) {
    $uri_segments[1]();
}
?>
<br />
Text after func


</body>
</html>