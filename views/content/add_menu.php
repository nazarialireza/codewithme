@extend('app_front')
<div class="container">
            <div class="row justify-content-center align-items-center my-5">
                <div class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form class="form" action="<?php echo APP_PATH ?>/menus/store" method="post">
                            <h3 class="text-center ">Add Menu</h3>
                            <div class="form-group">
                                <label for="menu_title" class="">Title:</label><br>
                                <input type="text" name="menu_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description" class="">Description:</label><br>
                                <input type="text" name="description" class="form-control">
                            </div>
                            <div class="form-group">
                                <br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

