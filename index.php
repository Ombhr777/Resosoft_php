<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=stylesheet href="style.css">
    <title>Payment Details</title>
</head>
<body>
    <h2>Enter Payment Details</h2>

    <?php
    // Function to calculate Total Payable Amount
    function calculateTotalAmount($paymentAmount, $includeGST) {
        if ($includeGST) {
            // If GST is included, calculate total with 18% GST
            return $paymentAmount + (0.18 * $paymentAmount);
        } else {
            // If GST is not included, total is the same as payment amount
            return $paymentAmount;
        }
    }

    $servername = "localhost";
    $username = "root";
    $password="";
    $database = "reso";
    
    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn){
        die("Sorry we failed to connect: ". mysqli_connect_error());
    }
    else{
        echo"Connection was successfull";
    }
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input
        $name = $_POST["name"];
        $paymentAmount = $_POST["paymentAmount"];
        $includeGST = isset($_POST["includeGST"]);

        // Calculate Total Payable Amount
        $totalPayableAmount = calculateTotalAmount($paymentAmount, $includeGST);

        $query = "INSERT INTO behra VALUES('$name','$paymentAmount','$totalPayableAmount')";
        mysqli_query($conn, $query);

        // Display the results
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Payment Amount:</strong> $paymentAmount</p>";
        echo "<p><strong>Total Payable Amount:</strong> $totalPayableAmount</p>";
        echo"<script> alert('Data Entered Successfully');</script>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="paymentAmount">Payment Amount:</label>
        <input type="number" name="paymentAmount" required>

        <label>Include GST:</label>
        <input type="radio" name="includeGST" value="1">Yes<br> 
        <input type="radio" name="includeGST" value="0" checked> No<br><br><br>

        <input type="submit" value="Calculate Total Payable Amount">
    </form>
    
</body>
</html>
