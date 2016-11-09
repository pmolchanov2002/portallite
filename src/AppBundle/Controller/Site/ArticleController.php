<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
	
    /**
     * @Route("/m/page/{pageId}/{articleId}", name="mobileArticleOnPage")
     */
    public function displayMobilePageWithArticle($pageId, $articleId)
    {
    	return $this->redirectToRoute("articleOnPage", 
    			array(
    					'pageId' => $pageId,
    					'articleId' => $articleId
    			));
    }
    
    /**
     * @Route("/page/{pageId}/{articleId}", name="articleOnPage")
     */
    public function displayPageWithArticle($pageId, $articleId)
    {
    	$pageService = $this->get('PageService');
    	$site = $this->getParameter('site');
    	$em = $this->getDoctrine ()->getManager();
    	 
    	$page = $em->getRepository ( 'AppBundle:Page' )->find($pageId);
    	$lang = $page->getLanguage()->getCode();
    	$pageType = $pageService->pageTypes[1];
    	
    	$parameters = array(
    		'menus' => $pageService->loadMenu($lang),
    		'events' => $pageService->loadEvents($lang),
    		'settings' => $pageService->loadSettings($lang),
    		'page' => $page,
    		'articleId' => $articleId
    	);
    	 
    	return $this->render('site/'.$site.'/views/'.$lang.'/'.$pageType.'.html.twig', $parameters);
    }
}
