<?php

use App\Models\Like;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Actions\Photos\GetPhotosForPaging;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('guest/photos',function(Request $request){
    $photos = GetPhotosForPaging::get();
    return Inertia::render('Guest/Photos',[
        'photos'=>$photos,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'likes'=>!is_null($request->user()) ? Like::where('user_id',$request->user()->id)->get() : []
    ]);
})->name('guest.photos');


Route::get('guest/profile/{user}',function(User $user, Request $request){
    return Inertia::render('Admin/Photos',[
        'photos'=>$user->photos,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'isLoggedInUser'=>!is_null($request->user()) && $request->user()->id === $user->id
    ]);
})->name('guest.profile');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('admin/profile',function(Request $request){
        $user = $request->user();
        return Inertia::render('Admin/Photos',[
            'photos'=>$user->photos,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    })->name('admin.photos');

    Route::get('admin/photos/new',function(){
        return Inertia::render('Admin/NewPhoto');
    })->name('admin.photos.create');

    Route::post('admin/photos',function(Request $request){
        $validate_data = $request->validate([
            'description'=>['required'],
            'path'=>['required']
        ]);
        $path = Storage::disk('public')->put('photos', $request->file('path'));
        $validate_data['path'] = '/storage/'.$path;
        $validate_data['user_id'] = $request->user()->id;
        Photo::create($validate_data);
        return to_route('admin.photos');
    })->name('admin.photos.store');

    Route::get('admin/photos/{id}/edit',function($id){
        return Inertia::render('Admin/EditPhoto',[
            'photo'=>Photo::find($id)
        ]);
    })->name('admin.photos.edit');


    Route::put('admin/photos/{photo}/update',function(Request $request, Photo $photo){
        $validate_data = $request->validate([
            'description'=>['required'],
        ]);
        if($request->hasFile('path')){
            $image = $request->validate([
                'path'=>['required','image']
            ]);  
            $oldImage = $photo->path;
            Storage::delete($oldImage);
            $path = Storage::disk('public')->put('photos', $request->file('path'));
            $validate_data['path'] = '/storage/'.$path;
        }
        $photo->update($validate_data);
        return to_route('admin.photos');
    })->name('admin.photos.update');

    Route::delete('admin/photos/{photo}/delete', function(Photo $photo){
        Storage::delete($photo->path);
        $photo->delete();
        return response()->json('ok');
    })->name('admin.photos.delete');

    Route::post('{user}/like/{photo}',function(User $user, Photo $photo){
        $pars = [
            'user_id'=>$user->id,
            'photo_id'=>$photo->id,
        ];
        $like = Like::where('user_id', $user->id)->where('photo_id', $photo->id)->first();

        if(!is_null($like) && !empty($like)){
            $like->likes = !$like->likes;
            $like->update();
            return response()->json('ok');
        }else{
            $pars['likes'] = true;
            Like::create($pars);
            return response()->json('ok');
        }
    })->name('user.like.toggle');

});
