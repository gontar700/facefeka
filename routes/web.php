<?php

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

use App\Post;

//Route::get('/', 'PostController@index');

Route::get('/show', 'PostController@show');

Route::get('/post/{id}', 'PostController@index');

Route::resource('posts', 'PostController');

Route::get(
    '/insert', function () {
    DB::insert('insert into posts(title, content) values (?,?)', ['a', 'b']);
});
/*
|--------------------------------------------------------------------------
| Eloquent
|--------------------------------------------------------------------------
*/

Route::get(
    '/read', function () {
    $results = DB::select('select * from posts where id = ?', [1]);
    foreach ($results as $result) {
//       echo $result->title.'<br>';
        print_r($result);
    }
});

Route::get(
    '/find', function () {

    $posts = Post::find(1)->get();
    foreach ($posts as $post) {
        echo $post->title;
    }
});

Route::get(
    '/findwhere', function () {
    $post = Post::where('id', 1)->orderBy('id', 'desc')->take(1)->get();
    return $post;


});

Route::get(
    '/findorfail', function () {
    $post = Post::findOrFail(1);
    return $post;
});
// insert
Route::get(
    '/basicinsert', function () {

    $post = new Post;

    $post->title = 'New Eloquent title insert';
    $post->content = 'Wow eloquent is really cool, look at this content';

    $post->save();
});

Route::get(
    '/basicinsert2', function () {

    $post = Post::find(1);

    print_r($post);

    $post->title = 'New Eloquent title insert';
    $post->content = 'Wow eloquent is really cool, look at this content';

    $post->save();
});

// model create methods with form

Route::get('/basicinsert3', function () {

    Post::create(['title' => 'title_test', 'content' => 'content_testB']);
    Post::create(['title' => 'title_test', 'content' => 'content_testC']);
});

Route::get('/update', function(){
    Post::where('id',3)->where('is_admin',0)->update(['title'=>'title_test']);
});

Route::get('/delete',function(){
    $post = Post::find(2);

    $post->delete();
});

Route::get('/delete2',function(){
    Post::destroy([4,5]);
});


Route::get('/softdelete',function(){
    Post::find(1)->delete();
});

Route::get('/readsoftdelete',function(){

    $post = Post::withTrashed()->where('id',1)->get();
    return $post;
});

Route::get('/readsoftdelete2',function(){


    $post = Post::onlyTrashed()->get();
    return $post;
});

Route::get('/restore',function(){

    Post::withTrashed()->restore();
});