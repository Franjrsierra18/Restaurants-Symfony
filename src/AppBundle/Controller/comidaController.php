<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Restaurante;
use AppBundle\Entity\Comida;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class comidaController extends Controller
{
  /**
   * Matches /restaurantes exactly
   * 
   * @Route("/addComida", name="addComida")
   * Method={"GET", "POST"}
   */

  public function newComidaAction(Request $request)
  {
      $comida = new Comida();
      $restaurante = $this->getDoctrine()->getRepository(Restaurante::class)->findAll();

      $form = $this->createFormBuilder($comida)
      ->add('nombre', TextType::class, array('attr' => array('class' => 'form-control')))
      ->add('descripcion', TextType::class, array(
        'required' => false,
        'attr' => array('class' => 'form-control')
      ))
      ->add('restaurante', ChoiceType::class, [
        'choices'  => [
            'Restaurantes' => $restaurante
        ],
    ])
      ->add('save', SubmitType::class, array(
        'label' => 'Create',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();

      $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $comida = $form->getData();
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($comida);
      $entityManager->flush();
      return $this->redirectToRoute('restaurantes');
    }


    return $this->render('default/newComida.html.twig', [
      'form' => $form->createView(),
    ]);

    // $repository = $this->getDoctrine()->getRepository(Restaurante::class);
    // $restaurantes = $repository->find(1);

    // $comida1 = new Comida();
    // $comida1->setNombre('carne');
    // $comida1->setDescripcion('carne con papas');
    // $comida1->setRestaurante($restaurantes);

    // $entityManager = $this->getDoctrine()->getManager();
    // $entityManager->persist($comida1);
    // $entityManager->flush();

    // return new Response('<html><head><body>Agregado</body></head></html>');
  }
}
