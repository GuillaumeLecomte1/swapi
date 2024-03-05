<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="APIs SWAPI",
 *    version="1.0.0",
 *    description="Cet API Rest permet de gérer les données de l'API SWAPI (Star Wars API). Il permet de gérer les films, les personnages, les planètes, les espèces, les vaisseaux spatiaux et les véhicules. Il permet également de gérer les utilisateurs (inscription, connexion, déconnexion).",
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
