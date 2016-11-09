<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends Controller
{
    
    /**
     * @Route("/error", name="error")
     */
    public function errorPage(Request $request) {
    	$pageService = $this->get('PageService');
    	$site = $this->getParameter('site');
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	$parameters = array(
    			'menus' => $pageService->loadMenu($lang),
    			'settings' => $pageService->loadSettings($lang),
    			'events' => $pageService->loadEvents($lang)
    	);
    	return $this->render('site/'.$site.'/views/'.$lang.'/error.html.twig', $parameters);
    }
}