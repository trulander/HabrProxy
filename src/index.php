<?php

require_once('../vendor/autoload.php');

use HabrProxy\Core\Proxy;

$Proxy = new Proxy();

echo $Proxy->getPage();
