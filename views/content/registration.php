@extend('app_front')
<div class="container">
    <div class="row justify-content-center align-items-center my-5">
        <div class="col-md-6">
            <div id="login-box" class="col-md-12">
                <form class="form" action="<?php echo APP_PATH ?>/users/add_new" method="post">
                    <h3 class="text-center ">Registration</h3>
                    <div class="form-group">
                        <label for="username" class="">Username:</label><br>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email" class="">Email:</label><br>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password" class="">Password:</label><br>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">

                        <br>
                        <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                        <a href="./login" class="d-flex justify-content-end ">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

