<!-- Navigation-->
<?php
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
       header("location: ../pages/login.php");
       exit();
}

?>

<nav class="navbar navbar-expand">
        <div class="container px-1 px-lg-5">
            <a class="navbar-brand Logo" href="index.html">Suu~ blog</a>
            
            <div class=" navbar-collapse" id="responsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="">About</a></li>
                    <?php
                    if (!isset($_SESSION['id'])) {
                    ?>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4 active" href="../pages/register.php">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4 active" href="../pages/login.php">LOGIN</a></li>
                    <?php } else { ?>
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href=""><?= $_SESSION['username'] ?></a>
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