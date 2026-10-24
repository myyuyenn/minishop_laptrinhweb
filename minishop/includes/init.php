<?php
declare(strict_types=1);

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = ''): string
{
    $scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $basePath = rtrim($scriptDirectory, '/');

    return $basePath . '/' . ltrim($path, '/');
}

function format_price($price): string
{
    return number_format((float) $price, 0, ',', '.') . ' đ';
}

require_once __DIR__ . '/../config/db.php';
