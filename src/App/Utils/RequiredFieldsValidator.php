<?php

declare(strict_types=1);


namespace App\App\Utils;

use App\Domain\DomainBlogException;
use Swaggest\JsonSchema\Schema;

final class RequiredFieldsValidator
{
    /**
     * @param array $requiredParams
     * @param array $requestParams
     * @throws DomainBlogException
     * @throws \Swaggest\JsonSchema\Exception
     * @throws \Swaggest\JsonSchema\InvalidValue
     */
    public static function validate(array $requiredParams, array $requestParams)
    {
        $schemaJson = json_encode(['required' => $requiredParams]);
        $schema = Schema::import(json_decode($schemaJson));
        try {
            $schema->in((object)$requestParams);
        } catch (\Exception $exception) {
            preg_match('/^Required property missing: ([a-zA-z]+),/', $exception->getMessage(), $matches);
            throw new DomainBlogException(sprintf('Field %s is required', $matches[1]));
        }
    }
}
