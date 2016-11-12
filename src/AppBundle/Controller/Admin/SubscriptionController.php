<?php

// src/AppBundle/Controller/SubscriptionController.php
namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscription;

use Doctrine\ORM\EntityRepository;

class SubscriptionController extends Controller
{

    private $displayRoute = 'app_subscription_display';

    /**
     * @Route("/admin/web/subscription/create")
     */
    public function create(Request $request)
    {
        $subscription = new Subscription();
        $form = $this->createFormBuilder($subscription)
			->add('address', 'text', array('label' => 'E-mail address:'))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $subscription = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscription);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/subscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/subscription/edit/{id}")
     * @ParamConverter("subscription", class="AppBundle:Subscription")     
     */
    public function edit($subscription, Request $request)
    {
        if(!isset($subscription)) {
            return new Response("Subscription not found");
        }
        $form = $this->createFormBuilder($subscription)
			->add('address', 'text', array('label' => 'E-mail address:'))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $subscription = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscription);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/subscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/subscription/delete/{id}")
     * @ParamConverter("subscription", class="AppBundle:Subscription")
     */
    public function delete($subscription)
    {
        if(!isset($subscription)) {
            return new Response("Subscription not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($subscription);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/subscription", name="app_subscription_display")
     */       
    public function display() {
        $subscriptions = $this->getDoctrine()
        ->getRepository('AppBundle:Subscription')
        ->findAll();
        return $this->render('admin/view/subscription.html.twig',  array('subscriptions' => $subscriptions));
    }
}