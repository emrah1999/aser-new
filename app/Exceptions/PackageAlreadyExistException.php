<?php

namespace App\Exceptions;

use App\Package;
use Exception;
use Throwable;

/**
 * Class PackageAlreadyExistException
 * @package App\Exceptions
 */
class PackageAlreadyExistException extends Exception
{
    /**
     * @var Package
     */
    private $package;

    /**
     * PackageAlreadyExistException constructor.
     * @param Package $package
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(Package $package, $message = "The package is already exists by id: ", $code = 400, Throwable $previous = null)
    {
        $this->package = $package;

        parent::__construct($message . $this->package->getAttribute('id'), $code, $previous);
    }

    /**
     * @return Package
     */
    public function getPackage(): Package
    {
        return $this->package;
    }
}
