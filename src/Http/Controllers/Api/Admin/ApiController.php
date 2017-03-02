<?php

namespace AdiFaidz\Base\Http\Controllers\Api\Admin;

use Illuminate\Http\Response;

use AdiFaidz\Base\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $transformer;
    protected $statusCode = 200;

    public function getStatusCode(){
      return $this->statusCode;
    }

    public function setStatusCode($statusCode){
      $this->statusCode = $statusCode;

      return $this;
    }

    public function respondNotFound($message = "Not Found"){
      return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondBadRequest($message = "Bad Request"){
      return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    public function respond($data, $headers = []){
      return response()->json($data)->withHeaders($header);
    }

    public function respondWithError($message){
      return $this->respond([
        'error' => [
          'message' => $message,
          'status_code' => $this->getStatusCode()
        ]
      ]);
    }
}
