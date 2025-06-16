<?php require_once("../resources/config.php"); ?>
<?php  include(Template_frontend . DS . "header.php") ?>


<?php
if(isset($_GET['tx'])){
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];

    $query = query("INSERT INTO ORDERS (order_amount,order_transaction,order_status,order_currency) VALUES('{$amount}','{$currency}','{$transaction}','{$status}')");
    confirm($query);

   report();

   // session_destroy();
}



?>