<?php

function generateCookieKey(int $length = 32): string
{
    $bytes = random_bytes($length);
    $base64 = base64_encode($bytes);
    $key = substr($base64, 0, $length);
    return strtr($key, '+/=', '_-.');
}

function updateEnvVar(string $file, string $key, string $value): void
{
    if (!file_exists($file)) {
        file_put_contents($file, "$key=$value\n");
        echo "Created $file with $key=$value\n";
        return;
    }

    $env = file_get_contents($file);

    if (preg_match("/^$key=.*$/m", $env)) {
        $env = preg_replace("/^$key=.*$/m", "$key=$value", $env);
        echo "Updated $key in $file\n";
    } else {
        $env .= "\n$key=$value\n";
        echo "Added $key to $file\n";
    }

    file_put_contents($file, $env);
}

// Main execution
$envFile = '.env';

$keyBE = generateCookieKey();
$keyFE = generateCookieKey();

updateEnvVar($envFile, 'COOKIE_VALIDATION_KEY_BE', $keyBE);
updateEnvVar($envFile, 'COOKIE_VALIDATION_KEY_FE', $keyFE);
