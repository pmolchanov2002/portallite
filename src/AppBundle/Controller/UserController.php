<?php

// src/AppBundle/Controller/UserController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;


class UserController extends Controller
{

    private $displayRoute = 'app_user_display';

    /**
     * @Route("/admin/user/create")
     */
    public function create(Request $request)
    {
        $user = new User();
        $user->setActive(true);
        $form = $this->createFormBuilder($user)
        	->add('lastName', 'text', array('label' => 'Last Name:'))
        	->add('firstName', 'text', array('label' => 'First Name:'))
        	->add('englishName', 'text', array('label' => 'English Name:'))
            ->add('username', 'text', array('label' => 'Login:'))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Password fields do not match',
                'first_options' => array('label' => 'Password', 'always_empty' => false),
                'second_options' => array('label' => 'Repeat Password', 'always_empty' => false),
            ))
            ->add('email', 'text', array('label' => 'Email:', 'required' => false))
            ->add('active', 'checkbox', array('label' => 'Active', 'required' => false))
            ->add('roles', 'entity', array(
                'multiple' => true,
                'expanded' => true,
                'class' => 'AppBundle:Role',
                'choice_label' => 'name',
                'label' => 'Roles: '
            ))
            ->add('save', 'submit', array('label' => 'Create user'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            if($user->getPassword() != '') {
                #$options = array('cost' => 11);
                $user->setPassword(md5($user->getPassword()));
                #$user->setPassword(password_hash($user->getPassword(), PASSWORD_SHA512, $options));
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/user.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/user/edit/{id}")
     * @ParamConverter("user", class="AppBundle:User")     
     */
    public function edit($user, Request $request)
    {
        if(!isset($user)) {
            return new Response("User not found");
        }
        
        $old_password = $user->getPassword();
        
        $form = $this->createFormBuilder($user)
        	->add('lastName', 'text', array('label' => 'Last Name:'))
        	->add('firstName', 'text', array('label' => 'First Name:'))
            ->add('username', 'text', array('label' => 'Login:'))
            ->add('englishName', 'text', array('label' => 'English Name:'))
            ->add('password', 'repeated', array(
                'type' => 'password',
            	'required' => false,
                'invalid_message' => 'Password fields do not match',
                'first_options' => array('label' => 'Password', 'required' => false),
                'second_options' => array('label' => 'Repeat Password', 'required' => false),
            ))
            ->add('email', 'text', array('label' => 'Email:', 'required' => false))
            ->add('active', 'checkbox', array('label' => 'Active', 'required' => false))
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
            $user = $form->getData();
            if($user->getPassword() != $old_password && $user->getPassword() != '') {
                $user->setPassword(md5($user->getPassword()));
            } else {
                $user->setPassword($old_password);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/user.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/user/delete/{id}")
     * @ParamConverter("user", class="AppBundle:User")
     */
    public function delete($user)
    {
        if(!isset($user)) {
            return new Response("User not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/user")
     */       
    public function display() {
        $users = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->findAll();
        return $this->render('admin/view/user.html.twig',  array('users' => $users));
    }    
}