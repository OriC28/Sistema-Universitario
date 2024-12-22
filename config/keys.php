<?php

$key = file_get_contents("config/private-key.pem");
$iv = substr($key, 0, 16);

?>