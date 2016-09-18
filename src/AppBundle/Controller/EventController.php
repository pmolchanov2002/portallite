<?php

// src/AppBundle/Controller/EventController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Event;

use Doctrine\ORM\EntityRepository;

class EventController extends Controller
{

    private $displayRoute = 'app_event_display';

    /**
     * @Route("/admin/web/event/create")
     */
    public function create(Request $request)
    {
        $event = new Event();
        $form = $this->createFormBuilder($event)
            ->add('name', 'text', array('label' => 'Name:'))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('page', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Page',
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('article', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Article',
            		'choice_label' => 'title',
            		'required' => false,
            		'label' => 'Article: '))
            ->add('status', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Status',
            		'choice_label' => 'name',
            		'label' => 'Status: '))           
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/event.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/event/edit/{id}")
     * @ParamConverter("event", class="AppBundle:Event")     
     */
    public function edit($event, Request $request)
    {
        if(!isset($event)) {
            return new Response("Event not found");
        }
        $form = $this->createFormBuilder($event)
            ->add('name', 'text', array('label' => 'Name:'))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('page', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Page',
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('article', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Article',
            		'choice_label' => 'title',
            		'required' => false,
            		'label' => 'Article: '))
            ->add('status', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Status',
            		'choice_label' => 'name',
            		'label' => 'Status: '))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/event.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/event/delete/{id}")
     * @ParamConverter("event", class="AppBundle:Event")
     */
    public function delete($event)
    {
        if(!isset($event)) {
            return new Response("Event not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/event")
     */       
    public function display() {
        $events = $this->getDoctrine()
        ->getRepository('AppBundle:Event')
        ->findAll();
        return $this->render('admin/view/event.html.twig',  array('events' => $events));
    }
}