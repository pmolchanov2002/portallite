<?php

// src/AppBundle/Controller/ArticleController.php
namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Faq;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\OrderBy;

class FaqController extends Controller
{

    private $displayRoute = 'app_faq_display';

    /**
     * @Route("/admin/web/faq/create")
     */
    public function create(Request $request)
    {
        $faq = new Faq();
        $form = $this->createFormBuilder($faq)
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('content', 'markdown', array('label' => 'Body:'))
            ->add('ordinal', 'text', array('label' => 'Ordinal:'))
            ->add('pages', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Page',
            		'required' => false,
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $faq = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/faq.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/faq/edit/{id}")
     * @ParamConverter("faq", class="AppBundle:Faq")     
     */
    public function edit($faq, Request $request)
    {
        if(!isset($faq)) {
            return new Response("Article not found");
        }
        $form = $this->createFormBuilder($faq)
           ->add('title', 'text', array('label' => 'Title:'))
           ->add('content', 'markdown', array('label' => 'Body:'))
           ->add('ordinal', 'text', array('label' => 'Ordinal:'))
           ->add('pages', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Page',
            		'required' => false,
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $faq = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/faq.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/faq/delete/{id}")
     * @ParamConverter("faq", class="AppBundle:Faq")
     */
    public function delete($faq)
    {
        if(!isset($faq)) {
            return new Response("Article not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($faq);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/faq")
     */       
    public function display() {
        $faqs = $this->getDoctrine()
        ->getRepository('AppBundle:Faq')
    	->createQueryBuilder('a')
    	->orderBy('a.ordinal', 'DESC')
    	->getQuery()->execute();
        return $this->render('admin/view/faq.html.twig',  array('faqs' => $faqs));
    }
}