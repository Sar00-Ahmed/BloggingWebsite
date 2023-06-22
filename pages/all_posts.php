<?php
include('../includes/header.php');
require_once('../classes/Post.php');
require_once('../config/database.php');

session_start();
$posts = new Post($pdo);

$result = $posts->readAllPosts();

if($result){
    print_r($result);
}
else{
    echo "ther are currently no posts, lets go create some LINK";
}

?>

<?php
include('../includes/footer.php');
?>