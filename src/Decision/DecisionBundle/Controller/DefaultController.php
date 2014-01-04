<?php

namespace Decision\DecisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Decision\DecisionBundle\Entity\Player;
use Decision\DecisionBundle\Entity\Team;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	$team = new Team();
    	$team->setTeamName("My Team");
    	$team->setTeamAssisted(0);
    	$team->setTeamUserId(1);

    	$player1 = new Player();
    	$player1->setPlayerName("Player");
    	$player1->setPlayerHeight(160);
    	$player1->setPlayerAge(20);
    	$player1->setPlayerTeamId($team);
    	$player1->setPlayerStrength("strong");
    	$player1->setPlayerAccuracy("good");
    	$player1->setPlayerReactions("good");
    	$player1->setPlayerAccuracy("fast");
    	$player1->setPlayerPosition("CF");
    	$player1->setPlayerInjuries(0);

    	$player2 = new Player();
      	$player2->setPlayerName("Player 2");
    	$player2->setPlayerHeight(180);
    	$player2->setPLayerAge(30);
    	$player2->setPlayerTeamId($team);
    	$player2->setPlayerStrength("strong");
    	$player2->setPlayerAccuracy("good");
    	$player2->setPlayerReactions("good");
    	$player2->setPlayerAccuracy("fast");
    	$player2->setPlayerPosition("CF");
    	$player2->setPlayerInjuries(2);

    	$em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->persist($player1);
        $em->persist($player2);
        $em->flush();

        return $this->render('DecisionBundle:Default:index.html.twig', array('name' => $name));
    }

    public function showAction() {
    	$team = $this->getDoctrine()
        ->getRepository('DecisionBundle:Team')
        ->find(1);

    	$list = $team->getTeamPlayers();
    	$arr = $list->toArray();
    	for($i=0;$i<count($arr);$i++) {
    		$player = $arr[$i];
    		echo $player->getPlayerName()."<br/>";
    	}

    	return $this->render('DecisionBundle:Default:index.html.twig', array('name' =>"Test"));
    }
}