<?php


namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

use phpDocumentor\Reflection\Types\String_;

trait ApiResponser
{
    /**
     * Return a success Json response
     *
     * @param $data
     * @param string|null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $message = null, $code = 200)
    {
        return response()->json([
            "status" => "Success",
            "message" => $message,
            "data" => $data
        ], $code);
    }

    public function error($message, $code, $data = null)
    {
        return response()->json([
            "status" => "Error",
           "data" => $data,
           "message" => $message,
        ], $code);
    }

}
