<?php

class User{
    private $pdo; //connection
    private $username;
    private $email;
    private $password;
    private const TABLE_NAME = "users";

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    private function validate($username, $email, $password){
        // validate the data
        $errors;
        if(empty($username)){
            $errors[] = "please enter a username.";
        }
        if(empty($email)){
            $errors[] = "please enter an email.";
        }
        if(empty($password)){
            $errors[] = "please enter a password.";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "please enter a valid email.";
        }
        //check if email or username is in use
        $query = "SELECT COUNT(*) FROM ".self::TABLE_NAME." WHERE email = :email OR username = :username;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(':email' =>$email, ':username' => $username));
        $count = $stmt->fetchColumn();

        if($count != 0){
            $errors[] = "user already exists.";
        }

        return $errors;
    }

    public function register($username, $email, $password){
        
        $errors = $this->validate($username, $email, $password);
        
        if(empty($errors)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO ".self::TABLE_NAME."( username, email, password) VALUES (:username, :email, :password)";
            $insert = $this->pdo->prepare($query);
            $insert->execute(array(':username' => $username, ':email'=> $email, ':password'=> $hash));
            return true;
        } else{
            return $errors;
        }
    }

    public function login($email, $password){
        //check if email or username is in use
        $query = "SELECT * FROM ".self::TABLE_NAME." WHERE email = :email;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(':email' =>$email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if( $user && password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            return true;
        }
        else{
            return false; 
        }
    }
}





?>