<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeliveryController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {        

        $em = $this->getDoctrine()->getManager();

        //todos los registros y me retorna un array
        $colores = $em->getRepository('AppBundle:Color')->findAll();        

          //devuelve un objeto Color con id = 1
//          $color = $em->getRepository('AppBundle:Color')->find(1);

//         $color = $em->getRepository('AppBundle:Color')->findOneByDescripcion('Azul');

          //array
         /* $color = $em->getRepository('AppBundle:Color')->findBy([
            'descripcion' => 'Azul',
            'fecha' => $fecha
          ]);*/



        

        $cervezas = ['Quilmes', 'Palermo', 'Corona'];

        return $this->render('delivery/index.html.twig', [ 
            'cervezas' => $cervezas,
            'colores' => $colores
         ]);
    }

    /**
     * @Route("/catalogo", name="homepage_catalogo")
     */
    public function catalogoAction(Request $request)
    {
        return $this->render('delivery/catalogo.html.twig', [ ]);
    }


}


