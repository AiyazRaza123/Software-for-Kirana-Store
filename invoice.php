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

$sql = "SELECT * FROM details";
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($query)){
    $customerName =$row['Customer Name'];
    $invoiceDate = $row['Invoice Date'];
    $mobile = $row['Mobile'];
    $groceries = explode(',', $row['Grocery']);
    $quantities = explode(',', $row['Quantity']);
    $rates = explode(',', $row['Rate']);

    // Prepare the invoice items
    $items = [];
    for ($i = 0; $i < count($groceries); $i++){
        // Convert the quantities and rates to numeric values
        $quantity = intval($quantities[$i]); 
        $rate = floatval($rates[$i]);        
        $total = $quantity * $rate;
        $items[] = [
            'grocery' => $groceries[$i],
            'quantity' => $quantities[$i],
            'rate' => $rates[$i],
            'total' => $total
        ];
    }
    
    // Calculate the overall total
    $overallTotal = array_sum(array_column($items, 'total'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Invoice</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Invoice</h2>
        <p><strong>Customer Name:</strong> <?php echo $customerName; ?></p>
        <p><strong>Invoice Date:</strong> <?php echo $invoiceDate; ?></p>
        <p><strong>Mobile:</strong> <?php echo $mobile; ?></p>
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Grocery Item</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['grocery']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($item['rate']); ?></td>
                        <td><?php echo htmlspecialchars($item['total']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h4 class="text-end">Overall Total: ₹<?php echo $overallTotal; ?></h4>
    </div>
</body>
</html>

<?php
 } 
?>
