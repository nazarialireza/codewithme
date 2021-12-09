<?php

class Route {
  public static string $urls;
  public static int $urlCount;
  public static string $basePath;

  public static function init()
  {
    self::$urls = (isset($_SERVER["REDIRECT_URL"])) ? $_SERVER["REDIRECT_URL"] : '';
    self::$urls = str_replace(APP_PATH, '',self::$urls);
    self::$urls = explode("/", self::$urls);
    array_shift(self::$urls);
    self::$urlCount = count(self::$urls);
    self::setPath();
  }
  public static function get($request, $views){
    $flag = false;
    $request = explode('/', $request);
    if(count($request)== self::$urlCount){
      foreach ($request as $i => $path){
        if($path === self::$urls[$i]){
          $flag = true;
        } else {
          $flag = false;
        }
      }
    }

    if($flag){

      if(file_exists(self::$basePath.$views.'.php')) {
//        include self::$basePath.$views.'.php';
        $master = self::getMaster($views);
        if($master['masterPage'] !== false && $master['masterCallLine'] !== false){
          $file = file(self::$basePath.$views.'.php');
          $subFile = file(self::$basePath.$master['masterPage'].'.php');
          foreach ($file as $lineNumber => $line) {
            if (strpos($line, '@extend') !== false) {
              $file[$lineNumber] = str_replace($line, '', $line);
            }
          }
          $outputFile= '';
          foreach ($file as $line){
            $outputFile.=$line;
          }
          foreach ($subFile as $lineNumber => $line) {
            if ($lineNumber == $master['masterCallLine']) {
              $subFile[$lineNumber] = str_replace($line, $outputFile, $line);
            }
          }
          $output = '';
          foreach ($subFile as $line){
            $output.=$line;
          }
          self::get_values("{{", "}}",$output,$views);
        } else {
          require self::$basePath.$views.'.php';
        }
      }
    }
  }
  public static function setPath(){
    if(empty(APP_PATH)){
      self::$basePath = ROOT_PATH.APP_VIEWS.'/';
    }else{
      self::$basePath = ROOT_PATH.APP_PATH.APP_VIEWS.'/';
    }
  }
  public static function getFinal(){
    include self::$basePath.'404.php';
    exit();
  }
  public static function getLink($line, array $string){
    $line = str_replace("\n", '', $line);
    $line = str_replace(" ", '', $line);
    $line = substr_replace($line ,"",-1);
    $line = str_replace($string[0], '', $line);
    $line = str_replace($string[1], '', $line);
    return str_replace(".", '/', $line);
  }

  public static function getMaster($views){
    $file = file(self::$basePath.$views.'.php');
    $master = ['masterPage' => false,'masterCallLine' => false];
    foreach ($file as $lineNumber => $line) {
      if (strpos($line, '@extend') !== false) {
        $line = self::getLink($line, ["@extend('", "')"]);
        $masterFile = file(self::$basePath . $line . '.php');
        $master['masterPage'] = $line;
        foreach ($masterFile as $masterNumber => $masterLine){
          if (strpos($masterLine, '@call') !== false) {
            $masterLine = self::getLink($masterLine, ["@call('", "')"]);
            $master['masterCallLine'] = $masterNumber;
          }
        }
      }
    }
    return $master;
  }
  public static function get_values($start, $end, $string, $views){
    $string = str_replace($start,"<?php echo ",  $string);
    $string = str_replace($end,'?>',  $string);

    $file = ROOT_PATH.APP_PATH.APP_CACHE.random_int(111111,999999).'_cache.php';
    file_put_contents($file, $string);
    require $file;

  }
}