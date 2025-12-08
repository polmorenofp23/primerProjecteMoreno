<?php

/**
 * AppError model to represent standardized error information.
 *
 * Properties:
 *  - error_code (int)
 *  - name (string)
 *  - description (string)
 *  - message (?string) : optional developer/user message
 */
class AppError
{
    private int $error_code;
    private string $name;
    private string $description;
    private ?string $message;

    /**
     * Map of HTTP-like error codes to structured name/description entries.
     *
     * @var array<int,array{name:string,description:string}>
     */
    private static array $errorMessages = [
        400 => ['name' => 'Bad Request', 'description' => 'The request cannot be processed due to a client error'],
        401 => ['name' => 'Unauthorized', 'description' => 'Authentication is required to access this resource'],
        403 => ['name' => 'Forbidden', 'description' => 'You do not have permission to access this resource'],
        404 => ['name' => 'Not Found', 'description' => 'The page or resource you are looking for does not exist'],
        405 => ['name' => 'Method Not Allowed', 'description' => 'The HTTP method used is not allowed'],
        408 => ['name' => 'Request Timeout', 'description' => 'The request took too long to process'],
        409 => ['name' => 'Conflict', 'description' => 'There is a conflict with the current state of the resource'],
        410 => ['name' => 'Gone', 'description' => 'The resource is no longer available and will not be available again'],
        422 => ['name' => 'Unprocessable Entity', 'description' => 'The submitted data is not valid'],
        429 => ['name' => 'Too Many Requests', 'description' => 'You have exceeded the request limit'],
        500 => ['name' => 'Internal Server Error', 'description' => 'An internal server error occurred'],
        501 => ['name' => 'Not Implemented', 'description' => 'Functionality not implemented'],
        502 => ['name' => 'Bad Gateway', 'description' => 'Invalid response from the server'],
        503 => ['name' => 'Service Unavailable', 'description' => 'The service is temporarily unavailable'],
        504 => ['name' => 'Gateway Timeout', 'description' => 'The server did not respond in time']
    ];

    /**
     * Create a new Error model by code. If the code is not in the map,
     * a generic name/description will be used.
     *
     * @param int $code
     * @param string|null $message Optional additional message
     */
    public function __construct(int $code, ?string $message = null)
    {
        $this->setCode($code);
        $this->setMessage($message);
    }

    public function getCode(): int
    {
        return $this->error_code;
    }
    public function setCode(int $code): void
    {
        $this->error_code = $code;
        $defaultName = 'Error';
        $defaultDescription = 'An unexpected error occurred.';

        if (isset(self::$errorMessages[$code]) && is_array(self::$errorMessages[$code])) {
            $error = self::$errorMessages[$code];
            $this->name = $error['name'] ?? $defaultName;
            $this->description = $error['description'] ?? $defaultDescription;
        } else {
            $this->name = $defaultName;
            $this->description = $defaultDescription;
        }
        $this->message = null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

}
