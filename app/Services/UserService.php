<?php

namespace App\Services;

use App\Models\Code;
use App\Models\User;
use Illuminate\Support\Str;

class UserService {

    public function newRegister(array $data){

        $user=$this->createUser($data['name'],$data['mobile_phone']);
        $login_code=$this->generateUniqueCode();
        $code=$this->createCode($login_code,$user->id,$data['specialization_id']);

        return $user;
    }

    public function createUser($user_name,$mobile_phone){
        $user=User::create([
            'name'=>$user_name,
            'mobile_phone'=>$mobile_phone
        ]);
        return $user;
    }

    public function createCode($login_code,$user_id,$specialization_id){
        $code=Code::create([
            'login_code'=>$login_code,
            'user_id'=>$user_id,
            'specialization_id'=>$specialization_id
        ]);
        return $code;
    }

    public function generateUniqueCode(){
        do {
            $loginCode= Str::random(6, '1234567890');
        } while (Code::where('login_code', $loginCode)->exists());
        return $loginCode;

    }
}
