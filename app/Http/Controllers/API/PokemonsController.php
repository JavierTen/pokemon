<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonsController extends Controller
{

    function list(Request $request) {
        try {

            $response = Http::get('https://pokeapi.co/api/v2/pokemon');

            $pokemons = $response->json();

            return response()->json($this->generate_response(
                array(
                    "message" => "Authenticated successfully",
                    "data" => $pokemons['results'],
                ),
                'SUCCESS'
            ));
        } catch (Exception $e) {
            return response()->json($this->generate_response(
                array(
                    "message" => $e->getMessage(),
                    "status_code" => $e->getCode(),
                )
            ));
        }
    }

    public function view(Request $request, $id)
    {
        try {

            $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $id);

            $pokemon = $response->json();

            return response()->json($this->generate_response(
                array(
                    "message" => "Pokemon successfully",
                    "data" => $pokemon,
                ),
                'SUCCESS'
            ));
        } catch (Exception $e) {
            return response()->json($this->generate_response(
                array(
                    "message" => $e->getMessage(),
                    "status_code" => $e->getCode(),
                )
            ));
        }
    }

    public function favorite(Request $request)
    {
        try {

            $user = User::where('id', $request->id)->first();

            $favorite = new Favorite();
            $favorite->ref_api = $request->ref;
            $favorite->id_usuario = $user->id;
            $favorite->save();

            return response()->json($this->generate_response(
                array(
                    "message" => "Update successfully",
                    "data" => $favorite,
                ),
                'SUCCESS'
            ));
        } catch (Exception $e) {
            return response()->json($this->generate_response(
                array(
                    "message" => $e->getMessage(),
                    "status_code" => $e->getCode(),
                )
            ));
        }
    }
}
