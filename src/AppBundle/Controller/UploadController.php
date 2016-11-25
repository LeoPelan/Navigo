<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class UploadController extends Controller {

  /**
  * @Route("/upload", name="upload")
  * @Template("@Upload/upload.html.twig")
  */

public function uploadAction()
{
  //$this->container->get('twig.loader')->addPath('upload.html.twig', $namespace = '__main__');
    $document = new Document();
    $form = $this->createFormBuilder($document)
        ->add('name')
        ->add('file')
        ->getForm()
    ;
    $request = Request::createFromGlobals();
    if ($request->getMethod() == 'POST' ) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $document->upload();
            $em = $this->getDoctrine()->getManager();

            $em->persist($document);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }
    }

    return array('form' => $form->createView());
}
}
