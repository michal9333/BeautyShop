<?php
session_start();

$_SESSION['cart'] = [];

http_response_code(200);
echo `OK`;