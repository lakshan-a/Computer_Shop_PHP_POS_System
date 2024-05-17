<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Prient Order
                <a href="orders.php" class="btn btn-danger btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <div id="myBillingArea">
                <?php
                    if(isset($_GET['track'])){
                        $trackingNo = validate($_GET['track']);
                        if($trackingNo == ''){
                            ?>
                            <div class="text-center py-5">
                                <h5>Plese provide Tracking Number</h5>
                                <div>
                                <a href="orders.php" class="btn btn-danger mt-4 w-25">Go back to Orders</a>
                                </div>
                            </div>
                            <?php
                        }

                        $orderQuery = "SELECT o.*, c.* FROM orders o, customers c 
                            WHERE c.id=o.customer_id AND tracking_no='$trackingNo' LIMIT 1";
                        $orderQueryRes = mysqli_query($conn, $orderQuery);

                        if(!$orderQueryRes){
                            echo "<h5>Someting Went Wrong</h5>";
                            return false;
                        }

                        if(mysqli_num_rows($orderQueryRes) > 0){
                            $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                            // print_r($orderDataRow);
                            ?>
                            <table style="width: 100%; margin-bottom:20px;" >
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;" colspan="2">
                                            <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding: 0;">Company XYZ</h4>
                                            <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">#555,1st street,3rd cross</p>
                                            <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">company xyz pvt lty.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">Customer Detail</h5>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Name: <?= $orderDataRow['name'] ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Phone No: <?= $orderDataRow['phone'] ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer Email Id: <?= $orderDataRow['email'] ?> </p>
                                        </td>
                                        <td align="end">
                                            <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">Invoice Detail</h5>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice No: <?= $orderDataRow['invoice_no']; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice Date: <?= date('d M Y'); ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Address:1st main road</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                        }else{
                            echo "<h5>No data Found</h5>";
                            return false;
                        }

                        $orderItemQuary = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* 
                            FROM orders o, order_items oi, products p 
                            WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no='$trackingNo'";

                        $orderItemQuaryRes = mysqli_query($conn, $orderItemQuary);
                        if($orderItemQuaryRes){
                            if(mysqli_num_rows($orderItemQuaryRes) > 0){
                                ?>
                                <div class="table-responsive mb-3">
                                    <table style="width:100%" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <th align ="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                                <th align ="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                                <th align ="start" style="border-bottom: 1px solid #ccc;" width="10%">Price</th>
                                                <th align ="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                                <th align ="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                foreach($orderItemQuaryRes as $key => $row) : 
                                                                                        ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderItemPrice'],0) ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                    <?= number_format($row['orderItemPrice'] *$row['orderItemQuantity'],0) ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight:bold;">Grand Total:</td>
                                                <td colspan="1" style="font-weight:bold;"><?= number_format($row['total_amount'],0); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Payment Mode: <?=$row['payment_mode']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php

                            }else{
                                echo "<h5>No data Found</h5>";
                                return false;
                            }

                        }else{
                            echo "<h5>Someting Went Wrong!</h5>";
                            return false;
                        }

                    }else{
                        ?>
                        <div class="text-center py-5">
                            <h5>No Tracking Number Paramete Found</h5>
                            <div>
                            <a href="orders.php" class="btn btn-danger mt-4 w-25">Go back to Orders</a>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Print</button>
                <button class="btn btn-warning px-4 mx-1" onclick="downloadPDF('<?= $orderDataRow['invoice_no']; ?>')">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>