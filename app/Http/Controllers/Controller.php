<?php
/**

@OA\Info(
version="1.0",
title="Example API",
description="Example info",
@OA\Contact(name="Swagger API Team")
)
*/

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="APIs SWAPI",
 *    version="1.0.0",
 * ),
 *   @OA\SecurityScheme(
 *       securityScheme="bearerAuth",
 *       in="header",
 *       name="bearerAuth",
 *       type="http",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *    ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
