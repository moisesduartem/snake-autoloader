<?php

/**
 * CamelCase to snake_case class autoloader!
 * github.com/moisesduartem/snake-autoloader
 * by Moisés Mariano
 */

function from_camel_case($input) {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
      $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}

$parser = function (string $full_namespace) {
    $namespace_parts = explode('\\', $full_namespace);
    $path = '';
    foreach ($namespace_parts as $part) {
        $path = $path . '/' . from_camel_case($part);
    }
    return $path;
};

spl_autoload_register(function ($class_name) use ($parser) {
    require_once __DIR__ . $parser($class_name) . '.php';
});
