<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
            Add user
        </h1>
    </div>
    <?php add_user(); ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <a id="user_id" class="btn btn-danger" href="">Delete</a>
                <input name="add_user" type="submit" class="btn btn-primary" value="Add User">
            </div>

        </div><!--Main Content-->


    </form>