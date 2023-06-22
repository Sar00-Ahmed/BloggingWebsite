<?php
include_once './config/database.php';
include_once('./classes/Post.php');

session_start();


$post = new Post($pdo);
$posts = $post->readAllPosts();

if(isset($_POST['Log_Out'])){
    echo "log out";
    // Initialize the session
   session_start();
   // Unset all of the session variables
      session_unset();
      $_SESSION = array();
   
   // Destroy the session.
       session_destroy();
       unset($_SESSION['id']);
   // Redirect to login page
       header("location: ./pages/login.php");
       exit();
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blogging Home - Su~</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500&family=Comfortaa:wght@500&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- Core theme CSS-->
    <link rel="stylesheet" href="./Css/stylesheet.css">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
</head>

<body>
    <!-- Navigation-->
    <!-- <nav class="navbar navbar-expand-lg">-->
    <nav class="navbar navbar-expand">
        <div class="container px-1 px-lg-5">
            <a class="navbar-brand Logo" href="">Suu~ blog</a>
            <div class="navbar-collapse" id="responsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link  px-lg-3 py-3 py-lg-4" href="">Home</a></li>
                    <li class="nav-item"><a class="nav-link  px-lg-3 py-3 py-lg-4" href="">About</a></li>
                    <?php
                    if (!isset($_SESSION['id'])) {
                    ?>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4 active" href="./pages/register.php">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4 active" href="./pages/login.php">LOGIN</a></li>
                    <?php } else { ?>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href=""><?= $_SESSION['username'] ?></a>
                    </li>
                    <?php } ?>

                </ul>
            </div>
            <?php
            if (isset($_SESSION['id'])):
            ?>
            <form method="post" action="#">
            <button name="Log_Out" type="submit" class="btn nav-item">Log Out </button>
            </form>
            <?php endif ?>
        </div>
    </nav>
   
    <header style="background-image: url('./images/bedtimeWarmth-edit.png');height:400px; background-size: cover; background-position:bottom">
        <div class="container position-relative px-1 px-lg-2">
            <div class="row gx-4 gx-lg-5 justify-content-start">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Blogging Home</h1>
                        <span class="subheading">A Blog Website by Suu~</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--display posts-->
    <div class="container pt-3 px-4 px-lg-5">
        <?php if (isset($_SESSION['id'])):?>
        <div class="d-flex flex-row">
            <a href=./pages/create_post.php class="rounded add_post"> add post
            <i class="bi bi-plus-circle-fill"></i></a>
        </div>
        <?php endif ?>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class=" col-md-10 col-lg-8 col-xl-7">

                <?php foreach ($posts as $post) { ?>
                <div class="border-top post-preview">
                    <a href=<?= "pages/view_post.php?id=".$post['id'] ?>>
                        <h2 class="post-title"><?php echo $post['title'] ?></h2>
                        <p class="post-subtitle"><?php
                        if(strlen($post['content'])>37){
                            echo substr($post['content'], 0, 37)."...";
                        }
                        else
                            echo $post['content']; ?></p>
                    </a>
                    <p class="post-meta">
                        Posted by
                        <a href="#!"><?php echo $post['username']; ?></a>
                        <?php echo $post['created_at']; ?>
                    </p>
                </div>


                <?php } ?>
                <!-- Divider-->
                <hr class="my-4" />
                <!-- Pager-->
                <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a></div>
            </div>
        </div>
    </div>

    <footer class="border-top pt-2">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://github.com/Sar00-Ahmed">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="small text-center text-muted fst-italic">Copyright &copy; sara Ahmed 2023</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>