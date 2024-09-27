<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Billing System for retail store</title>
</head>

<body>
    <div class="title">
        <div class="container">Customer Billing System</div>
    </div>
    <form id="invoiceForm" action="invoice.php" method="post">
        <div class="form">
            <div class="row">
                <div class="column left">
                    <label for="Customer" class="form-label">Customer Name:</label>
                    <input type="text" class="form-control" id="Cname" name="Cname[]" value=""
                        placeholder="Customer Name" required>
                </div>
                <div class="column middle">
                    <label for="Invoice_date" class="form-label">Invoice Date:</label>
                    <input type="datetime-local" class="form-control" id="Invoice_date" name="Invoice_date[]" value=""
                        placeholder="Invoice_date" required>
                </div>
                <div class="column right">
                    <label for="Mobile" class="form-label">Mobile:</label>
                    <input type="number" class="form-control" id="mobile" value="" name="mobile[]" placeholder="Mobile"
                        required>
                </div>
            </div>
            <div class="itemContainer">
                <div class="row item">
                    <div class="column left">
                        <label for="Grocery" class="form-label">Grocery:</label>
                        <select type="text" class="form-control grocery" id="grocery" value="" name="grocery[]"
                            placeholder="Grocery" required>
                            <option value="">Select Items</option>
                        </select>
                    </div>
                    <div class="column middle">
                        <label for="Quantity" class="form-label">Quantity:</label>
                        <input type="text" class="form-control quantity" id="quantity" value="" name="quantity[]"
                            placeholder="Quantity" required>
                    </div>
                    <div class="column right">
                        <label for="Rate" class="form-label">Rate:</label>
                        <select type="Number" class="form-control rate" id="rate" value="" name="rate[]"
                            placeholder="Rate" required>
                            <option value="">Select Items</option>
                        </select>
                    </div>
                    <div class="column right">
                        <label for="Total" class="form-label">Total:</label>
                        <input type="Number" class="form-control total" id="total" value="" name="total[]" placeholder="Total"
                            required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column middle">
                    <button type="submit" id="Additem">ADD ITEMS</button>
                </div>
                <div class="column right">
                    <button type="submit" value="Generate Invoice">SUBMIT</button>
                </div>
            </div>
        </div>
    </form>
    <script src="javaScript.js"></script>
    <script>
    //Add items
    $(document).ready(function() {
        loadData('grocery'); //Function initialized
        passData('Rate');
        $('#Additem').on('click', function() {
            $('.itemContainer').append('<div class="row item"><div class="column left">\
                    <label for="Grocery" class="form-label">Grocery:</label>\
                    <select class="form-control grocery" id="grocery" value="Select Item" name="grocery[]" placeholder="Grocery" required><option value="">Select Items</option></select></div>\
                <div class="column middle">\
                    <label for="Quantity" class="form-label">Quantity:</label>\
                    <input type="number" class="form-control quantity" id="quantity" value="" name="quantity[]"  placeholder="Quantity" required>\
                </div>\
                <div class="column right">\
                    <label for="Rate" class="form-label">Rate:</label>\
                    <select  class="form-control rate" id="rate" value="" name="rate[]"  placeholder="Rate" required><option value="">Select Items</option></select></div>\
                <div class="column right">\
                    <label for="total" class="form-label">Total:</label>\
                    <input type="Number" class="form-control total" id="total" value=""name="total[]" placeholder="Total" required>\
                </div>\
                <div><button type="button" class="removeItem">Remove</button></div>\
                </div>');
            loadData('grocery'); //Function initialized
            //passData('Rate');
        });
        $(document).on('click', '.removeItem', function() {
            $(this).closest('.row').remove();
        });

        //Auto Calculate Code
        $(document).ready(function() {
            $(document).on('change', '.rate, .quantity', function() {
                var row = $(this).closest('.item');
                var y = Number(row.find('.rate').val()) || 0;
                var x = Number(row.find('.quantity').val()) || 0;
                var total = x * y;
                row.find('.total').val(total);
            });
        });

        //Dropdown button
        function passData(value) {
            $(document).on("change", ".grocery", function() { //On Change of grocery items
                var grocery_id = $(this).val(); //id is stored
                if (grocery_id) { //If grocery id exist.
                    $.ajax({ //ajax start
                        url: "Dependent.php",
                        type: "POST",
                        data: {
                            'value': value,
                            'grocery_id': grocery_id
                        }, //Sending request as grocery_id
                        success: function(data) { //Retrieving data
                            $(this).closest('.item').find('.rate').html(
                            data); //Show the data to Rate via Class
                        }.bind(this),
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + status + " " + error);
                        }
                    });
                }

            });
        }

        function loadData(pass) { //Function Call
            $.ajax({
                url: "Dependent.php",
                type: "POST",
                data: {
                    'pass': pass
                }, //Sending Request as pass==grocery
                success: function(data) {
                    $(".grocery").html(data); //Retrieving and appending data to grocery select box
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " " + error);
                }
            });
        }

        //Form Submission
        $('#invoiceForm').on('submit', function(e) { //Prevent the form from submitting
            //e.preventDefault();
            //Get Values From the form
            var Customer_name = $('#Cname').val();
            var Invoice_date = $('#Invoice_date').val();
            var mobile = $('#mobile').val();

            // Collect arrays for groceries, quantities, rates, and totals
            var grocery = $('select[name="grocery[]"]').map(function() {
                return $(this).val();
            }).get();

            var quantity = $('input[name="quantity[]"]').map(function() {
                return $(this).val();
            }).get();

            var rate = $('select[name="rate[]"]').map(function() {
                return $(this).val();
            }).get();

            var total = $('input[name="total[]"]').map(function() {
                return $(this).val();
            }).get();

            // Start of ajax request to send request for submission of HTML data
            $.ajax({
                url: 'backend.php',
                type: 'POST',
                data: {
                    "checking_value": true,
                    "Cname": Customer_name,
                    "Invoice_date": Invoice_date,
                    "mobile": mobile,
                    "grocery": grocery,
                    "quantity": quantity,
                    "rate": rate,
                    "total": total,
                },
                success: function(response) {
                    window.location.href = "invoice.php" // Replace with your invoice form URL
                    // Handle successful submission
                    if (response && response['data']){
                        // Redirect to invoice form or display a success message
                       /*  $.ajax({
                            url:'invoice.php',
                            type:'GET',
                            data:{"response['data']":response['data']},
                            success:function(response){
                                alert("Invoice Created Successfully");
                            }
                        }); */
                        //$('.itemContainer').empty(); // Clear the item container
                    } else {
                        // Handle errors
                        alert(response);
                    }
                }
            });
        });

    });
    </script>
</body>

</html>