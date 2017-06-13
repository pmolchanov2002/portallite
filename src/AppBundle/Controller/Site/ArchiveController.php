<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArchiveController extends Controller
{
	/**
	 * @Route("/page/{pageId}/archive/{year}/{month}", name="articleArchive")
	 */
	public function displayArchive($pageId, $month, $year, Request $request)
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
    			'month' => $month,
    			'year' => $year,
    			'currentPage' => $currentPage
    	);
    	
    	$result = $pageService->findArticlesInArchive($page, $month, $year);
    	$page->clearArticles();
    	foreach($result as $article) {
    		$page->addArticle($article);
    	}
    	
    	$page->setArticlesPerPage(count($result));
    	
	   	return $this->render('site/'.$site.'/views/'.$lang.'/'.$pageType.'.html.twig', $parameters);
	}
}
