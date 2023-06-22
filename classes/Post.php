<?php

Class Post{
    private $pdo;
    //private $title;
    //private $id;
    //private $content;

    private const TABLE_NAME = "posts" ;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    

    public function createPost($title, $content, $author_id){
        $query = "INSERT INTO ".self::TABLE_NAME." (title, content, user_id) VALUES (:title, :content, :author_id)";

        try{
            $stmt = $this->pdo->prepare($query);

            //clean Data from potential hacking
            $author_id = htmlspecialchars(strip_tags($author_id));
            $title = htmlspecialchars(strip_tags($title));
            $content = htmlspecialchars(strip_tags($content));

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author_id', $author_id);

            $stmt->execute();

            return true;
        } catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function readAllPosts(){
        $query = "SELECT ".self::TABLE_NAME.".*, users.username FROM ".self::TABLE_NAME.
        " INNER JOIN users ON user_id = users.id ORDER BY "
        .self::TABLE_NAME.".created_at DESC;";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
            return false;
        }
    }

    public function read($id){
        $query = "SELECT p.title, p.content, p.user_id, p.created_at as createdAt, users.username AS author_name FROM ".self::TABLE_NAME.
        " p INNER JOIN users ON p.user_id = users.id WHERE p.id = ? LIMIT 0,1";
        try{
            $stmt = $this->pdo->prepare($query);

            //clean Data from potential hacking
            $id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(1, $id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
            echo e->getMessage();
            return false;
        }
    }

    public function delete($id){
        $query = "DELETE FROM ".self::TABLE_NAME." WHERE id = :post_id;";
        
        try{
            $stmt = $this->pdo->prepare($query);

            //clean Data from potential hacking
            $id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(":post_id", $id);
            $stmt->execute();

            return true;
        }catch(PDOException $e){
            echo e->getMessage();
            return false;
        }
    }

    public function update($title, $content, $id){
        $query = "UPDATE ".self::TABLE_NAME." SET title = :title, content= :content WHERE id=:id;";

        try{
            $stmt = $this->pdo->prepare($query);

            //clean Data from potential hacking
            $id = htmlspecialchars(strip_tags($id));
            $title = htmlspecialchars(strip_tags($title));
            $content = htmlspecialchars(strip_tags($content));

            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            return true;
        }catch(PDOException $e){
            echo e->getMessage();
            return false;
        }
    }
}



?>