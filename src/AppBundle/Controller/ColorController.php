<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

//Fields types usados por el createFormBuilder
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Color;
use AppBundle\Form\ColorType;

class ColorController extends Controller
{
    /**
     * @Route("/catalogo/colores", name="colores_index")
     */
    public function indexAction(Request $request)
    {        

        //Invoca al EntityManager 
        $em = $this->getDoctrine()->getManager();

        //A traves del Repository pide a la base todos los registro de la table "color" (Entidad Color)
        //Los datos los retorna como array de objetos
        $colores = $em->getRepository('AppBundle:Color')->findAll();


        /*
        Otros métodos válidos para obtener datos de las tablas
          findAll(): Obtiene todos los registros de la tabla y retorna un Array
          find($id): Obtiene un registro a partir de la clave primaria ($id) de la tabla
          findBy($array): Obtiene los registros de la tabla que cumplan con los argumentos pasados como parámetros. Los parametros irían en el WHERE. Retorna un Array
          findOneBy($array): obtiene un registro pudiendo pasar como parámetros un array que irían en el Where.
         */

        //ejemplos

        //$color = $em->getRepository('AppBundle:Color')->find(3);
        //Obtiene el registro de la tabla con id = 3        

        //$colorres = $em->getRepository('AppBundle:Color')->findBy(['descripcion' => "Rojo", 'activo' => true]);
        //Obtiene todos los colores cuya descripcion = "Rojo" AND activo = true


        //Retorna una Respuesta, con la página index (View) a la cual le pasa por parámetros todos los colores obtenidos desde la DB
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

        //crear un formulario en el controlador
        /*      
        $form = $this->createFormBuilder($color)
            ->add('descripcion', TextType::class)
            ->add('fecha', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Grabar'))
            ->getForm();
        */

        //Prepara el formulario definido como clase en AppBundle\Form\ColorType.php
        $form = $this->createForm(ColorType::class, $color);    
        $form->handleRequest($request);

        //Verifica si el formulario fue enviado ("submiteado") y además si es válido
        if ($form->isSubmitted() && $form->isValid()) {            
            //Persiste (grbaba) los datos en la DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($color);        
            $em->flush(); 

            //Crea un mensaje de session Flash que se mostrará en la página.
            $this->addFlash(
                'notice',
                'Color agregado con éxito.'
            );

            //Nos redirije a la página cuya ruta tiene el nombre 'colores_index'
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

        //Obtiene el color de tabla con id = $id
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
