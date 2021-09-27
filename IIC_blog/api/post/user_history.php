<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require("../vendor/autoload.php");
  include_once '../../config/Database.php';
  include_once '../../models/Post2.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

  // Get post
  $result = $post->user_history_read();

  // Make JSON
  //print_r(json_encode($result));

  for ($i = 0; $i < count($result); $i++) {
    //echo $result[$i]['article_id'];
    $post->article_id = $result[$i]['article_id'];
    $post->article_card($post->article_id);
    $post_arr = array(
        'title' => $post->title,
        'metacontent' => $post->metacontent, 
        'img_link' => $post->img_link,
        'write_date' => $post->write_date,
        
      );
    
    // Make JSON
    print_r(json_encode($post_arr));

    //$result = $post->user_read();
    //print_r(json_encode($result));

  }