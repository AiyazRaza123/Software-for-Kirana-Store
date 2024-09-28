<?php

// Assuming you have processed the form data and have variables for invoice details

$customerName = implode(" ",$_POST['Cname']);
$invoiceDate = $_POST['Invoice_date'];
$mobile = $_POST['mobile'];

// Assuming you have an array for each item (grocery, quantity, rate, total)
$groceries = $_POST['grocery'];
$quantities = $_POST['quantity'];
$rates = $_POST['rate'];
//$totals = $_POST['total'];
$Tax=0;
    for ($i = 0; $i < count($groceries); $i++){
        // Convert the quantities and rates to numeric values
        $quantity = intval($quantities[$i]); 
        $rate = floatval($rates[$i]);        
        $total = $quantity * $rate;
        $TotalSum = $total + (18 * $total)/100;

        $Tax =(18 * $total)/100;
        $items[] = [
            'grocery' => $groceries[$i],
            'quantity' => $quantities[$i],
            'rate' => $rates[$i],
            'total'=> $total,
            'totalSum' => $TotalSum,
            'tax'=> $Tax,
        ];
    }
    
    // Calculate the overall total
    $Totalbill = array_sum(array_column($items, 'totalSum'));
    // Calculate Tax
    $Totaltax = array_sum(array_column($items, 'tax'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Invoice</title>
    <style>
        #Container{
        display: flex;
        align-items: center;
        }
        #printButton {
            margin: 20px 0;
        }
        @media print {
    body {
        margin: 0;
        padding: 0;
    }
    #printButton {
        display: none; /* Hide the print button when printing */
    }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Invoice</h2>
        <p><strong>Customer Name:</strong> <?php echo $customerName; ?></p>
        <p><strong>Invoice Date:</strong> <?php echo implode(" ",$invoiceDate); ?></p>
        <p><strong>Mobile:</strong> <?php echo implode(" ",$mobile); ?></p>
        
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
        <h4 class="text-end">Tax(CGST+SGST@18%) : ₹<?php echo $Totaltax ;?></h4>
        <h4 class="text-end">Totalbill: ₹<?php echo $Totalbill; ?></h4>
        <div id="Container">
        <button id="printButton">Print Invoice</button>
        </div>
    </div>
    
    <script>
    document.getElementById('printButton').onclick = function() {
        window.print();
    };
</script>
</body>
</html>

