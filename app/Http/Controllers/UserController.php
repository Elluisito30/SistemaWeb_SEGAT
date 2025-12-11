<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function showLogin(){
        return view('login');
    }


    public function verificalogin(Request $request){


    $data=request()->validate([
        'name'=>'required',
        'password'=>'required'
    ],


    [
        'name.required'=>'Ingrese Usuario',
        'password.required'=>'Ingrese contraseña',
    ]);        


    $name=$request->get('name');
     
    $query=User::where('name','=',$name)->get();
        if ($query->count()!=0)
        {
            $hashp=$query[0]->password;
            $password=$request->get('password');


            if (password_verify($password,$hashp))
            {
                return redirect()->route('home');
            }
            else
            {
                return back()->withErrors(['password'=>'Contraseña incorrecta'])
                ->withInput(request(['name','password']));
            }




        }
        else
        {
            return back()->withErrors(['name'=>'Usuario no válido'])
            ->withInput(request(['name']));
        }
}

}
