<?php
/**
 * Created by PhpStorm.
 * User: jmdiaz
 * Date: 4/24/2018
 * Time: 4:01 PM
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeportesController
{
    public function inicio() {
        return new Response("Mi primera pagina en Symfony!");
    }
}