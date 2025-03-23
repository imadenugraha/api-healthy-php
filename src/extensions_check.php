<?php

function extensions_check(array $extensions): array {
    $result = [];

    foreach ($extensions as $text) {
        $result[$text] = extension_loaded($text) ? "enabled":"disabled";
    }

    return $result;
}
