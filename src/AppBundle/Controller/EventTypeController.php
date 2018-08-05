<?php

// src/AppBundle/Controller/EventController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\EventType;

use Doctrine\ORM\EntityRepository;

class EventTypeController extends Controller
{

    private $displayRoute = 'app_eventtype_display';

    /**
     * @Route("/admin/web/eventtype/create")
     */
    public function create(Request $request)
    {
        $eventType = new EventType();
        $form = $this->createFormBuilder($eventType)
        	->add('enTitle', 'text', array('label' => 'English Title:'))
        	->add('ruTitle', 'text', array('label' => 'Russian Title:'))
        	->add('enDescription', 'markdown', array('label' => 'English Description:'))
        	->add('ruDescription', 'markdown', array('label' => 'Russian Description:'))
        	->add('roles', 'entity', array(
        			'multiple' => true,
        			'expanded' => true,
        			'class' => 'AppBundle:Role',
        			'choice_label' => 'name',
        			'label' => 'Roles: '
        	))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $eventType = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventType);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('forms/eventtype.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/eventtype/edit/{id}")
     * @ParamConverter("eventType", class="AppBundle:EventType")     
     */
    public function edit($eventType, Request $request)
    {
        if(!isset($eventType)) {
            return new Response("Event type not found");
        }
        $form = $this->createFormBuilder($eventType)
        	->add('enTitle', 'text', array('label' => 'English Title:'))
        	->add('ruTitle', 'text', array('label' => 'Russian Title:'))
        	->add('enDescription', 'markdown', array('label' => 'English Description:'))
        	->add('ruDescription', 'markdown', array('label' => 'Russian Description:'))
        	->add('roles', 'entity', array(
        			'multiple' => true,
        			'expanded' => true,
        			'class' => 'AppBundle:Role',
        			'choice_label' => 'name',
        			'label' => 'Roles: '
        	))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $eventType = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventType);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('forms/eventtype.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/eventtype/delete/{id}")
     * @ParamConverter("eventType", class="AppBundle:EventType")
     */
    public function delete($eventType)
    {
        if(!isset($eventType)) {
            return new Response("Event type not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($eventType);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/eventtype")
     */       
    public function display() {
        $eventTypes = $this->getDoctrine()
        ->getRepository('AppBundle:EventType')
        ->findAll();
        return $this->render('views/eventtype.html.twig',  array('eventTypes' => $eventTypes));
    }
}