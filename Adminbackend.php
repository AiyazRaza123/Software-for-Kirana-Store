<?php
//Server-side Script
//Get data from Post Request
if(isset($_POST["checking_value"])){
$Grocery = $_POST['grocery'];
$Rate =$_POST['rate'];


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
    echo "Connection was Successful<br>";
}

//Insert data to database 'store'
$query = "INSERT INTO `admin_data` (`Grocery`,`Rate`) VALUES('$Grocery','$Rate')";
$result = mysqli_query($conn,$query);


//clossing the connection
$conn->close();
}
