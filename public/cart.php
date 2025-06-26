<?php //require_once("../resources/config.php");
require_once(__DIR__ . '/../resources/config.php');
?>

<?php

if (isset($_GET['add'])) {

    $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) . " ");
    confirm($query);

    while ($row = fetch_array($query)) {
        if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
            $_SESSION['product_' . $_GET['add']] += 1;
            redirect('checkout.php');
        } else {
            set_message("We only have  " . $row['product_quantity'] . " " . $row['product_title'] . " available");
            redirect('checkout.php');
        }
    }
}

if (isset($_GET['remove'])) {
    $_SESSION['product_' . $_GET['remove']]--;
    if ($_SESSION['product_' . $_GET['remove']] < 1) {
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("checkout.php");
    } else {
        redirect("checkout.php");
    }
}

if (isset($_GET['delete'])) {
    $_SESSION['product_' . $_GET['delete']] = 0;
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    redirect("checkout.php");
}

function cart()
{
    $total = 0;
    $item_quantity = 0;
    //$item_name = 1;
    //$item_number = 1;
    //$amount = 1;
    //$quantity = 1;
    foreach ($_SESSION as $name => $value) {

        if ($value > 0) {
            if (substr($name, 0, 8) == "product_") {

                $id = substr($name, 8);
                $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                confirm($query);

                while ($row = fetch_array($query)) {
                    $sub = $row['product_price'] * $value;
                    $item_quantity += $value;
                    $product_image = display_image($row['product_image']);

                    $product = <<<DELIMETER

 <tr>
                <td>{$row['product_title']}<br>
                <img width="100" src="../resources/$product_image">
                </td>
                <td>&#36;{$row['product_price']}</td>
                <td>{$value}</td>
                <td>&#36;{$sub}</td>
                <td>
                <a class='btn btn-warning' href="cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a> 
                <a class='btn btn-success' href="cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a>
                <a class='btn btn-danger' href="cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a>
                </td>
              
            </tr>

DELIMETER;
                    echo $product;

                    //$item_name++; 
                    //$item_number++;
                    //$amount++;
                    //$quantity++;
                }
                $_SESSION['item_total'] = $total += $sub;
                $_SESSION['item_quantity'] = $item_quantity;
            }
        }
    }
}



function report()
{

    if (isset($_GET['tx'])) {
        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];
        $query = query("INSERT INTO ORDERS (order_amount,order_transaction,order_status,order_currency) VALUES('{$amount}','{$currency}','{$transaction}','{$status}')");
        confirm($query);
        $last_id = last_id();

        $total = 0;
        $item_quantity = 0;
        foreach ($_SESSION as $name => $value) {

            if ($value > 0) {
                if (substr($name, 0, 8) == "product_") {

                    $id = substr($name, 8);
                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                    confirm($query);

                    while ($row = fetch_array($query)) {
                        $product_price = $row['product_price'];
                        $product_title = $row['product_title'];
                        $sub = $row['product_price'] * $value;
                        $item_quantity += $value;
                        $insert_report = query("INSERT INTO REPORTS (product_id,order_id,product_title,product_price,product_quantity) VALUES('{$id}','{$last_id}','{$product_title}','{$product_price}','{$value}')");
                        confirm($insert_report);
                    }
                    $total += $sub;
                    $item_quantity;
                }
            }
        }
    }
    // session_destroy();
    else {
        redirect('index.php');
    }
}




?>



