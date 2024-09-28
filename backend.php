<?php
//Server-side Script
//Get data from Post Request
if(isset($_POST["checking_value"])){
$Customer_Name=$_POST['Cname'];
$Mobile=$_POST['mobile'];

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
    echo "Connection was Successful";
}

//Insert data to database 'store'
$query = "INSERT INTO `customer` (`Name`,`Mobile`) VALUES('$Customer_Name','$Mobile')"; 
$result = mysqli_query($conn,$query);
if (!$result) {
    die("Error inserting customer: " . mysqli_error($conn));
}

$customer_id = $conn->insert_id;

// Insert invoice
$Invoice_date=$_POST['Invoice_date'];
$total_amount = 0; 
$query = "INSERT INTO `invoices` (`Customer_id`,`Invoice_date`,`total_amount`) VALUES('$customer_id','$Invoice_date','$total_amount')"; 
$result = mysqli_query($conn,$query);
if (!$result) {
    die("Error inserting customer: " . mysqli_error($conn));
}
$invoice_id = $conn->insert_id;
// Insert invoice items
$groceries = $_POST['grocery'];
$quantities=$_POST['quantity'];
$rates =$_POST['rate'];
$Total = implode(" ",$_POST['total']);
foreach ($groceries as $index => $grocery){
    $quantity = $quantities[$index];
    $rate = $rates[$index];
    $total = $quantity * $rate;
    
    $item_query = "INSERT INTO `invoice_items` (`Invoice_id`,`Grocery`,`Quantity`,`Rate`,`Total`) VALUES('$invoice_id','$grocery','$quantity','$rate','$total')"; 
    $item_result = mysqli_query($conn,$item_query);

    $total_amount += $total; // Calculate total amount
    }
    // Update the invoice total amount
    $update_query="UPDATE `invoices` SET total_amount = $total_amount WHERE invoice_id = $invoice_id";
    $update_result = mysqli_query($conn,$update_query);

// Prepare the response data
$invoiceData = array(
    'Customer_name' => $Customer_Name,
    'Invoice_date'=> $Invoice_date,
    'Mobile'=> $Mobile,
    'Grocery'=> $groceries,
    'Quantity'=> $quantities,
    'Rate'=> $rates,
    'Total'=> $Total,
);

    echo json_encode(array('data'=>$invoiceData));
//clossing the connection
$conn->close();
}
