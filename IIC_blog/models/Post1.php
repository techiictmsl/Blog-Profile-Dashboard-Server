<?php 

  class Post {
    
    // DB stuff
    private $conn;
    private $table = 'approved_articles';

    // Post Properties
    public $article_id;
    public $user_id;
    public $title;
    public $body;
    public $write_date;
    public $likes;
    public $views;
    public $img_link;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function user_read() {
      $query = 'SELECT SUBSTRING(p.body,1,200) as metacontent, p.title, p.write_date, p.img_link
                                FROM ' . $this->table . ' p
                  
                                WHERE 
                                  p.user_id = "'.$this->user_id.'";';

      //Prepare statement
      $stmt = $this->conn->prepare($query);
  

      // Execute query
      $stmt->execute();
  
      $row = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row = $stmt->fetchAll();

      return $row;             
    }
  }