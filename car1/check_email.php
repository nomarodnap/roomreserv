<?php

require './con.php';

// เช็คว่ามีค่าจาก input มาไหม จากนั้นก็ทำการ query ข้อมูลเช็ค email ว่ามีในระบบหรือไม่
if (isset($_POST['email_check'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM user WHERE email = '$email' ";
    $results = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($results) > 0) {
        echo 'taken';
    } else {
        echo 'not_taken';
    }
    exit();
}

// เช็คว่ามีค่าจาก input มาไหม จากนั้นก็ทำการ query ข้อมูลเช็ค email ว่ามีในระบบหรือไม่
if (isset($_POST['email_check'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM user WHERE email = '$email' ";
    $results = mysqli_query($mysqli, $sql);
    // ถ้ามีข้อมูลในระบบแล้วให้ echo (response) ส่งค่ากลับไปว่า taken 
    if (mysqli_num_rows($results) > 0) {
        echo 'taken';
    } else {
        // ถ้ายังไม่มีข้อมูลในระบบแล้วให้ echo (response) ส่งค่ากลับไปว่า not_taken
        echo 'not_taken';
    }
    exit();
}

// เช็คว่ามีค่า save มาจาก submit ไหม ถ้ามีให้เก็บค่าตามตัวแปลแล้วเช็คข้อมูลในระบบ ถ้าไม่ซ้ำก็ให้เพิ่มข้อมูลตัวใหม่เข้าไปได้
if (isset($_POST['save'])) {
    $email = $_POST['email'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email = '$email' ";
    $results = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($results) > 0) {
        echo "exists";
        exit();
    }
}
