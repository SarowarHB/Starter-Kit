<?php


namespace App\Library;


class Response
{

    public static function get(bool $success, string $message, mixed $data = '', int $code = 0)
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

    public static function success(string $message, mixed $data = null)
    {
        $body = array(
            'success' => true,
            'message' => $message
        );
        if($data)
            $body['data'] = $data;

        return response()->json($body);
    }

    public static function error(string $message, array $errors = [], int $code = 400)
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
