<?php
/*
 * Database connection class
 * by alireza nazari
 * */

class Database {
  private static $link;
  public static $id;
  public static $connected = false;
  public static $table = null;
  public static $attributes = [];
  public static $values = [];

  public static function link() {
    return self::$link;
  }
  public static function connect() {
    if (self::$connected == false) {
      self::$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
      if (mysqli_connect_errno()) {
          die("cannot connect to mysql");
      }
      self::$connected = true;
      self::query("SET CHARACTER SET utf8");
    }
  }
  public static function get($table, $columns, $if = '1', $loop = 0){
    $return = false;
    if ($columns == '*') {
        $query = self::query("SELECT * FROM `{DB_PREFIX}$table` WHERE $if");
        if ($rows = mysqli_fetch_array($query)) $return = $rows;
    }
    elseif(substr($columns, 0, 1) == '`') {
        $query = self::query("SELECT $columns FROM `{DB_PREFIX}$table` WHERE $if");
        $return = mysqli_fetch_array($query);
    } else {
        $query = self::query("SELECT `$columns` FROM `{DB_PREFIX}$table` WHERE $if LIMIT 0,1");
        $return = mysqli_fetch_array($query);
        $return = $return[0];
    }
    mysqli_free_result($query);
    return $return;
  }
  public static function num($table, $if = '1', $DISTINCT = null) {
      $query = $DISTINCT == null ? self::query("SELECT * FROM `{DB_PREFIX}$table` WHERE $if") : self::query("SELECT $DISTINCT FROM `{DB_PREFIX}$table` WHERE $if");
      $num = mysqli_num_rows($query);
      mysqli_free_result($query);
      return ($num);
  }
  public static function update($table, $values, $where, $val) {

      $query = self::query("UPDATE `{DB_PREFIX}$table` SET $values WHERE `$where`='$val'");
      return ($query);

  }
  public static function query($query) {
      if (self::$connected == false) self::connect();
      $query = str_replace(array('{DB_PREFIX}', '{DB_NAME}'), array(DB_PREFIX, DB_NAME), $query);
      $query = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
      return ($query);
  }
  public static function multi_query($queries) {
      if (self::$connected == false) self::connect();
      $queries = str_replace(array('{DB_PREFIX}', '{DB_NAME}'), array(DB_PREFIX, DB_NAME), $queries);
      $queries = mysqli_multi_query(self::$link, $queries) or die(mysqli_error(self::$link));
      return ($queries);
  }
  public static function delete($table, $where = '1') {
      $query = self::query("DELETE FROM `{DB_PREFIX}$table` WHERE $where");
      return ($query);
  }
  public static function insert($table, $columns, $values) {
	$query = self::query("INSERT INTO `{DB_PREFIX}$table` ($columns) VALUES ($values)");
	self::$id = mysqli_insert_id(self::$link);
	return ($query);
  }
  public static function insertInTo($table): self {
    self::$table = $table;
    return new self();
  }
  public static function set($attribute, $value):self {
    array_push(self::$attributes, $attribute);
    array_push(self::$values, $value);
    return new self();
  }
  public static function save(){
    $columns = '';
    $values = '';
    foreach (self::$attributes as $index => $attribute){
      $columns.="`$attribute`";
      if(isset(self::$attributes[$index+1])){
        $columns.=", ";
      }
    }
    foreach (self::$values as $index => $value){
      $values.="'$value'";
      if(isset(self::$values[$index+1])){
        $values.=", ";
      }
    }
    return self::insert(self::$table,$columns,$values);
  }
  public static function select($table, $columns, $where = null, $fetch = null) {
	  if($where != null) {
	  	if($fetch == true){
	        $query = self::query("SELECT $columns FROM `{DB_PREFIX}$table` WHERE $where");
			return mysqli_fetch_array($query);
	    } else {
	        $query = self::query("SELECT $columns FROM `{DB_PREFIX}$table` WHERE $where");
		    self::$id = mysqli_fetch_array($query);
	        return ($query);
	    }
	  }else if ($fetch == true){
			$query = self::query("SELECT $columns FROM `{DB_PREFIX}$table`");
			return mysqli_fetch_array($query);
	  }else {
			$query = self::query("SELECT $columns FROM `{DB_PREFIX}$table`");
			self::$id = mysqli_fetch_array($query);
			return ($query);
	  }
  }
  public static function close() {
      if (self::$connected) {
          mysqli_close(self::$link);
          self::$connected = false;
      }
  }
  public static function truncate($table) {
      self::query("TRUNCATE TABLE `{DB_PREFIX}$table`");
  }

  public static function size($table = null) {
      if ($table == null) {
          $result = array();
          $query = self::query("SELECT round(((`data_length` + `index_length`) /1024 ) , 2) 'Size in KB', `table_name` FROM information_schema.TABLES WHERE table_schema = '{DB_NAME}'");
          while ($row = mysqli_fetch_array($query)) {
              $result[$row['table_name']] = $row[0];
          }
      } else {
          $query = self::query("SELECT round(((`data_length` + `index_length`) /1024 ) , 2) 'Size in KB' FROM information_schema.TABLES WHERE table_schema = '{DB_NAME}' AND table_name = '{DB_PREFIX}$table' LIMIT 0 , 1");
          $result = mysqli_fetch_array($query);
          $result = $result[0];
      }
      mysqli_free_result($query);
      return $result;
  }
  public static function check($table) {
      $query = self::query("CHECK TABLE `{DB_PREFIX}$table`");
      return (mysqli_fetch_array($query));
  }
  public static function repair($table) {
      $query = self::query("REPAIR TABLE `{DB_PREFIX}$table`");
      return (mysqli_fetch_array($query));
  }
}

