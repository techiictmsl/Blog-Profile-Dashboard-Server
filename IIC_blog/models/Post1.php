<?php 
  /**
  * @OA\Info(title="IIC Blog REST API", version="1.0.0")
  */

  class Post {
    
    // DB stuff
    private $conn;
    private $table = 'published_articles';

    // Post Properties
    public $article_id;
    public $user_id;
    public $title;
    public $body;
    public $auth_name;
    public $auth_designation;
    public $write_date;
    public $domain;
    public $sub_domain;
    public $status;
    public $likes;
    public $views;
    public $image_link;
    public $image_count;
    public $facebook_link;
    public $twitter_link;
    public $linkedin_link;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }
    /**
     * @OA\Get(path="/IIC_blog/api/post/user_read1.php", tags={"models"},
     * @OA\Response(response="200", description="success"),
     * @OA\Response(response="404", description="Not found"),
     * )
     */
    public function read() {
        // Create query
        $query = 'SELECT SUBSTRING(p.body,1,200) as metacontent, p.title, p.write_date, p.image_link
                                  FROM ' . $this->table . ' p
                    
                                  ORDER BY
                                    p.write_date DESC';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
  
        // Execute query
        $stmt->execute();
  
        return $stmt;
    }
  }