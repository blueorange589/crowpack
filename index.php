<?php
require_once 'config.php';
require_once 'classes/autoload.php';
require_once 'vendor/autoload.php';
require_once 'classes/start.php';

init::load();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo init::$favicon; ?>">

    <title><?php echo CONFIG::$SITETITLE; ?></title>
    
    <?php foreach(init::$css as $cssurl) { ?>
    <link href="<?php echo $cssurl; ?>" rel="stylesheet">
    <?php } ?>
      
    <?php echo init::$initjson?'<script type="text/javascript">var initjson = '.init::$initjson.';</script>':''; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo CONFIG::$APPNAME; ?></a>
        </div>
        <?php echo init::$menu1; ?>
      </div>
    </nav>

    <div class="container-fluid">
        <?php foreach(init::$views as $v) { include 'views/'.$v.'.php'; } ?>
    </div> <!-- /container -->

    <?php foreach(init::$js as $jsurl) { ?>
    <script src="<?php echo $jsurl; ?>"></script>
    <?php } ?>
  </body>
</html>
