<?php

// src/AppBundle/Controller/BannerController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Banner;

use Doctrine\ORM\EntityRepository;

class BannerController extends Controller
{

    private $displayRoute = 'app_banner_display';

    /**
     * @Route("/admin/web/banner/create")
     */
    public function create(Request $request)
    {
        $banner = new Banner();
        $form = $this->createFormBuilder($banner)
            ->add('name', 'text', array('label' => 'Title:'))
            ->add('description', 'text', array('label' => 'Sub title:'))
            ->add('media', 'entity', array(
                'multiple' => true,
                'expanded' => true,
                'class' => 'AppBundle:Media',
                'choice_label' => 'description',
                'label' => 'Images/Video: ',
            	'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('m')
            		->orderBy('m.id','DESC');
            	}
            ))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $banner = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($banner);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('forms/banner.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/banner/edit/{id}")
     * @ParamConverter("banner", class="AppBundle:Banner")     
     */
    public function edit($banner, Request $request)
    {
        if(!isset($banner)) {
            return new Response("Banner not found");
        }
        $form = $this->createFormBuilder($banner)
            ->add('name', 'text', array('label' => 'Title:'))
            ->add('description', 'text', array('label' => 'Sub title:'))
            ->add('media', 'entity', array(
                'multiple' => true,
                'expanded' => true,
                'class' => 'AppBundle:Media',
                'choice_label' => 'description',
                'label' => 'Images/Video: ',
                	'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('m')
            		->orderBy('m.id','DESC');
            	}
            ))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $banner = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($banner);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('forms/banner.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/banner/delete/{id}")
     * @ParamConverter("banner", class="AppBundle:Banner")
     */
    public function delete($banner)
    {
        if(!isset($banner)) {
            return new Response("Banner not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($banner);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/banner")
     */       
    public function display() {
        $banners = $this->getDoctrine()
        ->getRepository('AppBundle:Banner')
        ->findAll();
        return $this->render('views/banner.html.twig',  array('banners' => $banners));
    }
}