<?php

session_start();
header("Content-type: image/png");

// Generate a random string
$random_str = md5(rand());
$captcha_text = substr($random_str, 0, 5);


// Store the captcha text in a session variable
$_SESSION['captcha_text'] = $captcha_text;

// Create an image
$image = imagecreate(120, 40);

// Set the background color
$background_color = imagecolorallocate($image, 255, 255, 255);

// Set the text color
$text_color = imagecolorallocate($image, 0, 0, 0);

// Add the captcha text to the image
imagestring($image, 5, 35, 10, $captcha_text, $text_color);




// Add some noise
for ($i = 0; $i < 100; $i++) {
$pixel_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
imagesetpixel($image, rand(0, 120), rand(0, 40), $pixel_color);
}




// Output the image
imagepng($image);
imagedestroy($image);