<?php

namespace Emporium\Svc\Alert\Http;

function exceptionResponse($status, $code, $e) {
    return response()->json([
        'code' => $code,
        'message' => $e->getMessage(),
        'exception' => get_class($e) . ': ' . $e->getMessage(),
    ], $status);
}
