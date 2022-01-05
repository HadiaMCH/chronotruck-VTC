<?php

namespace App\Http\Controllers;

use App\Models\news;
use App\Models\User;
use App\Models\wilaya;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class authController extends Controller
{
    public function login(Request $request)
    {        
        $request->validate([
            'email'=>'string',
            'password'=>'string',
        ]);
        $email=$request->email;
        $password=$request->password;

        $user= User::where('email',$email)->where('password',$password)->first();
        if($user){
            $request->session()->put('id',$user->id);
            $request->session()->put('name',$user->name);
            $request->session()->put('familyname',$user->familyname);
            $request->session()->put('password',$user->password);
            
            return response()->json([
                'status_code' => 501,
                'message' => 'Login',
              ]);
        }
        else{
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
              ]);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('name');
        $request->session()->forget('id');
        $request->session()->forget('password');
        $request->session()->forget('familyname');

        return redirect()->route('acceuil');
    }

    public function register_show()
    {        
        $wilayas=wilaya::all();
        $statut_creation='before';
        return view('inscription',compact('wilayas','statut_creation'));
    }

    public function register(Request $request)
    {        
        $request->validate(['nom'=>'string',
            'prenom'=>'string',
            'phone'=>'string',
            'email'=>'string',
            'password'=>'string',
            'adresse'=>'string',
        ]);
        // client
        if (!$request->transporteur){
            User::create([
                'name'=>$request->nom,
                'familyname'=>$request->prenom,
                'email'=>$request->email,
                'password'=>$request->password,
                'address'=>$request->adresse,
                'phone'=>$request->phone,
            ]); 
        }
        else{
            $transporteur=1;
            $wilaya=json_encode($request->wilaya);
            if(!$request->certifie){ //transporteur non certifie
                User::create([
                    'name'=>$request->nom,
                    'familyname'=>$request->prenom,
                    'email'=>$request->email,
                    'password'=>$request->password,
                    'address'=>$request->adresse,
                    'phone'=>$request->phone,
                    'transporteur'=>$transporteur,
                    'wilaya'=>$wilaya,
                ]);
            }
            else{ //transporteur certifie
                $certifie=1;
                $demande= Storage::put('demandes',$request->demande);
                $dmd= Storage::url($demande);
                User::create([
                    'name'=>$request->nom,
                    'familyname'=>$request->prenom,
                    'email'=>$request->email,
                    'password'=>$request->password,
                    'address'=>$request->adresse,
                    'phone'=>$request->phone,
                    'transporteur'=>$transporteur,
                    'wilaya'=>$wilaya,
                    'certifie'=>$certifie,
                    'demande'=>$dmd,
                ]); 
            }
        } 
        $wilayas=wilaya::all();
        $statut_creation='after';
        return view('inscription',compact('wilayas','statut_creation'));
    }

}
