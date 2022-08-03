<?php

namespace App\Service;

use App\Contract\TokenInterface;
use App\Traits\HasErrors;
use Illuminate\Support\Facades\Auth;

class Token implements TokenInterface
{
    use HasErrors;

    public function authTokens($email, $password): string
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('IdeaSoft')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success);
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
