<?php
require_once("../resources/config.php");?>
<?php  include(Template_frontend . DS . "header.php") ?>
 <!-- Page Content -->
    <div class="container">

    
        <div class="row">

        <?php  include(Template_frontend . DS . "side_nav.php") ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <!-- carousel  !-->  
                    <?php  include(Template_frontend . DS . "slider.php") ?> 

                </div>

                <div class="row">
                   
                    <?php  get_products()  ?>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <?php include(Template_frontend . DS . "footer.php") ?>
