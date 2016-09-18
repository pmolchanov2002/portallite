<?php

// src/AppBundle/Controller/MenuController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Menu;

use Doctrine\ORM\EntityRepository;

class MenuController extends Controller
{

    private $displayRoute = 'app_menu_display';

    /**
     * @Route("/admin/web/menu/create")
     */
    public function create(Request $request)
    {
        $menu = new Menu();
        $form = $this->createFormBuilder($menu)
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('subTitle', 'text', array('label' => 'Sub title:'))
            ->add('parent', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Menu',
            		'choice_label' => 'title',
            		'label' => 'Parent menu: ',
            		'required' => false,
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            		->where('p.parent is null')
            		->orderBy('p.language, p.sortOrder', 'ASC');
            		}
            		))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('menuType', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:MenuType',
            		'choice_label' => 'name',
            		'label' => 'Type: '))
            ->add('page', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Page',
            		'choice_label' => 'id',
            		'required' => false,
            		'label' => 'Page: '))
            ->add('url', 'text', array('label' => 'Url:',
            		'required' => false))
            ->add('status', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Status',
            		'choice_label' => 'name',
            		'label' => 'Status: '))
            ->add('sortOrder', 'integer', array('label' => 'Sort order:'))            
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $menu = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/menu.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/menu/edit/{id}")
     * @ParamConverter("menu", class="AppBundle:Menu")     
     */
    public function edit($menu, Request $request)
    {
        if(!isset($menu)) {
            return new Response("Menu not found");
        }
        $form = $this->createFormBuilder($menu)
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('subTitle', 'text', array('label' => 'Sub title:'))
            ->add('parent', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Menu',
            		'choice_label' => 'title',
            		'label' => 'Parent menu: ',
            		'required' => false,
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            		->where('p.parent is null')
            		->orderBy('p.language, p.sortOrder', 'ASC');
            		}
            		))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('menuType', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:MenuType',
            		'choice_label' => 'name',
            		'label' => 'Type: '))
            ->add('page', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Page',
            		'required' => false,
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('url', 'text', array('label' => 'Url:',
            		'required' => false
            		))
            ->add('status', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Status',
            		'choice_label' => 'name',
            		'label' => 'Status: '))
            ->add('sortOrder', 'integer', array('label' => 'Sort order:'))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $menu = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/menu.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/menu/delete/{id}")
     * @ParamConverter("menu", class="AppBundle:Menu")
     */
    public function delete($menu)
    {
        if(!isset($menu)) {
            return new Response("Menu not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/menu")
     */       
    public function display() {
        $menus = $this->getDoctrine()
        ->getRepository('AppBundle:Menu')
        ->findAll();
        return $this->render('admin/view/menu.html.twig',  array('menus' => $menus));
    }
}