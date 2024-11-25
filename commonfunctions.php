<?php

//  connection with database
require_once "dbconnect.php";

// show error
ini_set("display_errors", 1);

// this function take the user data with email
function getuser($email){
    try {
        $conn = connect();
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// this function take the number of cart products by user id
function getcartcount($userid){
    try {
        $conn = connect();
        $sql = "SELECT COUNT(*) AS count FROM cart WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userid]);
        $count = $stmt->fetch();
        return $count;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// this function take all category from database
function getcategory()
{
    try {
        $conn = connect();
        $sql = "SELECT * FROM category";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $category = $stmt->fetchAll();
        return $category;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getmaxprice(){
    try {
        $conn = connect();
        $sql = "SELECT MAX(price) AS highest_price FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $highestprice = $stmt->fetch();
        return $highestprice;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getminprice(){
    try {
        $conn = connect();
        $sql = "SELECT MIN(price) AS lowest_price FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $lowestprice = $stmt->fetch();
        return $lowestprice;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>