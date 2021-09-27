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
  $post->article_id = isset($_GET['article_id']) ? $_GET['article_id'] : die();

  // Get post
  $post->read_single();

  // Create array
  $post_arr = array(
    'title' => $post->title,
    'subdomain' => $post->sub_domain, 
    'body' => $post->body,
    'image_link' => $post->image_link,
    'auth_name' => $post->auth_name,
    'Auth_designation' => $post->auth_designation,
    'write_date' => $post->write_date,
    'facebook_link' => $post->facebook_link,
    'twitter_link' => $post->twitter_link,
    'linkedin_link' => $post->linkedin_link,
    
  );

  // Make JSON
  print_r(json_encode($post_arr));