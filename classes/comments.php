<?php
Class Comments{
    private $pdo;
    
    private const TABLE_NAME = "comments" ;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    

    public function addComment($post_id, $content, $author_id){
        $query = "INSERT INTO ".self::TABLE_NAME." (content, user_id, post_id) VALUES (:content, :author_id, :post_id)";

        try{
            $stmt = $this->pdo->prepare($query);

            //clean Data from potential hacking
            $author_id = htmlspecialchars(strip_tags($author_id));
            $content = htmlspecialchars(strip_tags($content));
            $post_id = htmlspecialchars(strip_tags($post_id));

            $stmt->bindParam(':post_id', $post_id);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author_id', $author_id);

            $stmt->execute();

            return true;
        } catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function readAllComments($post_id){
        $query = "SELECT C.*, users.username FROM ".self::TABLE_NAME." C INNER JOIN users ON user_id = users.id WHERE `post_id` = :post_id ORDER BY c.created_at DESC;";
        try{
            $stmt = $this->pdo->prepare($query);

            $post_id = htmlspecialchars(strip_tags($post_id));
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        }catch(PDOException $e){
            echo $e->getmessage();
            return false;
        }
    }

    public function delete($id){
        $query = "DELETE FROM ".self::TABLE_NAME." WHERE id = :comment_id;";
        
        try{
            $stmt = $this->pdo->prepare($query);

            //clean Data from potential hacking
            $id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(":comment_id", $id);
            $stmt->execute();

            return true;
        }catch(PDOException $e){
            echo e->getMessage();
            return false;
        }
    }
}
?>