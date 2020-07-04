<?php

$config['SITE_URL'] = 'sound_desk';

$config['SITE_ASSETS'] = $config['SITE_URL'].'assets/';
$config['SITE_PATH'] = $_SERVER['DOCUMENT_ROOT'].'/sound_desk/';



//DATABASE CONFIGURATION
$config['DB_HOST'] = 'localhost';
$config['DB_USER'] = 'root';
$config['DB_PASS'] = '';
$config['DB_NAME'] = 'sound_desk';


//EMAIL CONFIGURATION



foreach ($config as $key => $value) {
	define($key, $value);
}  