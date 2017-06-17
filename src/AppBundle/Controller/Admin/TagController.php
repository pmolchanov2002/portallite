<?php

// src/AppBundle/Controller/TagController.php
namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Tag;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\TagMediaRef;

class TagController extends Controller
{

    private $displayRoute = 'app_tag_display';

    /**
     * @Route("/admin/web/tag/create")
     */
    public function create(Request $request)
    {
        $tag = new Tag();
        $form = $this->createFormBuilder($tag)
            ->add('name', 'text', array('label' => 'Name:'))
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
            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/tag.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/tag/edit/{id}")
     * @ParamConverter("tag", class="AppBundle:Tag")     
     */
    public function edit($tag, Request $request)
    {
        if(!isset($tag)) {
            return new Response("Tag not found");
        }
        $form = $this->createFormBuilder($tag)
            ->add('name', 'text', array('label' => 'Tag:'))
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
            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
           
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/tag.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/tag/delete/{tag}")
     * @ParamConverter("tag", class="AppBundle:Tag")
     */
    public function delete($tag)
    {
        if(!isset($tag)) {
            return new Response("Tag not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }
    
     /**
     * @Route("/admin/web/tag", name="app_tag_display")
     */       
    public function display() {
        $tags = $this->getDoctrine()
        ->getRepository('AppBundle:Tag')
        ->findAll();
        return $this->render('admin/view/tag.html.twig',  array('tags' => $tags));
    }
}