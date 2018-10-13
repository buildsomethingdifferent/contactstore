<?php

use Illuminate\Http\Request;
use App\Contact;

Route::group(['middleware'=>'api'], function (){
    //get contacts
    Route::get('contacts', function (){
         return Contact::orderBy('created_at', 'desc')->paginate(5);
    });
    //find contact
    Route::get('contact/{id}', function ($id){
        return Contact::findOrFail($id);
    });
    //CREATE CONTACT
    Route::post('contact/store', function (Request $request){
        return Contact::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone
            ]);
    });
    //update contact

    Route::patch('contact/{id}', function (Request $request ,$id){
          Contact::findOrFail($id)->update([
           'name'=>$request->name,
           'email'=>$request->email,
           'phone'=>$request->phone
       ]);

    });

    //delete contact

    Route::delete('contact/{id}', function ($id){
     return Contact::destroy($id);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
