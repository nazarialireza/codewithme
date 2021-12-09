<?php

class Store {
  public $conn;
  public $date;
  public $result = false;
  public function __construct(){
    $this->conn = new Database();
    $this->date = date('Y-m-d H:m:s');
  }

  public function setUser($request){
    $this->conn::connect();
    if(isset($request)){
      $this->result = $this->conn::insertInTo('users')
      ->set('username', $_POST['username'])
      ->set('email', $_POST['email'])
      ->set('password', $_POST['password'])
      ->set('created_by', '1')
      ->set('created_at', $this->date)
      ->save();
    }
    return $this->result;
  }
  public function storeMenu($request){
    $this->conn::connect();
    if(isset($request)){
      $this->result = $this->conn::insertInTo('menus')
        ->set('menu_title', $_POST['menu_title'])
        ->set('description', $_POST['description'])
        ->set('created_by', '1')
        ->set('created_at', $this->date)
        ->save();
    }
    return $this->result;
  }
  public function __destruct(){
    $this->conn::close();
  }
}