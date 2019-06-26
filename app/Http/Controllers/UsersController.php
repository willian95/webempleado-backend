<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\UserSiintra as User;

class UsersController extends Controller
{

	function index(){

		return view('users');

	}

	function getUsers(){

		return Datatables::of(User::query())
				->editColumn('tipo_usuario', function ($user) {
				    if ($user->tipo_usuario == 'S') return 'Administrador';
				    if ($user->tipo_usuario == 'N') return 'Usuario';
				    return 'Cancel';
				})
				->editColumn('baneado', function ($user) {
				    if ($user->baneado == '1') return 'Sí';
				    if ($user->baneado == '0') return 'No';
				    return 'Cancel';
				})
				->make(true);

	}

}
