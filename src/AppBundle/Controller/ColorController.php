<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckType;

use AppBundle\Entity\Color;
use AppBundle\Form\ColorType;

class ColorController extends Controller
{
    /**
     * @Route("/catalogo/colores", name="colores_index")
     */
    public function indexAction(Request $request)
    {        

        $em = $this->getDoctrine()->getManager();

        $colores = $em->getRepository('AppBundle:Color')->findAll();

        return $this->render('color/index.html.twig', [        
            'colores' => $colores
         ]);
    }

    /**
     * @Route("/catalogo/colores/new", name="colores_new")
     */
    public function newAction(Request $request)
    {
    
        $color = new Color();

        $form = $this->createForm(ColorType::class, $color);    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $em = $this->getDoctrine()->getManager();
            $em->persist($color);        
            $em->flush(); 

            $this->addFlash(
                'notice',
                'Color agregado con éxito.'
            );

            return $this->redirectToRoute('colores_index');  

        }

    
        return $this->render('color/new.html.twig', [ 
            'form' => $form->createView() 
         ]);


    }


    /**
     * @Route("/catalogo/colores/{id}/edit", name="colores_edit")
     */
    public function editAction(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $color = $em->getRepository('AppBundle:Color')->find($id);

        $form = $this->createForm(ColorType::class, $color);    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $em = $this->getDoctrine()->getManager();
            $em->persist($color);        
            $em->flush(); 

            $this->addFlash(
                'notice',
                'Color actualizado con éxito.'
            );

            return $this->redirectToRoute('colores_index');  

        }


        return $this->render('color/edit.html.twig', [ 
            'form' => $form->createView() 
        ]);
    }








}


