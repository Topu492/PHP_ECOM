<?php  require_once("../../resources/config.php")    ?>
<?php include(Template_backend . DS . "header.php") ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard 
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <?php
               // echo $_SERVER['REQUEST_URI'];

                    if($_SERVER['REQUEST_URI'] == "/PHP_ECOM/public/admin" || $_SERVER['REQUEST_URI'] == "/PHP_ECOM/public/admin/index.php"){
                        include((Template_backend . DS . "/admin_content.php"));
                    }

                   /* if ($_SERVER['REQUEST_URI'] == "/PHP_ECOM/public/admin" || $_SERVER['REQUEST_URI'] == "/PHP_ECOM/public/admin/index.php") {
                    include(Template_backend . DS . "admin_content.php"); 
                      }   */

                    if(isset($_GET['orders'])){
                         include((Template_backend . DS . "/orders.php"));
                    }

                      if(isset($_GET['categories'])){
                         include((Template_backend . DS . "/categories.php"));
                    }

                      if(isset($_GET['products'])){
                         include((Template_backend . DS . "/products.php"));
                    }
                    if(isset($_GET['add_products'])){
                         include((Template_backend . DS . "/add_products.php"));
                    }


                   ?>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include(Template_backend . DS . "footer.php") ?>