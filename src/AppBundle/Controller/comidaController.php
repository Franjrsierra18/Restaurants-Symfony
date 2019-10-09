<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Restaurante;
use AppBundle\Entity\Comida;


class comidaController extends Controller
{
  /**
   * Matches /restaurantes exactly
   * 
   * @Route("/nuevo", name="nuevo")
   */

  public function restauranteAction(Request $request)
  {
    $repository = $this->getDoctrine()->getRepository(Restaurante::class);
    $restaurantes = $repository->find(1);

    $comida1 = new Comida();
    $comida1->setNombre('carne');
    $comida1->setDescripcion('carne con papas');
    $comida1->setRestaurante($restaurantes);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($comida1);
    $entityManager->flush();

    return new Response('<html><head><body>Agregado</body></head></html>');
  }
}
