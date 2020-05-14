<?php

namespace App\Http\Controllers;

use Validator;
use App\Model\User;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\MailWelcomeMessageToUser;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
      $user = New User;
      $value = $request->all();

        $rules = [
            'email' => 'required'
        ];

        $validator = Validator::make($value, $rules,[

          ]);

          if($validator->fails()){
            Flashy::error("Il y a une erreur dans la création du client");
            return Redirect::back()
              ->withErrors($validator)
              ->withInput();
          } else{
            $user->email = $request['email'];
            $user->password = Hash::make('nyleo');
            $user->role = 'client';
            $user->save();
            //Send mail to new client
            $this->dispatch(new MailWelcomeMessageToUser($user));
            Flashy::success("Le client a été créé avec succès!");
            return Redirect::back();
          }
    }

      public function changePassword(Request $request)
    {
      $user = Auth::user();
      $step = 0;
      $value = $request->all();

        $rules = [
            'password' => ['confirmed'],
        ];

        $validator = Validator::make($value, $rules,[
            'password.confirmed' => 'Les mots de passes ne sont pas identiques',

          ]);

          if($validator->fails()){
            Flashy::error("Un problème est survenu...");
            return Redirect::back()
              ->withErrors($validator)
              ->withInput();
          } else{
            $user->password = Hash::make($request['password']);
            $user->custom_password = true;
            if($user->save()){
              Flashy::success("Mot de passe modifié");
              return view('client.dashboard', compact('step'));
            }
            Flashy::error("Un problème est survenu...");
            return Redirect::back();
          }
    }

    public function clientEdit()
    {
      $user = Auth::user();
      $step = $user->step;
      return view('client.client-form', compact('user', 'step'));
    }

    public function clientUpdate(Request $request, $user)
    {

      $user = User::find($user);
      $value = $request->all();
      $rules = [
            'lastname' => 'required',
            'firstname' => 'required',
            'birth' => 'required',
            'birthplace' => 'required',
            'address' => 'required',
            'town' => 'required',
            'cp' => 'required | numeric',
            'email' => 'required | email',
            'phone' => 'required'
        ];

        $validator = Validator::make($value, $rules,[

          ]);

          if($validator->fails()){
            Flashy::error("Il y a une erreur dans le formulaire");
            return Redirect::back()
              ->withErrors($validator)
              ->withInput();
            } else{
              $user->email = $request['email'];
              $user->lastname = $request->lastname;
              $user->firstname = $request->firstname;
              $user->birth = $request->birth;
              $user->birthplace = $request->birthplace;
              $user->address = $request->address;
              $user->town = $request->town;
              $user->cp = $request->cp;
              $user->email = $request->email;
              $user->phone = $request->phone;

              if($user->save()){
                if ($user->step < 1){
                  $user->step = 1;
                }
                $user->save();
                //Send mail to new client
                $this->dispatch(new MailWelcomeMessageToUser($user));
                Flashy::success("Vous avez mis à jour vos coordonnées avec succès");
                return Redirect::back();
              };
            Flashy::error("Il y a une erreur dans le formulaire!");
            return Redirect::back();

          }

    }
}
