<?php
spl_autoload_register(function($class) {
  global $meta;
  
  $file = __DIR__.'/'. $class .'.class.php';
  	if(file_exists($file)) {
      require $file;
      // echo $file;
    }
    if(method_exists($class, '__construct')) {
      if($class=="app") {
        new app($meta);
      } else {
        new $class; // construct static
      }
    }
});
?>                    