<?php
require('../vendor/autoload.php');
$openapi = \OpenApi\scan('../../models/Post.php');
header('Content-Type: application/json');
echo $openapi->toJson();
