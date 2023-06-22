<?php
include_once '../config/database.php';
include_once('../classes/Post.php');
include_once('../classes/comments.php');
session_start();
include('../includes/header.php');
include('../includes/navbar.php');

$post = new Post($pdo);

$result_post;
if(isset($_GET['id'])){
    $result_post = $post->read($_GET['id']);
}

if(isset($_POST['delete_post'])){
    if($post->delete($_GET['id'])){
        header('Location: ../index.php');
    }
}

$comment = new Comments($pdo);
$comments = $comment->readAllComments($_GET['id']);

if (isset($_POST['add_comment'])) {
    // Create a new Post object and set its properties
    $new_comment = new Comments($pdo);

    // Attempt to create the post
    if ($new_comment->addComment( $_GET['id'], $_POST['content'], $_SESSION['id'])) {
        // Redirect to the homepage or display a success message
        header('Location: '.$_SERVER['REQUEST_URI']);
        exit;
    } else {
        // Display an error message
        echo 'An error occurred while adding the comment.';
    }
}


if(isset($_POST["delete_comment"])){
    $comment->delete($_POST["delete_comment"]);
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit;
}
?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('../images/bedtimeWarmth-edit.png');height:400px; background-size: cover; background-position:bottom">
    <div class="container position-relative px-4 px-lg-5">

        <?php
        if(isset($_SESSION['id'])):
        if($_SESSION['id']==$result_post['user_id']) :?>
        <div clas="d-flex flex-row">
            <form method="post" class="p-3">
            <a href=<?= "./edit_post.php?id=" . $_GET['id'] ?> class=" btn" type="submit"><i
                        class="bi bi-pencil-square text-white bi-3"></i></a>
                <button class="btn" type="submit" name="delete_post"><i class="bi bi-trash3-fill text-white bi-3"></i></button>
            </form>
        </div>
        <?php endif; endif;?>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="post-heading">
                <h2>
                    <?php
                    if (isset($result_post['title'])) :
                        echo $result_post['title'];
                    endif
                    ?>
                </h2>

                <span class="meta">

                    Posted by
                    <a href="#!">
                        <?php
                        if (isset($result_post['author_name'])) :
                            echo $result_post['author_name'];
                        endif
                        ?>
                    </a>
                    <?php
                    if ($result_post) :
                        echo $result_post['createdAt'];
                    endif
                    ?>
                </span>
            </div>
        </div>
    </div>
    </div>
</header>
<!-- Post Content--> 

<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <p>
                    <?php
                    if ($result_post) :
                        echo $result_post['content'];
                    endif
                    ?>
                </p>
            </div>
        </div>
    </div>
</article>

 <!--display comments-->
<div class="container pt-3 px-4 px-lg-5">
    <h2>Comments</h2>
    <?php if (isset($_SESSION['id'])):?>
    <form method="post">
        <!-- content input -->
        <div class="form-outline mb-4">
            <textarea name="content" type="password" id="form3Example4" class="form-control"
                required></textarea>
        </div>  

        <!-- Submit button -->
        
        <button name="add_comment" type="submit" class="btn add_post btn-dark">
            add comment <i class="bi bi-plus-circle-fill"></i>
        </button>
        

    </form>
    <?php endif ?>     
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class=" col-md-10 col-lg-8 col-xl-7">

                <?php foreach ($comments as $current) { ?>
                    <div class="border-top post-preview">
                        <h2 class="post-title"><?php echo $current['username'] ?></h2>
                            <p class="post-subtitle"><?php
                                echo $current['content'] ?>
                        <p class="post-meta">
                            Posted at
                            <?php echo $current['created_at']; ?>
                           <?php if(isset($_SESSION['id'])):
                            if($_SESSION['id']==$current['user_id']) :?>
                            <div clas="d-flex flex-row">
                                <form method="post" class="p-3">
                                    <button class="btn" type="submit" value=<?=$current['id']?> name="delete_comment"><i class="bi bi-trash3-fill bi-3"></i></button>
                                </form>
                            </div>
                            <?php endif; endif;?>
                        </p>
                    </div>
                <?php } ?>
                <!-- Divider-->
                <hr class="my-4" />
                <!-- Pager-->
                <div class="d-flex justify-content-end mb-4"><a class="btn btn-dark add_post text-uppercase" href="../index.php">Other Posts →</a></div>
            </div>
        </div>
    </div>

<?php
include('../includes/footer.php');
?>