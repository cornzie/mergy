<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function formattedResponse(mixed $data = [], int $code = 200, string $message = 'success')
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function formattedError(string $message = 'Something went wrong', int $code = 500)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ]);
    }
}
