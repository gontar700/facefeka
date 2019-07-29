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
use App\User;
use App\Role;
use App\Country;
use App\Photo;

//Route::get('/', 'PostController@index');

Route::get('/show', 'PostController@show');

Route::get('/post/{id}', 'PostController@index');

Route::resource('posts', 'PostController');

Route::get(
    '/insert', function () {
    DB::insert('insert into posts(title, content) values (?,?)', ['a', 'b']);
});

// autocompletesearch

Route::get('search', 'AutoCompleteController@index');

Route::get('autocomplete', 'AutoCompleteController@search');

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

Route::get(
    '/basicinsert3', function () {

    Post::create(['title' => 'title_test', 'content' => 'content_testB']);
    Post::create(['title' => 'title_test', 'content' => 'content_testC']);
});

Route::get(
    '/update', function () {
    Post::where('id', 3)->where('is_admin', 0)->update(['title' => 'title_test']);
});

// forcedelete deleted items
Route::get(
    '/forcedelete', function () {

    Post::onlyTrashed()->forceDelete();
});

Route::get(
    '/delete', function () {
    $post = Post::find(4);

    $post->delete();
});

// delete with destroy
Route::get(
    '/delete2', function () {
    Post::destroy([2]);
});

Route::get(
    '/delete3', function () {
    Post::destroy([1]);
});

Route::get(
    '/softdelete', function () {
    Post::find(1)->delete();
});

Route::get(
    '/readsoftdelete', function () {

    $post = Post::withTrashed()->where('id', 1)->get();
    return $post;
});

Route::get(
    '/readsoftdelete2', function () {

    $post = Post::onlyTrashed()->get();
    return $post;
});

Route::get(
    '/restore', function () {

    Post::withTrashed()->restore();
});


/*
|--------------------------------------------------------------------------
| Eloquent Relationships
|--------------------------------------------------------------------------
*/

//One To One relationship

Route::get(
    '/user/{id}/post', function ($id) {

    return User::find($id)->post->title;

});

/* Reverse. user will supply post id system returns user id*/
Route::get(
    'post/{id}/user', function ($id) {

    return Post::find($id)->user->name;
});

Route::get(
    '/posts', function () {
    $user = User::find(2);

    foreach ($user->posts as $post) {
        echo $post->title . '<br>';
    }
});

/* many to many user <-> roles */
Route::get(
    'roles/{id}/user', function ($id) {
    $user = User::find($id);

    foreach ($user->roles as $role) {
        echo $role->name . '<br>';
    }
});


/* many to many get all users by role */
Route::get(
    'users/{id}/role', function ($id) {
    $role = Role::find($id);

    foreach ($role->users as $user) {
        echo $user->name . '<br>';
    }
});

/* pivot */
Route::get(
    'pivot/user', function () {

    $user = User::find(1);

    foreach ($user->roles as $role) {
        return $role->pivot;
    }
});

/*country has many posts through user table*/
Route::get(
    'country/{id}/posts', function ($id) {
    $country = Country::find($id);

    foreach ($country->posts as $post) {
        echo $post->content . '<br>';
    }

});


//Polymorphic Relationships
// return all photos for specific user
Route::get('/user/{id}/photos', function ($id) {

    $user = User::find($id);

    foreach ($user->photos as $photo) {
        echo $photo->path . '<br>';
    }

});

// polymorphic return all photos for specific user
Route::get('/post/{id}/photos', function ($id) {

    $post = Post::find($id);

    foreach ($post->photos as $photo) {
        echo $photo->path . '<br>';
    }

});

Route::get('photo/{id}/owner', function ($id) {

    $photo = Photo::findOrFail($id);

    // return the photo creator the usr or the post
    return $photo->imageable;
});