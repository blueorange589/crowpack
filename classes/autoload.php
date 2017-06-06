<?php
spl_autoload_register(function($class) {
    $file = __DIR__.'/'. $class .'.class.php';
    if(file_exists($file)) {
        require $file;
    }
    if(method_exists($class, '__construct')) {
      if($class=="APP") {
        new APP();
      } else {
        new $class; // construct static
      }
    }
});
?>
