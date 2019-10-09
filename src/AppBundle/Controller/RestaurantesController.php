<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Restaurante;
use AppBundle\Entity\Comida;


class RestaurantesController extends Controller
{
  /**
   * Matches /restaurantes exactly
   * 
   * @Route("/restaurantes", name="restaurantes")
   */

  public function restauranteAction(Request $request)
  {
    $repository = $this->getDoctrine()->getRepository(Restaurante::class);

    $restaurantes = $repository->findAll();

    dump($restaurantes);

    return $this->render('default/restaurantes.html.twig', ['restaurantes' => $restaurantes]);
  }

  /**
   * @Route("/restaurantes/new", name="addRestaurantes")
   * Method={"GET", "POST"}
   */

  public function newRestauranteAction(Request $request)
  {

    $restaurante = new Restaurante();

    $form = $this->createFormBuilder($restaurante)
      ->add('nombre', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('localidad', TextType::class, array(
        'required' => false,
        'attr' => array('class' => 'form-control')
      ))
      ->add('save', SubmitType::class, array(
        'label' => 'Create',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $restaurante = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($restaurante);
        $entityManager->flush();
        return $this->redirectToRoute('restaurantes');
      }


    return $this->render('default/new.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * Matches /restaurantes/*
   * but not /restaurantes/slug/extra-part
   *
   * @Route("/restaurantes/{sedes}", name="restaurantes_sedes")
   */

  public function restauranteSedeAction(Request $request, $sedes)
  {
    dump($sedes);
    return $this->render('default/'.$sedes.'.html.twig');
  }
}