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

class AudioController extends Controller
{

    private $displayRoute = 'app_audio_display';

    /**
     * @Route("/admin/web/audio/create")
     */
    public function create(Request $request)
    {
        $media = new Media();
        $form = $this->createFormBuilder($media)
            ->add('description', 'text', array('label' => 'Description:'))
            ->add('englishName', 'text', array('label' => 'English:'))
            ->add('path', 'text', array('label' => 'URL:'))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $media = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $mediaType = $em->getRepository('AppBundle:MediaType')->findOneById(6);
            $media->setType($mediaType);
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/audio.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/admin/web/audio/upload")
     */
    public function upload(Request $request)
    {
    	$media = new Media();
    	$form = $this->createFormBuilder($media)
    	->add('description', 'text', array('label' => 'Description:'))
    	->add('englishName', 'text', array('label' => 'English:'))
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
    		
    		//$uploadDir = $this->container->getParameter('kernel.root_dir').'/../../public_html/test2/uploads';
    		$uploadDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
    		$file->move($uploadDir, $fileName);
    		
    		//$media->setPath($request->getSchemeAndHttpHost()."/uploads/".$fileName);
    		$media->setPath("/uploads/".$fileName);
    		
    		$em = $this->getDoctrine()->getManager();
    		$mediaType = $em->getRepository('AppBundle:MediaType')->findOneById(6);
    		$media->setType($mediaType);
    		$em->persist($media);
    		$em->flush();
    		return $this->redirectToRoute($this->displayRoute);
   		}
    
    	return $this->render('admin/form/audio.html.twig', array(
   				'form' => $form->createView(),
    	));
    }

    /**
     * @Route("/admin/web/audio/edit/{id}")
     * @ParamConverter("media", class="AppBundle:Media")     
     */
    public function edit($media, Request $request)
    {
        if(!isset($media)) {
            return new Response("Media not found");
        }
        $form = $this->createFormBuilder($media)
            ->add('description', 'text', array('label' => 'Description:'))
            ->add('englishName', 'text', array('label' => 'English:'))
            ->add('path', 'text', array('label' => 'URL:'))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $media = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $mediaType = $em->getRepository('AppBundle:MediaType')->findOneById(6);
            $media->setType($mediaType);
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/audio.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/audio/delete/{id}")
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
     * @Route("/admin/web/audio", name="app_audio_display")
     */       
    public function display() {
        $medias = $this->getDoctrine()
        ->getRepository('AppBundle:Media')
        ->createQueryBuilder('m')
        ->join("m.type","t")
        ->where("t.id = 6")
        ->orderBy("m.id", "DESC")
        ->getQuery()
        ->getResult();
        return $this->render('admin/view/audio.html.twig',  array('medias' => $medias));
    }
}