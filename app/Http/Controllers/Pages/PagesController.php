<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{

    public function login()
    {

        return view('pages.login');

    }

    public function register()
    {

        return view('pages.register');

    }

    public function update()
    {

        return view('pages.update');

    }

    public function lists()
    {

        $data['pokemons'] = null;

        return view('pages.lists', $data);

    }

    public function view($name)
    {

        $data['name'] = $name;
        return view('pages.view', $data);

    }

    public function favorites()
    {

        return view('pages.favorites');

    }

}
