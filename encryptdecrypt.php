<?php
function encrypt($simple_string)
{	
	// Store the cipher method
	$ciphering = "AES-128-CTR";

	// Use OpenSSl Encryption method
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;

	// Non-NULL Initialization Vector for encryption
	$encryption_iv = '1234567891011121';

	// Store the encryption key
	$encryption_key = "KisanMitra";

	// Use openssl_encrypt() function to encrypt the data
	$encryption = openssl_encrypt($simple_string, $ciphering,
	$encryption_key, $options, $encryption_iv);
	
	return $encryption;
}

function decrypt($encryption)
{
	// Non-NULL Initialization Vector for decryption
	$decryption_iv = '1234567891011121';

	// Store the decryption key
	$decryption_key = "KisanMitra";
	
	// Store the cipher method
	$ciphering = "AES-128-CTR";
	$options = 0;
	
	// Use openssl_decrypt() function to decrypt the data
	$decryption=openssl_decrypt ($encryption, $ciphering,
	$decryption_key, $options, $decryption_iv);
	
	return $decryption;
}
?>
