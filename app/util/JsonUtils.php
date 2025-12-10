<?php

/**
 * JsonUtils: a collection of stateless JSON helpers as static methods.
 */
class JsonUtils
{
    /**
     * Send a successful JSON response with a standardized payload.
     * Structure: { status: true, data: any }
     */
    public static function jsonResponse($data = null, int $httpStatus = 200)
    {
        http_response_code($httpStatus);
        header('Content-Type: application/json');
        $payload = [
            'status' => true,
            'data' => $data
        ];
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Send an error JSON response with a standardized payload.
     * Structure: { status: false, message: string, ...extra }
     */
    public static function jsonError(string $message, array $extra = [], int $httpStatus = 400)
    {
        http_response_code($httpStatus);
        header('Content-Type: application/json');
        $payload = array_merge([
            'status' => false,
            'message' => $message
        ], $extra);
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Read and decode the JSON request body into an associative array.
     * Returns null when body is empty or invalid JSON.
     */
    public static function readJsonBody()
    {
        $raw = file_get_contents('php://input');
        if ($raw === false || $raw === '') return null;
        $data = json_decode($raw, true);
        return is_array($data) ? $data : null;
    }

    /**
     * Resolve a serializer into a callable.
     * - Accepts a callable directly
     * - Or a method name string resolved against $context or the $item
     * - Falls back to $item->toArray() when available
     */
    public static function resolveSerializer($serializer, $context = null, $item = null): ?callable
    {
        // If already a callable (Closure or invokable), return as-is
        if (is_callable($serializer) && !is_string($serializer)) {
            return $serializer;
        }

        // If a method name is provided, wrap into a Closure to ensure true callable
        if (is_string($serializer)) {
            if ($context && method_exists($context, $serializer)) {
                return function ($i) use ($context, $serializer) {
                    return $context->$serializer($i);
                };
            }
            // If item has the method, call it on the incoming item
            if ($item && is_object($item) && method_exists($item, $serializer)) {
                return function ($i) use ($serializer) {
                    return $i->$serializer();
                };
            }
        }

        // Fallback to toArray() on the item if available
        if ($item && is_object($item) && method_exists($item, 'toArray')) {
            return function ($i) {
                return $i->toArray();
            };
        }

        return null;
    }

    /**
     * Serialize a single item using a given serializer (callable or method name).
     */
    public static function serializeItem($item, $serializer, $context = null)
    {
        $callable = self::resolveSerializer($serializer, $context, $item);
        if ($callable) {
            return $callable($item);
        }
        return $item;
    }

    /**
     * Serialize a list of items using a given serializer (callable or method name).
     */
    public static function serializeArray(iterable $items, $serializer, $context = null): array
    {
        $out = [];
        foreach ($items as $it) {
            $out[] = self::serializeItem($it, $serializer, $context);
        }
        return $out;
    }
}
