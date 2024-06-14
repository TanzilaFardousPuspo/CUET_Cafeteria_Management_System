<?php
session_start(); // Ensure session is started
?>
<?php
require_once '../config.php';
include '../inc/dashHeader.php'; 
$bill_id = $_GET['bill_id'];
$staff_id = $_GET['staff_id'];
$member_id = $_GET['member_id'];
$reservation_id = $_GET['reservation_id'];
?>
<style>
        /* Add custom CSS for background */
        body {
            background-image: url('b.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* color: #ffffff; Set text color to white for better contrast */
        }
        .table thead th {
            background-color: #008000; /* Change this color to your desired background color */
            color: white; /* Change this color to your desired text color */
        }
</style>
<body>
    <div class="container" style="margin-top: 8rem; margin-left: 4rem;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bill (Credit Card Payment)</h3>
                    </div>
                    <div class="card-body">
                        <h5>Bill ID: <?php echo $bill_id; ?></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                <?php
                // Query to fetch cart items for the given bill_id
                $cart_query = "SELECT bi.*, m.item_name, m.item_price FROM bill_items bi
                            JOIN Menu m ON bi.item_id = m.item_id
                            WHERE bi.bill_id = '$bill_id'";
                $cart_result = mysqli_query($link, $cart_query);
                $cart_total = 0;//cart total
                $tax = 0.0; // 0% tax rate

                if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                        $item_id = $cart_row['item_id'];
                        $item_name = $cart_row['item_name'];
                        $item_price = $cart_row['item_price'];
                        $quantity = $cart_row['quantity'];
                        $total = $item_price * $quantity;
                        $bill_item_id = $cart_row['bill_item_id'];
                        $cart_total += $total;
                        echo '<tr>';
                        echo '<td>' . $item_id . '</td>';
                        echo '<td>' . $item_name . '</td>';
                        echo '<td>BDT ' . number_format($item_price,2) . '</td>';
                        echo '<td>' . $quantity . '</td>';
                        echo '<td>BDT ' . number_format($total,2) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No Items in Cart.</td></tr>';
                }
                ?>
            </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="text-right">
                            <?php 
                            // echo "<strong>Total:</strong> BDT " . number_format($cart_total, 2) . "<br>";
                            // echo "<strong>Tax (10%):</strong> BDT " . number_format($cart_total * $tax, 2) . "<br>";
                            $GRANDTOTAL = $tax * $cart_total + $cart_total;
                            echo "<strong>Total Payment:</strong> BDT " . number_format($GRANDTOTAL, 2);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="card-payment" class="col-md-6 order-md-2" style="margin-top: 7px; margin-right: 25rem;max-width: 40rem;">
        <div class="container-fluid pt-5 pl-3 pr-3">
            <h1>Fill in your card details</h1>
            <form action="creditCard.php?bill_id=<?php echo $bill_id; ?>" method="post">
                <div class="form-group" style="margin-bottom: 20px">
                    <label for="cardNameField" style="color: white;font_size: 35px">Account Holder Name</label>
                    <input type="text" id="cardNameField" name="cardName" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px">
                    <label for="cardField" style="color: white;font_size: 35px">Card Number</label>
                    <input type="text" id="cardField" name="cardNumber" maxlength="19" minlength="15" class="form-control" placeholder="1234567890123456 (15 to 19 digits)" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px">
                    <label for="expiryDate" style="color: white;font_size: 35px">Expiry Date</label>
                    <input type="text" id="expiryDate" name="expiryDate" pattern="(0[1-9]|1[0-2])\/[0-9]{4}" maxlength="7" placeholder="MM/YYYY" class="form-control" required>
                </div>
                <div class="form-group" style="margin-bottom: 20px">
                    <label for="securityCode" style="color: white;font_size: 35px">Security Code</label>
                    <input type="text" id="securityCode" name="securityCode" maxlength="3" class="form-control" placeholder="Enter a 3-digit Security Code" pattern="[0-9]{3}" required>
                    <!-- <small class="form-text text-muted" style="color: white">Please enter a 3-digit security code.</small> -->
                </div>

                <!-- Add hidden input fields for bill_id, staff_id, member_id, and reservation_id -->
                <input type="hidden" name="bill_id" value="<?php echo $bill_id; ?>">
                <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
                <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
                <input type="hidden" name="GRANDTOTAL" value="<?php echo $tax * $cart_total + $cart_total; ?>">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="privacyCheckbox" required>
                    <label class="form-check-label" for="privacyCheckbox" style="color: white;margin-bottom: 20px">I agree to the Private Data Terms and Conditions</label><br>
                    <!-- <small id="privacyHelp" class="form-text text-muted" style="color: white">By checking the box you understand we will save your credit card information.</small> -->
                </div>
                <button type="submit" id="cardSubmit" class="btn btn-dark" style="background-color: #008000;font_size: 20px">Pay</button>
            </form>
        </div>
    </div>
</body>

<?php include '../inc/dashFooter.php'; ?>

         