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
            'form' =>$form->createView(),
        );
        return $this->render('DecisionBundle:Team:team.form.html.twig', $arrParams);
    }

    public function addPlayersAction(Request $request, $team_id) {
        $team = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Team')
                    ->find($team_id);

        $arrPlayers = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->findBy(array('playerTeamId' => null));

        $arrParams = array(
            'team_name' => $team->getTeamName(),
            'team_assisted' => $team->getTeamAssisted(),
            'is_assisted' => $team->getTeamAssisted(),
            'arrPlayers' => $arrPlayers
        );
        return $this->render('DecisionBundle:Team:team.players.html.twig', $arrParams);   
    }
}
