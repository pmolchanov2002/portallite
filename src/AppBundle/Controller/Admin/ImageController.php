<?php

// src/AppBundle/Controller/MediaController.php
namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Media;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\MediaType;

class ImageController extends Controller
{

    private $displayRoute = 'app_image_display';

    /**
     * @Route("/admin/web/image/create")
     */
    public function create(Request $request)
    {
        $media = new Media();
        $form = $this->createFormBuilder($media)
            ->add('description', 'text', array('label' => 'Russian description:'))
            ->add('englishName', 'text', array('label' => 'English description:'))
            ->add('path', 'text', array('label' => 'URL:'))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $media = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $mediaType = $em->getRepository('AppBundle:MediaType')->findOneById(1);
            $media->setType($mediaType);
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/image.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/admin/web/image/upload")
     */
    public function upload(Request $request)
    {
    	$media = new Media();
    	$form = $this->createFormBuilder($media)
    	->add('description', 'text', array('label' => 'Russian description:'))
    	->add('englishName', 'text', array('label' => 'English description:'))
    	->add('path', 'file', array(
    			'label' => 'File:'
    	))
    	->add('save', 'submit', array('label' => 'Create'))
    	->getForm();
    
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		$media = $form->getData();
    		$file = $media->getPath();
    		print_r($file);
    		$fileName = md5(uniqid()).'.'.$file->guessExtension();
    		
    		$uploadPath = $this->getParameter("upload_path");
	   		$file->move($uploadPath, $fileName);
       		$uploadDir = $this->getParameter("upload_dir");
    		$media->setPath($uploadDir.'/'.$fileName);
    		
    		$em = $this->getDoctrine()->getManager();
    		$mediaType = $em->getRepository('AppBundle:MediaType')->findOneById(1);
    		$media->setType($mediaType);
    		$em->persist($media);
    		$em->flush();
    		return $this->redirectToRoute($this->displayRoute);
   		}
    
    	return $this->render('admin/form/image.html.twig', array(
   				'form' => $form->createView(),
    	));
    }

    /**
     * @Route("/admin/web/image/edit/{id}")
     * @ParamConverter("media", class="AppBundle:Media")     
     */
    public function edit($media, Request $request)
    {
        if(!isset($media)) {
            return new Response("Media not found");
        }
        $form = $this->createFormBuilder($media)
            ->add('description', 'text', array('label' => 'Russian description:'))
            ->add('englishName', 'text', array('label' => 'English description:'))
            ->add('path', 'text', array('label' => 'URL:'))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $media = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/image.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/image/delete/{id}")
     * @ParamConverter("media", class="AppBundle:Media")
     */
    public function delete($media)
    {
        if(!isset($media)) {
            return new Response("Media not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/image", name="app_image_display")
     */       
    public function display() {
        $medias = $this->getDoctrine()
        ->getRepository('AppBundle:Media')
        ->createQueryBuilder('m')
        ->join("m.type","t")
        ->where("t.id = 1")
        ->orderBy("m.id", "DESC")
        ->getQuery()
        ->getResult();
        return $this->render('admin/view/image.html.twig',  array('medias' => $medias));
    }
}