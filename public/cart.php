<?php require_once("../resources/config.php");?>

<?php

if(isset($_GET['id'])){
    
    $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['id']). "");
    confirm($query);

    while($row = fetch_array($query)){
        if($row['product_quantity'] != $_SESSION['product_' . $_GET['id']]){
            $_SESSION['product_'. $_GET['id']]+=1;
             redirect('checkout.php');
        }
        else{
            set_message("We only have  " . $row['product_quantity'] . " " . $row['product_title'] . " available");
            redirect('checkout.php');
        }
    }
}


?>