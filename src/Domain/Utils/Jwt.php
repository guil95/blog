<?php

declare(strict_types=1);


namespace App\Domain\Utils;

final class Jwt
{
    public static function generate(array $params):string
    {
        $key = getenv('SECRET_JWT');

        $params['exp'] = time() + 3600;

        return \Firebase\JWT\JWT::encode($params, $key);
    }
}
