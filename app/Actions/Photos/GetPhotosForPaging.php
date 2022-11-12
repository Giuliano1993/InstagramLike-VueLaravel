<?php

namespace App\Actions\Photos;

use Illuminate\Support\Facades\DB;

class GetPhotosForPaging{
    static public function get(){
        return DB::table('photos')
        ->join('users', 'photos.user_id', '=', 'users.id')
        ->select('photos.*', 'users.id as user_id', 'users.name as user_name', 'users.profile_photo_path')
        ->orderByDesc('photos.id')
        ->paginate(2);
    }
}