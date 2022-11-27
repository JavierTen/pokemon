<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{

    public function authenticate(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => $this->get_validation_rules("email", true),
                'password' => $this->get_validation_rules("password", true),
            ]);

            $validation_status = $validator->fails();

            if ($validation_status) {
                throw new Exception($validator->errors());
            }

            $user = User::where('email', $request->email)->first();

            if ($user) {
                $password = $user->password;

                if (Hash::check($request->password, $password)) {

                    return response()->json($this->generate_response(
                        array(
                            "message" => "Authenticated successfully",
                            "data" => $user,
                        ),
                        'SUCCESS'
                    ));
                } else {
                    throw new Exception("Invalid email or password", 401);
                }
            } else {
                throw new Exception("Invalid email or password", 401);
            }
        } catch (Exception $e) {
            return response()->json($this->generate_response(
                array(
                    "message" => $e->getMessage(),
                    "status_code" => $e->getCode(),
                )
            ));
        }
    }

    public function register(Request $request)
    {
        try {

            $this->validate_request($request);

            //check user email already exists
            $user_email_exists = User::where('email', $request->email)->first();

            if ($user_email_exists) {
                throw new Exception("Email is already added, try signing in");
            }

            $hashed_password = Hash::make($request->password);

            $user = new User();
            $user->password = $hashed_password;
            $user->email = $request->email;
            $user->save();

            return response()->json($this->generate_response(
                array(
                    "message" => "User created successfully",
                    "data" => $user,
                ),
                'SUCCESS'
            ));
        } catch (Exception $e) {
            return response()->json($this->generate_response(
                array(
                    "message" => $e->getMessage(),
                    "status_code" => $e->getCode(),
                )
            ));
        }
    }

    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => $this->get_validation_rules("email", true),
                'password' => $this->get_validation_rules("password", false),
            ]);

            $validation_status = $validator->fails();

            if ($validation_status) {
                throw new Exception($validator->errors());
            }

            $user = User::where('email', $request->email)->first();
            $user->name = $request->name;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->birthdate = $request->birthdate;

            if ($request->password != null) {
                $hashed_password = Hash::make($request->password);
                $user->password = $hashed_password;
            }

            $user->save();

            return response()->json($this->generate_response(
                array(
                    "message" => "Update successfully",
                    "data" => $user,
                ),
                'SUCCESS'
            ));
        } catch (Exception $e) {
            return response()->json($this->generate_response(
                array(
                    "message" => $e->getMessage(),
                    "status_code" => $e->getCode(),
                )
            ));
        }
    }
}
