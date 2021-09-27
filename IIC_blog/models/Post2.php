<?php 

  class Post {
    
    // DB stuff
    private $conn;
    private $table1 = 'user_history';
    private $table2 = 'approved_articles';

    // Post Properties
    public $article_id;
    public $user_id;
    public $date;
    public $like_status;
    public $body;
    public $title;
    public $write_date;
    public $img_link;



    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function user_history_read() {
      $query = 'SELECT p.article_id
                                FROM ' . $this->table1 . ' p
                  
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

    public function article_card($article_id){
      $query1 = 'SELECT SUBSTRING(p.body,1,200) as metacontent, p.title, p.write_date, p.img_link '.
                                'FROM ' . $this->table2 . ' p '.
                  
                                'WHERE '. 
                                  'p.article_id = "'.$article_id.'";';
      
      //Prepare statement
      //echo($query1);
      $stmt1 = $this->conn->prepare($query1);

      // Execute query
      $stmt1->execute();

      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

      //Set properties
      $this->metacontent = $row1['metacontent'];
      $this->title = $row1['title'];
      $this->write_date = $row1['write_date'];
      $this->img_link = $row1['img_link'];
    }
  }