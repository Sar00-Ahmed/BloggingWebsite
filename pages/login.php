<?php
require_once('../classes/user.php');
require_once('../config/database.php');
session_start();
include('../includes/header.php');
include('../includes/navbar.php');



//If the user is logged in
if(isset($_SESSION['id'])){
    /*redirect to dashboard*/
    header('Location: ../index.php'); //index.php 
        exit;
}


//send info to database
$result = true;
if($_POST && isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])){
    $user = new User($pdo);
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result =  $user->login($email, $password);

    //check if login was succesful
    if($result === true){
        header('Location: ../index.php');
        exit;
    }//else error will be printed
    
}
?>




<!-- Section: Design Block -->
<section class="text-center">
    <!-- Background image -->
        <div class="p-1 bg-image" style="background-image: url('../images/bedtimeWarmth-edit.png');height:400px; background-size: cover; background-position:bottom"></div>
    <!-- Background image -->

    <div class="card mx-4 mx-md-5 shadow-5-strong" style="
        margin-top: -100px;
        background: hsla(0, 0%, 100%, 0.8);
        backdrop-filter: blur(30px);
        ">
        <div class="card-body py-5 px-md-5">

            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-5">Log in</h2>
                    <?php if($result == false):?>
                        <div class= "alert alert-danger">
                            <p>the email address or the password is incorrect</p>
                        </div>
                    <?php endif?>
                    <form method="post">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Email</label>
                            <input name="email" type="email" id="form3Example3" class="form-control" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example4">Password</label>
                            <input name="password" type="password" id="form3Example4" class="form-control" />
                        </div>



                        <!-- Submit button -->
                        <button name="login" type="submit" class="btn btn-primary btn-block mb-4">
                            Log in
                        </button>

                        <!-- Register buttons -->
                        <div class="text-center">
                            <a href="register.php">or sign up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section: Design Block -->


<?php
include('../includes/footer.php')
?>