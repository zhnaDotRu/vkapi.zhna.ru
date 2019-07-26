<?php

$router->get('/', 'ControllerMain@main');
$router->get('/aut',  'ControllerMain@authenticate');