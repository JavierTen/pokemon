<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Exception;
use Validator;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function generate_response($response_array, $type = "")
    {
        switch ($type) {
            case "SUCCESS":
                $status_code = 200;
                break;
            case "NOT_AUTHORIZED":
                $status_code = 401;
                break;
            case "NO_ACCESS":
                $status_code = 403;
                break;
            case "BAD_REQUEST":
                $status_code = 400;
                break;
            default:
                $status_code = 200;
                break;
        }

        $response = array(
            'status' => true,
            'msg' => (isset($response_array['message'])) ? $response_array['message'] : "",
            'data' => (isset($response_array['data'])) ? $response_array['data'] : "",
            'status_code' => (isset($response_array['status_code'])) ? $response_array['status_code'] : $status_code
        );
        
        if (isset($response_array['link'])) {
            $response = array_merge($response, array("link" => $response_array['link']));
        }
        if (isset($response_array['new_tab'])) {
            $response = array_merge($response, array("new_tab" => $response_array['new_tab']));
        }
        return $response;
 
 
    }

     public function validate_request($request)
     {
     $validator = Validator::make($request->all(), [
        'email' => $this->get_validation_rules("email", true),
        'password' => $this->get_validation_rules("password", true),
        'name' => $this->get_validation_rules("fullname", false),
        'city' => $this->get_validation_rules("city", false),
        'address' => $this->get_validation_rules("address", false),
        'birthdate' => $this->get_validation_rules("birthdate", false),
     ]);
     $validation_status = $validator->fails();
     if($validation_status){
     throw new Exception($validator->errors());
     }
     }


    public function get_validation_rules($field, $required = false)
    {
    $rule = "";
    switch($field){
    case 'email' : $rule = "email|max:150|"; break;
    case 'password' : $rule = "alpha_dash|min:6|max:100|"; break;
    case 'name' : $rule = "alpha_spaces|max:100|"; break;
    case 'address' : $rule = "alpha_spaces|max:100|"; break;
    case 'city' : $rule = "alpha_spaces|max:100|"; break;
    case 'text' : $rule = "max:65535|"; break;
    case 'string' : $rule = 'string|'; break;
    case 'birthdate' : $rule = 'date|'; break;
    }

    if($required == true){
    $rule = implode('|', array('required', $rule));
    }else{
    $rule = implode('|', array('nullable', 'sometimes', $rule));
    }
    return $rule;
    }

}