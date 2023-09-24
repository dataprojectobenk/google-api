<?php
include "vendor/autoload.php";
use library\DriveModel;

$data = new DriveModel();
echo '<pre>';
print_r($data->getList());
echo '</pre>';