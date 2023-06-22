<?php
include('../includes/header.php');
include('../includes/navbar.php');

require_once('../classes/user.php');
require_once('../config/database.php');

//send info to database
$result = true;
if($_POST && isset($_POST['register'])){
    $user = new User($pdo);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result =  $user->register($username, $email, $password);

    //check if registry was succesful
    if($result === true){
        header('Location: login.php');
        exit;
    }
}

?>
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
                    <h2 class="fw-bold mb-5">Sign Up</h2>
                    <?php if($result !== true):?>
                    <div class= "alert alert-danger">
                        <ul>
                            <?php foreach($result as $error):?>
                                <li><?= $error ?></li>
                            <?php endforeach?>
                        </ul>
                    </div>
                    <?php endif?>
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary mt-2">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include('../includes/footer.php');
?>