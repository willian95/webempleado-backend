<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserSiintra;

class LoginController extends Controller
{
    
	function login(Request $request){

		$user = UserSiintra::where('login', $request->cedula)->first();
		
		if($user){

			if($user->baneado == 1){
				return redirect()->back()->with(['error' => true, 'message' => 'Lo sentimos, su usuario ha sido bloqueado, contacte al administrador del sistema']);
			}

			if($user->intentos_fallidos < 5){

				if($user->password == sha1($request->clave)){


					Auth::loginUsingId($user->id_usuario);
					if(Auth::user()->tipo_usuario == 'S'){
						return redirect()->to('/admin/dashboard');
					}else{
						return redirect()->back()->with(['error' => true, 'message' => 'Lo sentimos, estamos trabajando en el módulo de usuarios']);
					}

				}else{


					$user = UserSiintra::where('cedula_usuario', $request->cedula)->first();
					$user->intentos_fallidos = $user->intentos_fallidos + 1;
					$user->timestamps = false;

					if($user->intentos_fallidos == 5){
						$user->baneado = 1;
					}

					$user->save();

					return redirect()->back()->with(['error' => true, 'message' => 'Usuario no encontrado']);

				}

			}


		}else{

			return redirect()->back()->with(['error' => true, 'message' => 'Usuario no encontrado']);
		}

	}

	function loginAPI(Request $request){

		$user = UserSiintra::where('login', $request->cedula)->first();
		
		if($user){

			if($user->baneado == 1){
				return response()->json(['error' => true, 'message' => 'Lo sentimos, su usuario ha sido bloqueado, contacte al administrador del sistema']);
			}

			if($user->intentos_fallidos < 5){

				if($user->password == sha1($request->clave)){

					Auth::loginUsingId($user->id_usuario);

					return response()->json(['error' => false, 'redirect' => true]);


				}else{

					$user = UserSiintra::where('cedula_usuario', $request->cedula)->first();

					if($user){
						$user->intentos_fallidos = $user->intentos_fallidos + 1;
						$user->timestamps = false;

						if($user->intentos_fallidos == 5){
							$user->baneado = 1;
						}

						$user->save();
					}
					

					return response()->json(['error' => true, 'message' => 'Usuario no encontrado']);

				}

			}

		}else{
			return response()->json(['error' => true, 'message' => 'Usuario no encontrado']);
		}

	}

	function logout(){

		Auth::logout();
		return redirect()->to('/');

	}

}
