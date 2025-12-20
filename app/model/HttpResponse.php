<?php

/**
 * HttpResponse model to represent standardized HTTP response information.
 * Designed to handle the http responses in the application.
 *
 * Properties:
 *  - code (int)
 *  - level (string) : success|info|warning|danger
 *  - name (string)
 *  - description (string)
 *  - message (?string) : optional message
 */
class HttpResponse {

    private int $code;
    private string $name;
    private string $description;
    private string $level; // success|info|warning|danger
    private ?string $message;

    /**
     * Map of HTTP-responses codes to structured name/description entries.
     *
     * @var array<int,array{name:string,description:string}>
     */
    private static array $httpResponseMessages = [
        // 1xx Informational
        100 => ['name' => 'Continue', 'description' => 'Initial part of a request has been received and has not yet been rejected by the server'],
        101 => ['name' => 'Switching Protocols', 'description' => 'Server is switching protocols as requested by the client'],
        102 => ['name' => 'Processing', 'description' => 'WebDAV: the server has received and is processing the request'],
        103 => ['name' => 'Early Hints', 'description' => 'Used to return some response headers before final HTTP message'],

        // 2xx Success
        200 => ['name' => 'OK', 'description' => 'The request has succeeded'],
        201 => ['name' => 'Created', 'description' => 'The request has been fulfilled and resulted in a new resource being created'],
        202 => ['name' => 'Accepted', 'description' => 'The request has been accepted for processing, but processing is not complete'],
        203 => ['name' => 'Non-Authoritative Information', 'description' => 'The returned meta-information is not the definitive set from the origin server'],
        204 => ['name' => 'No Content', 'description' => 'The server successfully processed the request and is not returning any content'],
        205 => ['name' => 'Reset Content', 'description' => 'The server successfully processed the request, asks that the requester reset its document view'],
        206 => ['name' => 'Partial Content', 'description' => 'Server is delivering only part of the resource due to a range header sent by the client'],
        207 => ['name' => 'Multi-Status', 'description' => 'WebDAV: conveys information about multiple resources'],
        208 => ['name' => 'Already Reported', 'description' => 'WebDAV: members of a DAV binding have already been enumerated'],
        226 => ['name' => 'IM Used', 'description' => 'The server has fulfilled a GET request for the resource, and the response is a representation of the result of one or more instance-manipulations'],

        // 3xx Redirection
        300 => ['name' => 'Multiple Choices', 'description' => 'There are multiple options for the resource from which the client may choose'],
        301 => ['name' => 'Moved Permanently', 'description' => 'The resource has permanently moved to a new URI'],
        302 => ['name' => 'Found', 'description' => 'The resource resides temporarily under a different URI'],
        303 => ['name' => 'See Other', 'description' => 'The response to the request can be found under another URI using GET'],
        304 => ['name' => 'Not Modified', 'description' => 'The resource has not been modified since the version specified by the request headers'],
        305 => ['name' => 'Use Proxy', 'description' => 'The requested resource is available only through a proxy (deprecated)'],
        306 => ['name' => 'Switch Proxy', 'description' => 'Previously used for subsequent requests (no longer used)'],
        307 => ['name' => 'Temporary Redirect', 'description' => 'The request should be repeated with another URI; same method must be used'],
        308 => ['name' => 'Permanent Redirect', 'description' => 'The request and all future requests should be repeated using another URI'],

        // 4xx Client Errors
        400 => ['name' => 'Bad Request', 'description' => 'The server could not understand the request due to invalid syntax'],
        401 => ['name' => 'Unauthorized', 'description' => 'Authentication is required and has failed or has not yet been provided'],
        402 => ['name' => 'Payment Required', 'description' => 'Reserved for future use'],
        403 => ['name' => 'Forbidden', 'description' => 'The client does not have access rights to the content'],
        404 => ['name' => 'Not Found', 'description' => 'The server can not find the requested resource'],
        405 => ['name' => 'Method Not Allowed', 'description' => 'The request method is known by the server but is not supported by the target resource'],
        406 => ['name' => 'Not Acceptable', 'description' => 'The server cannot produce a response matching the list of acceptable values'],
        407 => ['name' => 'Proxy Authentication Required', 'description' => 'Authentication is required to use a proxy'],
        408 => ['name' => 'Request Timeout', 'description' => 'The server timed out waiting for the request'],
        409 => ['name' => 'Conflict', 'description' => 'The request could not be completed due to a conflict with the current state of the target resource'],
        410 => ['name' => 'Gone', 'description' => 'The resource requested is no longer available and will not be available again'],
        411 => ['name' => 'Length Required', 'description' => 'The request did not specify the length of its content'],
        412 => ['name' => 'Precondition Failed', 'description' => 'One or more conditions given in the request header fields evaluated to false'],
        413 => ['name' => 'Payload Too Large', 'description' => 'The request entity is larger than limits defined by server'],
        414 => ['name' => 'URI Too Long', 'description' => 'The URI provided was too long for the server to process'],
        415 => ['name' => 'Unsupported Media Type', 'description' => 'The media format of the requested data is not supported by the server'],
        416 => ['name' => 'Range Not Satisfiable', 'description' => 'The range specified by the Range header field in the request cannot be fulfilled'],
        417 => ['name' => 'Expectation Failed', 'description' => 'The expectation given in the request\'s Expect header could not be met'],
        418 => ['name' => "I'm a teapot", 'description' => 'RFC 2324 HTCPCP/1.0: The server is a teapot and cannot brew coffee'],
        421 => ['name' => 'Misdirected Request', 'description' => 'The request was directed at a server that is not able to produce a response'],
        422 => ['name' => 'Unprocessable Entity', 'description' => 'The request was well-formed but was unable to be followed due to semantic errors'],
        423 => ['name' => 'Locked', 'description' => 'The resource that is being accessed is locked'],
        424 => ['name' => 'Failed Dependency', 'description' => 'The request failed due to failure of a previous request'],
        425 => ['name' => 'Too Early', 'description' => 'Indicates the server is unwilling to process a request that might be replayed'],
        426 => ['name' => 'Upgrade Required', 'description' => 'The client should switch to a different protocol'],
        428 => ['name' => 'Precondition Required', 'description' => 'The origin server requires the request to be conditional'],
        429 => ['name' => 'Too Many Requests', 'description' => 'The user has sent too many requests in a given amount of time'],
        431 => ['name' => 'Request Header Fields Too Large', 'description' => 'The server is unwilling to process the request because its header fields are too large'],
        451 => ['name' => 'Unavailable For Legal Reasons', 'description' => 'The user-agent requested a resource that cannot be provided for legal reasons'],

        // 5xx Server Errors
        500 => ['name' => 'Internal Server Error', 'description' => 'The server has encountered a situation it does not know how to handle'],
        501 => ['name' => 'Not Implemented', 'description' => 'The request method is not supported by the server and cannot be handled'],
        502 => ['name' => 'Bad Gateway', 'description' => 'The server, while acting as a gateway, received an invalid response from the upstream server'],
        503 => ['name' => 'Service Unavailable', 'description' => 'The server is not ready to handle the request'],
        504 => ['name' => 'Gateway Timeout', 'description' => 'The server is acting as a gateway and cannot get a response in time'],
        505 => ['name' => 'HTTP Version Not Supported', 'description' => 'The HTTP version used in the request is not supported by the server'],
        506 => ['name' => 'Variant Also Negotiates', 'description' => 'The server has an internal configuration error: transparent content negotiation for the request results in a circular reference'],
        507 => ['name' => 'Insufficient Storage', 'description' => 'The server is unable to store the representation needed to complete the request'],
        508 => ['name' => 'Loop Detected', 'description' => 'The server detected an infinite loop while processing the request (WebDAV)'],
        510 => ['name' => 'Not Extended', 'description' => 'Further extensions to the request are required for the server to fulfil it'],
        511 => ['name' => 'Network Authentication Required', 'description' => 'The client needs to authenticate to gain network access'],
    ];

    public function __construct(int $code, ?string $message = null)
    {
        $this->setCode($code);
        $this->setMessage($message);
    }

    public function getCode(): int
    {
        return $this->code;
    }
    public function setCode(int $num): void
    {
        $this->code = $num;
        $defaultName = 'Error';
        $defaultDescription = 'An unexpected error occurred.';

        if (isset(self::$httpResponseMessages[$num]) && is_array(self::$httpResponseMessages[$num])) {
            $error = self::$httpResponseMessages[$num];
            $this->name = $error['name'] ?? $defaultName;
            $this->description = $error['description'] ?? $defaultDescription;
        } else {
            $this->name = $defaultName;
            $this->description = $defaultDescription;
        }

        $this->level = $this->determineLevel($num);
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

    public function getLevel(): string
    {
        return $this->level;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    private function determineLevel(int $code): string {
        if ($code >= 200 && $code < 300) return 'success';
        if ($code >= 300 && $code < 400) return 'info';
        if ($code >= 400 && $code < 500) return 'warning';
        return 'danger';
    }

    public function getTitle(): string {
        switch ($this->level) {
            case 'success': return 'Success';
            case 'info': return 'Info';
            case 'warning': return 'Warning';
            default: return 'Error';
        }
    }

}
