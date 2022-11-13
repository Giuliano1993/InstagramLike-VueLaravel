<?php

namespace App\Actions\Photos;

use Illuminate\Support\Facades\DB;

class GetPhotosForPaging{
    static public function get(){
        return DB::table('photos')
        ->select('photos.*', 'users.id as user_id', 'users.name as user_name', 'users.profile_photo_path', 'like_table.like_count')
        ->join('users', 'photos.user_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT photo_id, COUNT(DISTINCT(id)) as like_count FROM likes WHERE likes = 1 GROUP BY (photo_id)) as like_table'),'photos.id','=','like_table.photo_id')
        ->orderByDesc('photos.id')
        ->paginate(2);
    }
}