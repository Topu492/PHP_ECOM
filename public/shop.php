<?php
require_once("../resources/config.php");?>
<?php  include(Template_frontend . DS . "header.php") ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header>
          <h1>Shop</h1> 
        </header>

        <hr>

        <!-- Page Features -->
        <div class="row text-center">
           
        <?php  get_products_shop_in_page()  ?>    
        
        </div>
        <!-- /.row -->


    </div>
    <!-- /.container -->

<?php  include(Template_frontend . DS . "footer.php") ?>