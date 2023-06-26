<?php
require "../vendor/autoload.php";
require "./services/MidtermService.php";
require "./services/FinalService.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::register('midtermService', 'MidtermService');
Flight::register('finalService', 'FinalService');

require 'routes/MidtermRoutes.php';
require 'routes/FinalRoutes.php';

Flight::before('*/rest/final/share_classes', function(){
    if (!$authenticated) {
        Flight::halt(401, 'Unauthorized');
    }
});

Flight::before('*/rest/final/share_class_categories', function(){
    if (!$authenticated) {
        Flight::halt(401, 'Unauthorized');
    }
});

Flight::start();

 ?>
