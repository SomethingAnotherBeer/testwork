<?php 
require_once __DIR__."/vendor/autoload.php";
$words_obj = new App\Words();

$words_obj->setValue('Привет! Давно не виделись');
echo $words_obj->getResult()."\n";
$words_obj->setValue('Что то такое, чего я ранее не видел.');
echo $words_obj->getResult()."\n";


 ?>