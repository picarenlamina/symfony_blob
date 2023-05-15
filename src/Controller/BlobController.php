<?php
// src/Controller/ImagenController.php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// tipos form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

// clase
use App\Entity\Imagen;
// form
use App\Form\ImagenType;


// Constraints
use Symfony\Component\Validator\Constraints\Currency;


/**
 * @Route("/blob")
 */
class BlobController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function upload( Request $request)
    {
       
        $imagen = new Imagen();
        $form = $this->createForm(ImagenType::class, $imagen );
       
        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = fopen($imagen->getBlob(),'rb');
            $imagen->setBlob( stream_get_contents($file));
            $em->persist($imagen);
            $em->flush();
         
            return new Response( "Registro salvado");
        }
        else
            return $this->render('imagen/form.html.twig', array('form' => $form->createView(),));
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show( $id, Request $request)
    {
       
        $imagen =  $this->getDoctrine()->getRepository(Imagen::class)->findOneById( $id );
        // source: https://stackoverflow.com/questions/28294077/display-image-stored-in-blob-database-in-symfony
        $blob = base64_encode(stream_get_contents($imagen->getBlob()));
        return $this->render('imagen/show.html.twig', ["imagen" => $imagen, "blob" => $blob ]);
            
    }

   
    
    
    
}
