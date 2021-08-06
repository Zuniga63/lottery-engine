<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::all('id', 'name', 'email');
    return Inertia::render('Users/Index', compact('users'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|min:3|max:45',
      'email' => 'required|string|email|max:100|unique:users,email',
      'password' => ['required', 'confirmed', Password::min(8)]
    ]);

    $input = $request->all();
    User::create([
      'name' => $input['name'],
      'email' => $input['email'],
      'password' => Hash::make($input['password'])
    ]);

    return Redirect::route('users.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Integer  $userId
   * @return \Illuminate\Http\Response
   */
  public function destroy(int $userId)
  {
    $error = null;
    $success = null;
    //Se recupera el usuario
    $user = User::find($userId, ['id', 'name']);
    if($user){
      $message = "El usuario \"" . $user->name . "\" fue eliminado";
      $user->delete();

      $success = $message;
    }else{
      $error = "¡Usuario no Encontrado";
    }

    return Redirect::route('users.index')->with([
      'success' => $success,
      'error' => $error
    ]);    
  }
}
