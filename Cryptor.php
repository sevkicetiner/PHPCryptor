<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19.09.2017
 * Time: 17:52
 */



function aes128_cbc_encrypt($key, $data, $iv) {
    if(16 !== strlen($key)) $key = hash('MD5', $key, true);
    if(16 !== strlen($iv)) $iv = hash('MD5', $iv, true);
    $padding = 16 - (strlen($data) % 16);
    $data .= str_repeat(chr($padding), $padding);
    return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
}

function aes128_cbc_decrypt($key, $dt, $iv) {
    $data = base64_decode($dt);
    if(16 !== strlen($key)) $key = hash('MD5', $key, true);
    if(16 !== strlen($iv)) $iv = hash('MD5', $iv, true);
    $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
    $padding = ord($data[strlen($data) - 1]);
    return substr($data, 0, -$padding);
}

$k = "passwordpassword";
$i = "ivpasswordivpass";

echo base64_encode(aes128_cbc_encrypt($k, "this text will crypt", $i));

//  browser export :  wOVP+aPw/fc9m0P6CdU6qW5PKJmMX9iNQAeSbZH7hwc=
echo "<br>";

echo aes128_cbc_decrypt($k, "wOVP+aPw/fc9m0P6CdU6qW5PKJmMX9iNQAeSbZH7hwc=", $i);

// browser export : this text will crypt