<?php

//Connecting to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "store";

//Creating a Connection
$conn = mysqli_connect($servername,$username,$password,$database);
//Die if Connection was not Successful
if(!$conn){
    die("Sorry we failed to connect: " .mysqli_connect_error());
}
else{
    //echo "Connection was Successful<br>";
}

if(isset($_POST['pass']) && $_POST['pass']=="grocery"){
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM admin_data";
    $query = mysqli_query($conn,$sql);
    $str="";
    while($row = mysqli_fetch_assoc($query)){
        $str.= "<option value={$row['Grocery']}>{$row['Grocery']}</option>";
    }
    echo $str;
 }
 else if(isset($_POST['value']) && $_POST['value'] == "Rate" && isset($_POST['grocery_id'])){
    $grocery_id = mysqli_real_escape_string($conn, $_POST['grocery_id']); // Sanitize input
    $sql = "SELECT * FROM admin_data WHERE Grocery = '{$grocery_id}'";

    $query = mysqli_query($conn,$sql);
    
    $str="";
    while($row = mysqli_fetch_assoc($query)){
        $str.= "<option value={$row['Rate']}>{$row['Rate']}</option>";
    }
    echo $str;
}