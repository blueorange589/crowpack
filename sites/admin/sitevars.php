<?php
$SITEVARS = array(
    'requireauth'       => true,
    'authsave'          => 'SESSION',
    'authsavekey'       => 'admloggedin',
    'authfields'    => array(
        'username'  => 'Username',
        'password'  => 'Password'
    ),
    'authtable'         => 'cp_admin',
    'authdbcols'     => array(
        'username'   => 'username',
        'password'   => 'pwd'
    )
);
?>
