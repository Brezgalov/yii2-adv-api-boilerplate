<?php

$dir = __DIR__;
$controllers = scandir($dir);

$result = [];
foreach ($controllers as $i => $controller) {
    if (in_array($controller, ['.', '..', 'index.php'])) {
        continue;
    }

    $filePath = "{$dir}/{$controller}";
    if (is_file($filePath)) {
        $result = array_merge($result, require($filePath));
    }
}

return $result;