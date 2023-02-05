# Yanatoon
PHP avatar generation library

```php
include 'src/Yanatoon.php';
use danilo9\Yanatoon;
Yanatoon::setContentType(); // Set Header ContentType PNG
Yanatoon::make(800)->printImage(); // Create avatar and print

// size, type, data
$size = 512; // Size 512x512
$gender = 'male'; // Male
$data = ['hair' => 10];
Yanatoon::make($size, $gender, $data)->printImage(); // Create avatar and print
```
