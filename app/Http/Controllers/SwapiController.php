<?php

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Documentation de l'API SWAPI",
 *      description="API pour interagir avec SWAPI (Star Wars API)",
 *      @OA\Contact(
 *          email="contact@example.com"
 *      )
 * )
 */

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use GuzzleHttp\Client;
use OpenApi\Annotations as OA;


class SwapiController extends Controller
{
/**
 * @OA\Get(
 *     path="/films",
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function getFilms()
    {
        $client = new Client();
        try {
            $response = $client->request('GET', 'https://swapi.dev/api/films/');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des films'], 500);
        }
        return response()->json(json_decode($response->getBody()));
    }
}

