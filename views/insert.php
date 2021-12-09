<?php
var_dump('okay');
$result = false;
if(isset($_POST)){
  $app = new Store();
  if(isset($_POST['username']) && $_POST['username']){
    $result = $app->setUser($_POST);
  }
  if(isset($_POST['menu_title']) && $_POST['menu_title']){
    $result = $app->storeMenu($_POST);
  }
}

if($result){
  header("Location: ".APP_PATH."/home");
} else {
  header("Location: ".APP_PATH."/registration");
}