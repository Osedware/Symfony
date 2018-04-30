<?php
/**
 * Created by PhpStorm.
 * User: jmdiaz
 * Date: 4/24/2018
 * Time: 4:01 PM
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeportesController
{
    /**
     * @param $_idioma
     * @param $fecha
     * @param $seccion
     * @param $equipo
     * @param $pagina
     * @return Response
     * @Route("/deportes/{_idioma}/{fecha}/{seccion}/{equipo}/{pagina}",
     *     defaults={"slug":"1","formato":"html","pagina":"1"},
     *     requirements={
     *          "_idioma":"es|en",
     *          "_formato":"html|json|xml",
     *          "fecha":"[\d+]{8}",
     *          "pagina"="\d+"
     *     })
     */
    public function rutaAvanzadaListado($_idioma,$fecha,$seccion,$equipo,$pagina) {
        return new Response(sprintf(
            "Listado de noticias en idioma=%s,fecha=%s,deporte=%s,equipo=%s,pagina=%s",
            $_idioma, $fecha, $seccion, $equipo, $pagina
        ));
    }

    /**
     * @param $_idioma
     * @param $fecha
     * @param $seccion
     * @param $equipo
     * @param $slug
     * @return Response
     * @Route("/deportes/{_idioma}/{fecha}/{seccion}/{equipo}/{slug}.{_formato}",
     *     defaults={"slug":"1","_formato":"html"},
     *     requirements={
     *          "_idioma":"es|en",
     *          "_formato":"html|json|xml",
     *          "fecha":"[\d+]{8}"
     *     })
     */
    public function rutaAvanzada($_idioma,$fecha,$seccion,$equipo,$slug) {
        return new Response(sprintf(
            "Mi noticia en idioma=%s, fecha=%s, deporte=%s, equipo=%s, noticia=%s",
            $_idioma, $fecha, $seccion, $equipo, $slug
        ));
    }

    /**
     * @param $seccion
     * @param $pagina
     * @return Response
     * @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
     *     requirements={"pagina"="\d+"},
     *     defaults={"seccion":"tenis"})
     */
    public function lista($seccion,$pagina=1) {
        return new Response(sprintf(
            "Deportes seccion: seccion %s, listado de notcias página %s",
            $seccion, $pagina));
    }

    /**
     * @param $slug
     * @param $seccion
     * @return Response
     * @Route("/deportes/{seccion}/{slug}",
     *     defaults={"seccion":"tenis"})
     */
    public function noticia($slug, $seccion) {
        return new Response(sprintf(
            "Noticia de %s, con url dinámica=%s",
            $seccion, $slug
        ));
    }

    /**
     * @return Response
     * @Route("/deportes")
     */
    public function inicio() {
        return new Response("Mi página de deportes!");
    }

    /**
     * @param $slug
     * @return Response
     * @Route("/deportes/{slug}")
     */
    public function mostrar($slug) {
        return new Response(sprintf(
            "Mi articulo en mi pagina de deportes: Ruta %s",
            $slug));
    }


}