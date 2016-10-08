<?php

// src/AppBundle/Controller/SettingController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Setting;

use Doctrine\ORM\EntityRepository;

class SettingController extends Controller
{

    private $displayRoute = 'app_setting_display';

    /**
     * @Route("/admin/web/setting/create")
     */
    public function create(Request $request)
    {
        $setting = new Setting();
        $form = $this->createFormBuilder($setting)
        	->add('value', 'markdown', array('label' => 'Value:'))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('type', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:SettingType',
            		'choice_label' => 'name',
            		'label' => 'Type: '))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $setting = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/setting.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/setting/edit/{id}")
     * @ParamConverter("setting", class="AppBundle:Setting")     
     */
    public function edit($setting, Request $request)
    {
        if(!isset($setting)) {
            return new Response("Setting not found");
        }
        $form = $this->createFormBuilder($setting)
        	->add('value', 'markdown', array('label' => 'Value:'))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('type', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:SettingType',
            		'choice_label' => 'name',
            		'label' => 'Type: '))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $setting = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/setting.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/setting/delete/{id}")
     * @ParamConverter("setting", class="AppBundle:Setting")
     */
    public function delete($setting)
    {
        if(!isset($setting)) {
            return new Response("Setting not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($setting);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/setting")
     */       
    public function display() {
        $settings = $this->getDoctrine()
        ->getRepository('AppBundle:Setting')
        ->findAll();
        return $this->render('admin/view/setting.html.twig',  array('settings' => $settings));
    }
}