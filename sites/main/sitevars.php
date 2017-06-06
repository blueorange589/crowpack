<?php
$SITEVARS = array(
    'requireauth'       => true,
    'authtype'          => 'basic',          // basic / db
    'authsave'          => 'SESSION',
    'authsavekey'       => 'loggedin',
    'authfields'    => array(
        'username'  => 'Username',
        'password'  => 'Password'
    ),
    'authtable'         => 'users',
    'authcols'      => array(
        'username'   => 'username',
        'password'   => 'pwd'
    ),
    'sessiontable'   => 'sessions',
    'tokencolumn'    => 'token',
    'template'      => array(
        'color-body-bg' =>  'brown',
        'color-body-font'   => '333',
        'font-family'       => 'Arial',
    )
);
?>
