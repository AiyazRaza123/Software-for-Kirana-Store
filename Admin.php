<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Admin Pannel</title>
</head>

<body>
    <form class="form1" action="" method="post">
            <div class="row item">
                <div class="column left">
                    <label for="Grocery" class="form-label">Grocery:</label>
                    <input type="text" class="form-control grocery" id="grocery" value="" name="grocery[]"
                        placeholder="Grocery" required>
                    <div class="error" id="groceryError"></div>
                </div>
                <div class="column right">
                    <label for="Rate" class="form-label">Rate:</label>
                    <input type="Number" class="form-control rate" id="rate" value="" name="rate[]" placeholder="Rate"
                        required>
                    <div class="error" id="rateError"></div>
                </div>
            </div>
        </div>
        <div class="row"></div>
        <div class="column right">
            <button type="submit" value="">SUBMIT</button>
        </div>
    </form>
    <script src="javaScript.js"></script>
    <script>

    //Form Submission
    $(document).ready(function(){
        $('.form1').on('submit', function(e) {  // Prevent the form from submitting
            e.preventDefault();


            //Get Values From the form
            var grocery = $('.grocery').val();
            var rate = $('.rate').val();


        //Start of ajax request to send request for submission of HTML data
        $.ajax({
            url: 'Adminbackend.php',
            type: 'POST',
            data: {
                "checking_value": true,
                "grocery": grocery,
                "rate": rate,
            },
            success: function(response) {
                console.log(response);
                $('.form1')[0].reset();
            }
        });
        });
    });
    </script>
</body>
</html>