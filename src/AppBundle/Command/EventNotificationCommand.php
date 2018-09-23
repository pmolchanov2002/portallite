<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;

use Doctrine\ORM\EntityManager;

class EventNotificationCommand extends ContainerAwareCommand
{
	protected $em;
	
	protected function configure()
	{
		$this->setName('stsergiuslc:events')
		->setDescription('Send event notifications by e-mail');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->sendEvents("+6 days", "+7 days", 'Next week: ', $input, $output);
		$this->sendEvents("+1 days", "+2 days", 'Tomorrow: ', $input, $output);
	}
	
	private function sendEvents($startOffset, $endOffset, $titlePrefix, InputInterface $input, OutputInterface $output) {
		$this->em = $this->getContainer()->get('doctrine')->getManager();
		
		$startDate = new \DateTime();
		$startDate->modify($startOffset);
		
		$endDate = new \DateTime();
		$endDate->modify($endOffset);
		
		$events = $this->em
		->getRepository('AppBundle:Event')
		->createQueryBuilder('e')
		->where('e.eventDate >= :startDate')
		->andWhere('e.eventDate < :endDate')
		->orderBy('e.eventDate','desc')
		->setParameter('startDate', $startDate)
		->setParameter('endDate', $endDate)
		->getQuery()->execute();
		

		if(count($events) != 0) {

			foreach($events as $event) {
				$output->writeln("Events to send: ".$event->getType()->getEnTitle());
				$query = $this->em
				->getRepository('AppBundle:User')
				->createQueryBuilder('u')
				->join('u.roles', 'r')
				->join('r.eventTypes', 'et')
				->where('et.id = :typeId')
				->andWhere('u.active = true')
				->setParameter('typeId', $event->getType()->getId())
				->getQuery();
				
				$users = $query->execute();			
				
				// $users = array();
				// $user = new User();
				// $user->setEmail("pmolchanov2002@gmail.com");
				// $user->setMobilePhone("845 553 0997");
				// array_push($users, $user);
				
				foreach($users as $user) {
					$output->writeln("send to:".$user->getEmail());
					$body = $this->sendEmail($user, $event, $titlePrefix);
					if($user->getActive()) {
						// $body = $this->sendSms($user, $event, $titlePrefix);
					}
					//$output->writeln($body);
				}
			}
		}		
	}
	
	private function sendEmail($user, $event, $titlePrefix) {
		$body = $this->getContainer()->get('templating')->render(
			'mail/events.html.twig',
			array(
				'event' => $event
			)
		);
		$message = \Swift_Message::newInstance()
		->setSubject($titlePrefix.$event->getType()->getEnTitle().' / '.$event->getType()->getRuTitle())
		->setFrom('administration@stsergiuslc.org')
		->setTo($user->getEmail())
		->setBody($body,'text/html');

		\Swift_Mailer::newInstance(\Swift_MailTransport::newInstance())->send($message);
		//print($this->getContainer()->get('mailer')->send($message));
		return $body;
	}

	private function sendSms($user, $event, $titlePrefix) {
		print("Phone: ".$user->getMobilePhone());
		if(!empty($user->getMobilePhone())) {
			$gateways = array(
				//"@mymetropcs.com",
				"@tmomail.net",
				"@vtext.com",
				"@txt.att.net"
				//"@messaging.sprintpcs.com"
			);
			foreach($gateways as $gateway) {
				$body = $event->getType()->getEnTitle().' on '.$event->getEventDate()->format('l, F j, Y \a\t h:i a');
				$re = "/[-\s\(\)\{\}\[\]\+]+/";
				$str = $user->getMobilePhone();

				$phoneEmail = preg_replace($re, "", $str).$gateway;
				$message = \Swift_Message::newInstance()
				->setSubject("St.Sergius Learning Center")
				->setFrom('administration@stsergiuslc.com')
				->setTo($phoneEmail)
				->setBody($body);
				print("Phone: ".$phoneEmail.", Body:".$body);

				\Swift_Mailer::newInstance(\Swift_MailTransport::newInstance())->send($message);
		    }
		}
	}
}