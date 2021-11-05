<?php
$conn = mysqli_connect('localhost', 'root', '', 'ajaxcart');
if(!$conn){
    echo "CONNECTION FAILED";
    die();
}
?>