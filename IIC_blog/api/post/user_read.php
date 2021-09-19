<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require("../vendor/autoload.php");
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

  // Get post
  $post->user_read();

  // Create array
  $post_arr = array(
    'title' => $post->title,
    'body' => $post->body,
    'image_link' => $post->image_link,
    'auth_name' => $post->auth_name,
    'auth_designation' => $post->auth_designation,
    'facebook_link' => $post->facebook_link,
    'twitter_link' => $post->twitter_link,
    'linkedin_link' => $post->linkedin_link,

    
  );

  // Make JSON
  print_r(json_encode($post_arr));