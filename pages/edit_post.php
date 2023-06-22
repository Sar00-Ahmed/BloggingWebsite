<?php
include_once '../config/database.php';
include_once('../classes/Post.php');
session_start();
include('../includes/header.php');
include('../includes/navbar.php');

$post = new Post($pdo);

$result;
if(isset($_GET['id'])){
    $result = $post->read($_GET['id']);
}

if(isset($_POST['edit'])){
    if($post->update($_POST['title'], $_POST['content'],$_GET['id'])){
        header('Location: ../index.php');
    }
}



?>


<section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="
        background-image: url('../images/bedtimeWarmth-edit.png');height:400px; background-size: cover; background-position:bottom;
        height: 300px;
        "></div>
    <!-- Background image -->

    <div class="card mx-4 mx-md-5 shadow-5-strong" style="
        margin-top: -100px;
        background: hsla(0, 0%, 100%, 0.8);
        backdrop-filter: blur(30px);
        ">
        <div class="card-body py-5 px-md-5">

            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-5">Edit Post</h2>
                    <form method="post">
                        <!-- title input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Title</label>
                            <input value=<?= $result['title'] ?> name="title" type="text" id="form3Example3" class="form-control" />
                        </div>

                        <!-- content input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example4">Content</label>
                            <textarea name="content" type="password" id="form3Example4" class="form-control"
                                required><?= $result['content'] ?></textarea>
                        </div>



                        <!-- Submit button -->
                        <button name="edit" type="submit" class="btn btn-primary btn-block mb-4">
                            Edit Post
                        </button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- HTML form for adding a new post -->