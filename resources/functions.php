<?php // ob_start();
//session_start();
//session_destroy();

// helper functions

$uploads = "uploads";

function last_id()
{
    global $connection;
    return mysqli_insert_id($connection);
}

function set_message($msg)
{

    if (!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location)
{
    header("Location: $location");
}


function query($sql)
{
    global $connection;

    return mysqli_query($connection, $sql);
}

function confirm($reqult)
{
    global $connection;

    if (!$reqult) {
        die("Query Failed" . mysqli_error($connection));
    }
}

function escape_string($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result)
{
    return mysqli_fetch_array($result);
}


//******************************************FrontEnd Function ***************************************/

// get products

function get_products()
{
    $query = query("SELECT * FROM products");
    confirm($query);
    while ($row = fetch_array($query)) {
        $product_image = display_image($row['product_image']);
        $products = <<<DELIMETER

        <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                           <a href="item.php?id={$row['product_id']}"><img  src="../resources/{$product_image}" alt=""> </a>
                            <div class="caption">
                                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            <a class="btn btn-primary" target="_blank" href="cart.php?add={$row['product_id']}">Add to cart</a>
                            </div>
                        </div>
                    </div>

DELIMETER;
        echo $products;
    }
}

// get categories

function get_categories()
{
    $query = query("SELECT * FROM categories");
    confirm($query);
    while ($row = fetch_array($query)) {
        $categories = <<<DELIMETER
<a href='category.php?id={$row['id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER;
        echo $categories;
    }
}


function get_products_cat_in_page()
{
    $query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
    confirm($query);
    while ($row = fetch_array($query)) {
        $product_image = display_image($row['product_image']);
        $products = <<<DELIMETER

       <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../public/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
        echo $products;
    }
}


function get_products_shop_in_page()
{
    $query = query("SELECT * FROM products");
    confirm($query);
    while ($row = fetch_array($query)) {
        $product_image = display_image($row['product_image']);
        $products = <<<DELIMETER

       <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../public/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
        echo $products;
    }
}

function login_user()
{
    if (isset($_POST['submit'])) {
        $username = escape_string($_POST['username']);
        $password = escape_string(($_POST['password']));

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);

        if (mysqli_num_rows($query) == 0) {
            set_message("Your Username Or Password are Wrong");
            redirect("login.php");
        } else {
            $_SESSION['username'] = $username;
            //  set_message("Welcome to Admin {$username}");
            redirect("admin");
        }
    }
}

function send_message()
{
    if (isset($_POST['submit'])) {
        $to = "someEmailaddress@gmail.com";
        $from_name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $headers = "From: {$from_name} {$email}";

        $result = mail($to, $subject, $message, $headers);

        if (!$result) {
            set_message("Sorry we could not send your message");
            redirect("contact.php");
        } else {
            set_message("Your message has been sent");
        }
    }
}



//****************************************** BackEnd Function *********************************/



//****************************** Admin Products ******************************************/

function display_image($picture)
{
    global $uploads;
    return $uploads . DS . $picture;
}

function show_product_category_title($product_category_id)
{
    $category = query("SELECT * FROM categories WHERE id = '{$product_category_id}'");
    confirm($category);
    while ($row = fetch_array($category)) {
        return $row['cat_title'];
    }
}



