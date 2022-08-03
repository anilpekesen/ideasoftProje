<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

class RegisterController extends Controller
{
    //

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error!', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('IdeaSoftProje')->plainTextToken;
        $success['name'] =  $user->name;
        return $this->sendResponse($success, 'User Successfully!');


    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('IdeaSoftProje')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User Login Successfully !');
        }
        else{
            return $this->sendError('Unauthorized Operation !', ['error'=>'Unauthorised']);
        }
    }
}

