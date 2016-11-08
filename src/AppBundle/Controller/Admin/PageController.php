<?php

// src/AppBundle/Controller/PageController.php
namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Page;

use Doctrine\ORM\EntityRepository;

class PageController extends Controller
{

    private $displayRoute = 'app_page_display';

    /**
     * @Route("/admin/web/page/create")
     */
    public function create(Request $request)
    {
        $page = new Page();
        $form = $this->createFormBuilder($page)
        	->add('id', 'text', array('label' => 'Name (id):'))
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('subTitle', 'text', array('label' => 'Sub title:', 'required' => false))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('type', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:PageType',
            		'choice_label' => 'name',
            		'label' => 'Type: ',
            		'query_builder' => function (EntityRepository $er) {
	            		return $er->createQueryBuilder('a')
	            		->orderBy('a.name','ASC');
            		}
            ))
            ->add('articlesPerPage', 'integer', array('label' => '# max articles:'))
            ->add('banner', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Banner',
            		'choice_label' => 'name',
            		'required' => false,
            		'label' => 'Banner: '))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $page = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/page.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/page/edit/{id}")
     * @ParamConverter("page", class="AppBundle:Page")     
     */
    public function edit($page, Request $request)
    {
        if(!isset($page)) {
            return new Response("Page not found");
        }
        $form = $this->createFormBuilder($page)
        	->add('id', 'text', array('label' => 'Name (id):'))
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('subTitle', 'text', array('label' => 'Sub title:', 'required' => false))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('type', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:PageType',
            		'choice_label' => 'name',
            		'label' => 'Type: ',
            		'query_builder' => function (EntityRepository $er) {
	            		return $er->createQueryBuilder('a')
	            		->orderBy('a.name','ASC');
            		}
            ))
            ->add('articlesPerPage', 'integer', array('label' => '# max articles:'))
            ->add('banner', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Banner',
            		'choice_label' => 'name',
            		'required' => false,
            		'label' => 'Banner: '))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $page = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/page.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/page/delete/{id}")
     * @ParamConverter("page", class="AppBundle:Page")
     */
    public function delete($page)
    {
        if(!isset($page)) {
            return new Response("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/page")
     */       
    public function display() {
        $pages = $this->getDoctrine()
        ->getRepository('AppBundle:Page')
        ->findAll();
        return $this->render('admin/view/page.html.twig',  array('pages' => $pages));
    }
}