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

class DocumentController extends Controller
{

    private $displayRoute = 'app_doc_display';

    /**
     * @Route("/admin/web/doc/create")
     */
    public function create(Request $request)
    {
        $media = new Media();
        $form = $this->createFormBuilder($media)
            ->add('description', 'text', array('label' => 'Description:'))
            ->add('englishName', 'text', array('label' => 'English:'))
            ->add('path', 'text', array('label' => 'URL:'))
            ->add('type', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:MediaType',
            		'choice_label' => 'name',
            		'label' => 'Type: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('t')
            		->where('t.id = 2')
            		->orWhere('t.id = 3')
            		->orWhere('t.id = 4')
            		->orderBy('t.id','DESC');
            		}))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $media = $form->getData();
            $media->setPath(str_replace("//www.youtube.com/watch?v=","//www.youtube.com/embed/",$media->getPath()));
            $media->setPath(str_replace("//youtu.be","//www.youtube.com/embed",$media->getPath()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/doc.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/admin/web/doc/upload")
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
    	->add('type', 'entity', array(
    			'multiple' => false,
    			'class' => 'AppBundle:MediaType',
    			'choice_label' => 'name',
    			'label' => 'Type: ',
    			'query_builder' => function (EntityRepository $er) {
    			return $er->createQueryBuilder('t')
    			->where('t.id = 2')
    			->orWhere('t.id = 3')
    			->orWhere('t.id = 4')
    			->orderBy('t.id','DESC');
    			}))
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
    		$em->persist($media);
    		$em->flush();
    		return $this->redirectToRoute($this->displayRoute);
   		}
    
    	return $this->render('admin/form/doc.html.twig', array(
   				'form' => $form->createView(),
    	));
    }

    /**
     * @Route("/admin/web/doc/edit/{id}")
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
            ->add('type', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:MediaType',
            		'choice_label' => 'name',
            		'label' => 'Type: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('t')
            		->where('t.id = 2')
            		->orWhere('t.id = 3')
            		->orWhere('t.id = 4')
            		->orderBy('t.id','DESC');
           			}))
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

        return $this->render('admin/form/doc.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/doc/delete/{id}")
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
     * @Route("/admin/web/doc", name="app_doc_display")
     */       
    public function display() {
        $medias = $this->getDoctrine()
        ->getRepository('AppBundle:Media')
        ->createQueryBuilder('m')
        ->join("m.type","t")
        ->where("t.id = 2")
        ->orWhere("t.id = 3")
        ->orWhere("t.id = 4")
        ->orderBy("m.id", "DESC")
        ->getQuery()
        ->getResult();
        return $this->render('admin/view/doc.html.twig',  array('medias' => $medias));
    }
}