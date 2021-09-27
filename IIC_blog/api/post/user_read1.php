<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require("../vendor/autoload.php");
  include_once '../../config/Database.php';
  include_once '../../models/Post1.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

  // Get post
  $result = $post->user_read();

  // Create array
  /*$post_arr = array(
    'title' => $post->title,
    'metacontent' => $post->metacontent,
    'img_link' => $post->img_link,   
  );*/

  // Make JSON
  print_r(json_encode($result));