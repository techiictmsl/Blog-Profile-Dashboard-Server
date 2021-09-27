<?php 
  /**
  * @OA\Info(title="IIC Blog REST API", version="1.0.0")
  */

  class Post {
    
    // DB stuff
    private $conn;
    private $table = 'unpublished_articles';

    // Post Properties
    public $article_id;
    public $user_id;
    public $title;
    public $body;
    public $auth_name;
    public $Auth_designation;
    public $write_date;
    public $domain;
    public $subdomain;
    public $article_status;
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
     * @OA\Get(path="/IIC_blog/api/post/read.php", tags={"Admin Dashboard - card view"},
     * @OA\Response(response="200", description="success"),
     * @OA\Response(response="404", description="Not found"),
     * )
     */

    // Get Posts
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

    /**
     * @OA\Get(
     *     path="/IIC_blog/api/post/read_single.php", tags={"Admin Dashboard - detailed view"},
     *      @OA\Parameter(
     *          name="article_id",
     *          description="Article ID",
     *          in="query",
     *          @OA\Schema (
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
 
    //Get single post
    public function read_single() {
      $query = 'SELECT auth_name, p.image_link, p.article_id, p.domain, p.subdomain, p.Auth_designation, p.title, p.body, p.likes, p.article_status, p.write_date, p.facebook_link, p.twitter_link, p.linkedin_link
                                FROM ' . $this->table . ' p
                  
                                WHERE 
                                  p.article_id = ?
                                LIMIT 0,1';
      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind ID
      $stmt->bindParam(1, $this->article_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //Set properties
      $this->auth_name = $row['auth_name'];
      $this->image_link = $row['image_link'];
      $this->Auth_designation = $row['Auth_designation'];
      $this->title = $row['title'];
      $this->domain = $row['domain'];
      $this->subdomain = $row['subdomain'];
      $this->body = $row['body'];
      $this->likes = $row['likes'];
      $this->article_status = $row['article_status'];
      $this->write_date = $row['write_date'];
      $this->facebook_link = $row['facebook_link'];
      $this->twitter_link = $row['twitter_link'];
      $this->linkedin_link = $row['linkedin_link'];
                    
    }

    /**
     * @OA\Put(path="/IIC_blog/api/post/update.php", tags={"Admin Dashboard - accept/reject"},
     * @OA\Response(response="200", description="success"),
     * @OA\Response(response="404", description="Not found"),
     * )
     */
    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET article_status = :article_status
                                WHERE article_id = :article_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->status = htmlspecialchars(strip_tags($this->status));

          $this->article_id = htmlspecialchars(strip_tags($this->article_id));

          // Bind data

          $stmt->bindParam(':article_status', $this->article_status);
          $stmt->bindParam(':article_id', $this->article_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
  
    /**
     * @OA\Get(
     *     path="/IIC_blog/api/post/user_read.php", tags={"User Dashboard - Unpublished articles"},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="UserID",
     *          in="query",
     *          @OA\Schema (
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
  //User Dashboard
  public function user_read() {
    $query = 'SELECT auth_name, p.image_link, p.user_id, p.domain, p.Auth_designation, p.title, p.body, p.likes, p.article_status, p.write_date, p.facebook_link, p.twitter_link, p.linkedin_link
                              FROM ' . $this->table . ' p
                
                              WHERE 
                                p.user_id = ?';
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Bind ID
    $stmt->bindParam(1, $this->user_id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //Set properties
    $this->auth_name = $row['auth_name'];
    $this->image_link = $row['image_link'];
    $this->Auth_designation = $row['Auth_designation'];
    $this->title = $row['title'];
    $this->domain = $row['domain'];
    $this->body = $row['body'];
    $this->likes = $row['likes'];
    $this->article_status = $row['article_status'];
    $this->write_date = $row['write_date'];
    $this->facebook_link = $row['facebook_link'];
    $this->twitter_link = $row['twitter_link'];
    $this->linkedin_link = $row['linkedin_link'];
                  
  }
}