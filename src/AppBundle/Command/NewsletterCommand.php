<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Article;
use AppBundle\Entity\Subscription;

use Doctrine\ORM\EntityManager;

class NewsletterCommand extends ContainerAwareCommand
{
	protected $em;
	
	protected function configure()
	{
		$this->setName('rocana:newsletter')
		->setDescription('Send newsletter by e-mail');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$this->em = $this->getContainer()->get('doctrine')->getManager();
		
		$date = new \DateTime();
		$date->modify('-7 days');
		
		$articles = $this->em
		->getRepository('AppBundle:Article')
		->createQueryBuilder('a')
		->where('a.created > :date')
		->orderBy('a.created','desc')
		->setParameter('date', $date)
		->getQuery()->execute();
		
		$output->writeln("Articles to send:".count($articles));
		if(count($articles) != 0) {
// 			$subscribers = array();
// 			$subscriber = new Subscription();
// 			$subscriber->setAddress("pmolchanov2002@gmail.com");
// 			array_push($subscribers, $subscriber);
	
 			$subscribers = $this->em
 			->getRepository('AppBundle:Subscription')
			->findAll();
			foreach($subscribers as $subscriber) {
				//$output->writeln("send to:".$subscriber);
				$body = $this->sendEmail($subscriber, $articles);
				//$output->writeln($body);
			}
		}
		
		return;
	}
	
	private function sendEmail($subscriber, $articles) {
		$body = $this->getContainer()->get('templating')->render(
			'mail/newsletter.html.twig',
			array(
				'articles' => $articles
			)
		);
		$message = \Swift_Message::newInstance()
		->setSubject('www.rocana.org')
		->setFrom('info@rocana.org')
		->setTo($subscriber->getAddress())
		->setBody($body,'text/html');

		\Swift_Mailer::newInstance(\Swift_MailTransport::newInstance())->send($message);
		//print($this->getContainer()->get('mailer')->send($message));
		return $body;
	}
}
