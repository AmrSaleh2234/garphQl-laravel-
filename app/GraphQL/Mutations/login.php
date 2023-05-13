<?php

namespace App\GraphQL\Mutations;

use App\Http\Middleware\ValidateSignature;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

final class login
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {

        $user = User::where('email', $args['email'])->first();
        if(!$user || !Hash::check($args['password'],$user->password) ){
            return "credential un correct ";
        }
        return $user->createToken('API TOKEN')->plainTextToken;

    }
}
