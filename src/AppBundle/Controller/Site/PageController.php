<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    
    /**
     * @Route("/m/page/{pageId}", name="mobilePage")
     */
    public function displayMobilePage($pageId)
    {
    	return $this->redirectToRoute("page", array('pageId' => $pageId));
    }
    
    /**
     * @Route("/page/{pageId}", name="page")
     */
    public function displayPage($pageId, Request $request)
    {
    	$currentPage = $request->query->get('currentPage');
    	$pageService = $this->get('PageService');
    	$site = $this->getParameter('site');
    	$em = $this->getDoctrine ()->getManager();
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	
    	$page = $em->getRepository ( 'AppBundle:Page' )->find($pageId);
    	
    	if(empty($page)) {
    		return $this->redirectToRoute("error");
    	}
	    
    	$lang = $page->getLanguage()->getCode();
	    $type = $page->getType()->getId();
    	
    	$pageType = $pageService->pageTypes[$type];
    	
    	$parameters = array(
    			'menus' => $pageService->loadMenu($lang),
    			'events' => $pageService->loadEvents($lang),
    			'settings' => $pageService->loadSettings($lang),
    			'page' => $page,
    			'archive' => $pageService->getArticleArchive($page),
    			'months' => $pageService->months,
    			'lang' => $lang,
    			'articleId' => 0,
    			'currentPage' => $currentPage
    	);
    	
    	$searchString = $request->query->get('s');
    	if(!empty($searchString)) {
    		$result = $pageService->findArticlesByKeyword($searchString);
    		foreach($result as $article) {
    			$page->addArticle($article);
    		}
    	}
    	
	   	return $this->render('site/'.$site.'/views/'.$lang.'/'.$pageType.'.html.twig', $parameters);
    }
}
