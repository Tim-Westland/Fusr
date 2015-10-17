<?php
$alpha = "abcdefghijklmnopqrstuvwxyz";
$alpha_upper = strtoupper($alpha);
$numeric = "0123456789";
$special = ".-+=_,!@$#*%<>[]{}";
$chars = "";
 
if (isset($_POST['length'])){
    // if you want a form like above
    if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
        $chars .= $alpha;
     
    if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
        $chars .= $alpha_upper;
     
    if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
        $chars .= $numeric;
     
    if (isset($_POST['special']) && $_POST['special'] == 'on')
        $chars .= $special;
     
    $length = $_POST['length'];
}else{
    // default [a-zA-Z0-9]{9}
    $chars = $alpha . $alpha_upper;
    $length = 9;
}
 
$len = strlen($chars);
$username = '';
 
for ($i=0;$i<$length;$i++)
        $username .= substr($chars, rand(0, $len-1), 1);
 
// the finished username
$username = str_shuffle($username);