function get_products_in_admin()
{

    $query = query("SELECT * FROM products");
    confirm($query);
    while ($row = fetch_array($query)) {
        $category = show_product_category_title($row['product_category_id']);
        $product_image = display_image($row['product_image']);
        $products = <<<DELIMETER
       <tr>
            <td>{$row['product_id']}</td>
            <td> <a href="index.php?edit_product&id={$row['product_id']}"><img width="100" src="../../resources/$product_image" alt=""></a></td>
            <td>{$row['product_title']}<br></td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_product.php?id={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a></td>
        </tr>
      

DELIMETER;
        echo $products;
    }
}


//************************* Add Admin Product  */

function add_product()
{

    if (isset($_POST['publish'])) {
        // var_dump($_POST);
        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $product_des = escape_string($_POST['product_des']);
        $product_quantity = escape_string($_POST['product_quantity']);
        $product_image = ($_FILES['file']['name']);
        $image_tmp_location = ($_FILES['file']['tmp_name']);

        if (move_uploaded_file($image_tmp_location, upload_directory . DS . $product_image)) {
            echo "Upload successful!";
        } else {
            echo "Upload failed!";
            print_r(error_get_last());
        }

        $query = query("INSERT INTO products (product_title,product_category_id,product_price,product_description,product_des,product_quantity,product_image) 
        VALUES('{$product_title}','{$product_category_id}','{$product_price}','{$product_description}','{$product_des}','{$product_quantity}','{$product_image}')");
        $last_id = last_id();
        confirm($query);
        set_message("New product with id {$last_id} was added ");
        redirect('index.php?products');
    }
}

function show_categories_add_product_page()
{
    $query = query("SELECT * FROM categories");
    confirm($query);
    while ($row = fetch_array($query)) {
        $categories = <<<DELIMETER
 <option value="{$row['id']}">{$row['cat_title']}</option>      
DELIMETER;
        echo $categories;
    }
}

/* Product Update Code  */

function update_product()
{

    if (isset($_POST['update'])) {
        // var_dump($_POST);
        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $product_des = escape_string($_POST['product_des']);
        $product_quantity = escape_string($_POST['product_quantity']);
        $product_image = ($_FILES['file']['name']);
        $image_tmp_location = ($_FILES['file']['tmp_name']);

        if (empty($product_image)) {
            $get_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
            confirm($get_pic);

            while ($pic = fetch_array($get_pic)) {
                $product_image = $pic['product_image'];
            }
        }

        move_uploaded_file($image_tmp_location, upload_directory . DS . $product_image);

        $query = "UPDATE products SET ";
        $query .= "product_title         = '{$product_title}'       , ";
        $query .= "product_category_id   = '{$product_category_id}' , ";
        $query .= "product_price         = '{$product_price}'       , ";
        $query .= "product_description   = '{$product_description}' , ";
        $query .= "product_des           = '{$product_des}'         , ";
        $query .= "product_quantity      = '{$product_quantity}'    , ";
        $query .= "product_image         = '{$product_image}'        ";
        $query .= "WHERE product_id      =" . escape_string($_GET['id']);
        $send_update_query = query($query);
        confirm($send_update_query);
        set_message("Product has been updated");
        redirect('index.php?products');
    }
}


/*******************Categories In Admin*****************/

function show_category_in_admin()
{
    $query = "SELECT * FROM categories";
    $category_query = query($query);
    confirm($category_query);

    while ($row = fetch_array($category_query)) {
        $id = $row['id'];
        $cat_title = $row['cat_title'];
        $category = <<<DELIMETER
        <tr>
                <td>{$id}</td>
                <td>{$cat_title}</td>
                <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_category.php?id={$row['id']}"><span class='glyphicon glyphicon-remove'></span></a></td>
            </tr>

DELIMETER;
        echo $category;
    }
}

function add_category()
{
    if (isset($_POST['add_category'])) {
        $cat_title = escape_string($_POST['cat_title']);
        if (empty($cat_title) || $cat_title == "") {
            echo "<p class='bg-danger'> This Can Not Be Empty </p>";
        } else {
            $query = query("INSERT INTO categories (cat_title) VALUES('{$cat_title}')");
            confirm($query);
            set_message('Category Created');
        }
    }
}

/*************Users****************/

function show_users()
{
    $query = "SELECT * FROM users";
    $user_query = query($query);
    confirm($user_query);

    while ($row = fetch_array($user_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];
        $user = <<<DELIMETER
        <tr>
                <td>{$user_id}</td>
                <td>{$username}</td>
                <td>{$email}</td>
                <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_users.php?id={$row['user_id']}"><span class='glyphicon glyphicon-remove'></span></a></td>
            </tr>

DELIMETER;
        echo $user;
    }
}

function add_user()
{

    if (isset($_POST['add_user'])) {
        // var_dump($_POST);
        $username = escape_string($_POST['username']);
        $email = escape_string($_POST['email']);
        $password = escape_string($_POST['password']);
        $query = query("INSERT INTO users (username,email,password)VALUES('{$username}','{$email}','{$password}')");
        confirm($query);
        set_message("New User added ");
        redirect('index.php?users');
    }
}

/**********************Slides ********************/


function get_slides()
{
    $query = query("SELECT * FROM slides");
    confirm($query);
    while ($row = fetch_array($query)) {
        $slides = <<<DELIMETER
         <div class="item">
         <img class="slide-image" src="../resources/uploads/{$row['slide_image']}" alt="">
        </div>
 DELIMETER;

        echo $slides;
    }
}

function get_active_slide()
{
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);
    while ($row = fetch_array($query)) {
        $slides = <<<DELIMETER
         <div class="item active">
         <img  class="slide_image" src="../resources/uploads/{$row['slide_image']}" alt="">
        </div>
 DELIMETER;

        echo $slides;
    }
}


function add_slides()
{
    if (isset($_POST['add_slide'])) {
        $slide_title = escape_string($_POST['slide_title']);
        $slide_image = ($_FILES['file']['name']);
        $image_tmp_location = ($_FILES['file']['tmp_name']);

        if (empty($slide_title) || empty($slide_image)) {
            echo "<p class='bg-danger'>This field cannot be empty</p>";
        }

        else{
              move_uploaded_file($image_tmp_location, upload_directory . DS . $slide_image);
              $query = query("INSERT INTO slides (slide_title,Slide_image)VALUES('{$slide_title}','{$slide_image}')");
        confirm($query);
        set_message("Slide added ");
        redirect('index.php?slides');
        }
    }
}
