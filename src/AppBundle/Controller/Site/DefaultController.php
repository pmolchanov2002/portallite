<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

	/**
     * @Route("/", name="homePage")
     */
    public function homePage(Request $request)
    {
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	//$lang = 'ru';
    	return $this->redirectToRoute("page", array('pageId' => 'home.'.$lang));
    }
    
    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function welcomeAdmin()
    {
    	// replace this example code with whatever you need
    	return $this->render('admin/view/welcome_admin.html.twig');
    }
    
}
