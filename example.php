<?php
/**
 * @author 		Sijad aka Mr.Wosi
 * @link		  <a href='http://skinod.com'>Skinod.com</a>
 * @copyright	2015 <a href='http://skinod.com'>Skinod.com</a>
 * MODIFIED BY AHMED FATHY (AOFATHY) FOR SERVERS WITH allow_url_fopen DISABLED, USING cURL
 */

//Configuration
$ips_connect_key = 'b7705cb2cf70ee62efa97afab7a41f3b';
$remote_login = 'http://localhost/ips4/remote.php';

$email			= $_GET['email'];
$password		= $_GET['password'];
$key 			  = md5($ips_connect_key . $email);

// Fetch Salt First [cURL instead of file_get_contents]
$url 	  		= $remote_login . '?do=get_salt&id=' . $email . '&key=' . $key;
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);
$res = json_decode($result, true);

//Hash  Password
$hash = crypt( $password, '$2a$13$' . $res['pass_salt'] );

// Fetch Response [cURL instead of file_get_contents]
$url 			= $remote_login . '?do=login&id=' . $email . '&key=' . $key . '&password=' . $hash;
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);
$res = json_decode($result, true);

//Print Response
print_r($res);
