@extend('app_front')
<div class="container">
    <div class="row justify-content-center align-items-center my-5">
        <div class="col-md-6">
            <div id="login-box" class="col-md-12">
                <form class="form" action="../../database/Insert.php" method="post">
                    <h3 class="text-center ">Login</h3>
                    <div class="form-group">
                        <label for="username" class="">Username:</label><br>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password" class="">Password:</label><br>
                        <input type="text" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remember-me" class="">
                            <span>
                                <input name="remember-me" type="checkbox">
                            </span>
                            <span>Remember me</span> 
                        </label>
                        <br>
                        <input type="submit" name="submit" class="d-flex justify-content-start btn btn-info btn-md" value="submit">
                        <a href="./registration" class="d-flex justify-content-end">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

