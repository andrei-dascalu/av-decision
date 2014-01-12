<?php

namespace Decision\DecisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Decision\DecisionBundle\Entity\DataHolder;
use Decision\DecisionBundle\Entity\Player;
use Decision\DecisionBundle\Entity\Team;
use Decision\DecisionBundle\Entity\AttributesNormalized;
use Decision\DecisionBundle\Entity\AttributesRegular;


class TeamController extends Controller
{
    public function addTeamAction(Request $request) {

        $team = new Team();
        $form = $this->createFormBuilder($team)
        ->add('teamName', 'text',array('label'=>'Team Name'))
        ->add('teamAssisted', 'checkbox',array('label'=>'Is Assisted','required'=>false))
        ->add('save', 'submit',array('label'=>'Next'))
        ->getForm();

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                $em->flush();

                return $this->redirect($this->generateUrl('team_add_players',array('team_id'=>$team->getId())));
            }
        }

        $arrParams = array(
            'outcome'=>'Create new Team',
            'form' =>$form->createView()
        );
        return $this->render('DecisionBundle:Team:team.form.html.twig', $arrParams);
    }

    public function addPlayersAction(Request $request, $team_id) {
        $team = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Team')
                    ->find($team_id);

        $arrTeamPlayers = $team->getTeamPlayers();

        $arrPlayers = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->findBy(array('playerTeamId' => null));

        $arrParams = array(
            'team' => $team,
            'add_players' => true,
            'remove_players' => false,
            'arrSelectedPlayers' => $arrTeamPlayers,
            'arrPlayers' => $arrPlayers,
            'ajax_url' => $this->generateUrl('team_add_player',array('team_id'=>$team->getId(),'player_id'=>'PPPP')),
            'ajax_remove_url' => $this->generateUrl('team_remove_player',array('team_id'=>$team->getId(),'player_id'=>'PPPP')),
            'ajax_remove_player' => $this->generateUrl('player_remove',array(   'player_id'=>'PPPP'))
        );
        return $this->render('DecisionBundle:Team:team.players.html.twig', $arrParams);   
    }

    public function addPlayerAction(Request $request, $team_id, $player_id) {
        $team = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Team')
                    ->find($team_id);
        $player = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->find($player_id);

        $arrTeamPlayers = $team->getTeamPlayers();
        $obj = array();
        if($arrTeamPlayers->count() < 5) {
            try {
                $team->addTeamPlayer($player);
                $player->setPlayerTeamId($team);
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                $em->persist($player);
                $em->flush();
                $obj['error'] = 0;
                $obj['message'] = 'Player has been added!';
            } catch (Exception $ex) {
                $obj['error'] = 1;
                $obj['message'] = $ex->getMessage();
            }
        } else {
            $obj['error'] = 2;
            $obj['message'] = "Cannot add more players, team has reached 5 players";
        }

        $arrTeamPlayers = $team->getTeamPlayers();
        $obj['players'] = $arrTeamPlayers->count();
        $strJSON = json_encode($obj);

        $arrParams=array(
            'json' => $strJSON
        );

        return $this->render('DecisionBundle:Team:team.json.html.twig', $arrParams); 
    }

    public function listTeamsAction(Request $request) {
        $arrTeams = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Team')->findAll();

        $arrParams = array(
            'arrTeams' => $arrTeams
        );
        return $this->render('DecisionBundle:Team:team.list.html.twig', $arrParams);
    }

    public function listPlayersAction(Request $request, $team_id) {
        $team = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Team')
                    ->find($team_id);

        $arrTeamPlayers = $team->getTeamPlayers();

        $arrPlayers = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->findBy(array('playerTeamId' => null));

        $arrParams = array(
            'team' => $team,
            'add_players' => false,
            'remove_players' => true,
            'arrPlayers' => $arrTeamPlayers,
            'ajax_url' => $this->generateUrl('team_remove_player',array('team_id'=>$team->getId(),'player_id'=>'PPPP'))
        );
        return $this->render('DecisionBundle:Team:team.players.html.twig', $arrParams);  
    }

    public function removePlayerAction(Request $request, $team_id, $player_id) {
        $team = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Team')
                    ->find($team_id);
        $player = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->find($player_id);

        $arrTeamPlayers = $team->getTeamPlayers();
        $obj = array();
            try {
                $team->removeTeamPlayer($player);
                $player->setPlayerTeamId(null);
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                $em->persist($player);
                $em->flush();
                $obj['error'] = 0;
                $obj['message'] = 'Player has been removed!';
            } catch (Exception $ex) {
                $obj['error'] = 1;
                $obj['message'] = $ex->getMessage();
            }

        $arrTeamPlayers = $team->getTeamPlayers();
        $obj['players'] = $arrTeamPlayers->count();
        $strJSON = json_encode($obj);

        $arrParams=array(
            'json' => $strJSON
        );

        return $this->render('DecisionBundle:Team:team.json.html.twig', $arrParams);
    }
}
