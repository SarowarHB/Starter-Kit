<?php


namespace App\Http\Traits;


trait ApiResponse
{
    public function response(bool $success, string $message, mixed $data = '', int $code = 0)
    {
        $body = array(
            'success' => $success,
            'message' => $message
        );
        if($data){
            $body['data'] = $data;
        }
        if($code == 0)
        {
            $code = $success ? 200 : 400 ;
        }
        return response()->json($body, $code);
    }

    public function successResponse(string $message, mixed $data = null)
    {
        $body = array(
            'success' => true,
            'message' => $message
        );
        if($data)
            $body['data'] = $data;

        return response()->json($body);
    }

    public function errorResponse(string $message, array $errors = [], int $code = 400)
    {
        $body = array(
            'success' => false,
            'message' => $message
        );
        if($errors)
            $body['data'] = $errors;

        return response()->json($body, $code);
    }
}
