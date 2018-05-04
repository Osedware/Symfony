<?php
/**
 * Created by PhpStorm.
 * User: jmdiaz
 * Date: 4/24/2018
 * Time: 4:01 PM
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Noticia;

class DeportesController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/deportes/eliminar", name="eliminarNoticia")
     */
    public function eliminarBd(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get("id");
        $noticia = $em->getRepository(Noticia::class)->find($id);
        $em->remove($noticia);
        $em->flush();

        return new Response("Noticia eliminada!");
    }

    /**
     * @param int $pagina
     * @param $seccion
     * @return Response
     * @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
     *     requirements={"pagina"="\d+"},
     *     defaults={"seccion":"tenis"})
     */
    public function lista($pagina = 1, $seccion) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Noticia::class);

        // Buscamos las noticais de una seccion
        $noticiaSec = $repository->findOneBy(['seccion' => $seccion]);

        // Si la sección no existe saltará una excepción
        if (!$noticiaSec) {
            throw $this->createNotFoundException("Error 404 este deporte no está en nuestra base de datos");
        }

        // Almacenamos todas las noticias de una sección en una lista
        $noticias = $repository->findBy(["seccion"=>$seccion]);

        return new Response("Hay un total de ".count($noticias)." noticias de la sección de ".$seccion);
    }

    /**
     * @return Response
     * @Route("/deportes/insertaNoticias", name="insertaNoticias")
     */
    public function insertaNoticias() {
        for ($numNoticia = 1; $numNoticia < 5; $numNoticia++) {
            $em = $this->getDoctrine()->getManager();

            $noticia = new Noticia();
            $noticia->setSeccion("Tenis");
            $noticia->setEquipo("roger-federer");
            $noticia->setFecha("16022018");

            $noticia->setTextoTitular("Noticia Insertada número ".$numNoticia);
            $noticia->setTextoNoticia("Este es el texto de la noticia ".$numNoticia);

            $noticia->setImagen("federer.jpg");

            $em->persist($noticia);
            $em->flush();
        }

        return new Response("Noticias insertadas");
    }
    
    /**
     * @param Request $request
     * @return Response
     * @Route("/deportes/actualizarbd", name="actualizarNoticia")
     */
    public function actualizarBd(Request $request) {
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get("id");
        $noticia = $em->getRepository(Noticia::class)->find($id);

        $noticia->setTextoTitular("Roger-Federer-a-una-victoria-del-numero-uno-de-Nadal");
        $noticia->setTextoNoticia("El suizo Roger Federer, el tenista más laureado de la historia,
        está a son un paso de regresar a la cima del tenis mundial a sus 36 años. Clasificado sin admitir ni
        réplica para cuartos de final del torneo de Rotterdam, si vence este viernes a Robin Haasse se convertirá
        en el número uno del mundo...");
        $noticia->setImagen("federer.jpg");
        $em->flush();

        return new Response("Noticia actualizada");
    }

    /**
     * @return Response
     * @Route("/deportes/cargarbd", name="noticia")
     */
    public function cargarBd() {
        $em = $this->getDoctrine()->getManager();

        $noticia = new Noticia();
        $noticia->setSeccion("Tenis");
        $noticia->setEquipo("roger-federer");
        $noticia->setFecha("16022018");

        $noticia->setTextoTitular("Roger-Dedere-a-una-victoria-del-número-uno-de-Nadal");
        $noticia->setTextoNoticia("El suizo Roger Federer, el tenista más laureado de la historia,
        está a son un paso de regresar a la cima del tenis mundial  sus 36 años. Clasificado sin adminitr ni
        réplica para cuartos de final del torneo de Rotterdam, si vence este viernes a Robin Haase se convertirá
        en el número uno del mundo...");

        $noticia->setImagen("federer.jpg");

        $em->persist($noticia);
        $em->flush();

        return new Response("Noticia guardada con éxito con id:" .$noticia->getId());
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/deportes/usuario", name="usuario")
     */
    public function sesionUsuario(Request $request) {
        $usuario_get = $request->query->get("nombre");
        $sesion = $request->getSession();
        $sesion->set("nombre", $usuario_get);
        return $this->redirectToRoute("usuario_session", array("nombre"=>$usuario_get));
    }

    /**
     * @return Response
     * @Route("/deportes/usuario/{nombre}", name="usuario_session")
     */
    public function paginaUsuario() {
        $session= new Session();
        $usuario = $session->get("nombre");
        return new Response(sprintf(
            "Sesión iniciada con el atributo nombre: %s",
            $usuario
        ));
    }

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
        // Simulamos una base de datos de equipos o personas
        $deportes=["valencia", "barcelona", "federer", "rafa-nadal"];

        // Si el equipo o persona que buscamos no se encuentra redirigimos al usuario a la pagina de inicio
        if (!in_array($equipo, $deportes)) {
            return $this->redirectToRoute("inicio");
        }
        return new Response(sprintf(
            "Mi noticia en idioma=%s, fecha=%s, deporte=%s, equipo=%s, noticia=%s",
            $_idioma, $fecha, $seccion, $equipo, $slug
        ));
    }

//    /**
//     * @param $seccion
//     * @param $pagina
//     * @return Response
//     * @Route("/deportes/{seccion}/{pagina}", name="lista_paginas",
//     *     requirements={"pagina"="\d+"},
//     *     defaults={"seccion":"tenis"})
//     */
//    public function lista($seccion, $pagina) {
//        // Simulamos una base de datos de deportes
//        $deportes=["futbol", "tenis","rugby"];
//        //Si el deporte que buscamos no se encuentra lanzamos la excepcion 404 deporte no encontrado
//        if (!in_array($seccion, $deportes)) {
//            throw $this->createNotFoundException("Error 404 este deporte no está en nuestra Base de Datos");
//        }
//        return new Response(sprintf(
//            "Deportes seccion: seccion %s, listado de notcias página %s",
//            $seccion, $pagina));
//    }

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
     * @Route("/deportes", name="inicio")
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