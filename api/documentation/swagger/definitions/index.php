<?php

$dir = __DIR__;
$definitions = scandir($dir);

$result = [];
foreach ($definitions as $i => $definition) {
    if (in_array($definition, ['.', '..', 'index.php'])) {
        continue;
    }

    $filePath = "{$dir}/{$definition}";
    if (is_file($filePath)) {
        $fileName = pathinfo($filePath, PATHINFO_FILENAME);

        $result[$fileName] = require($filePath);
    }
}

return $result;
