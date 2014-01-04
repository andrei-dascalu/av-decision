<?php

namespace Decision\DecisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Decision\DecisionBundle\Entity\DataHolder;
use Decision\DecisionBundle\Entity\Player;
use Decision\DecisionBundle\Entity\AttributesNormalized;
use Decision\DecisionBundle\Entity\AttributesRegular;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\HttpFoundation\Request;



class PlayerController extends Controller
{

    public function addSuccessAction(Request $request, $player_id) {
        $player = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->find($player_id);
        $arrParams = array(
            'arrPlayers' => array($player),
            'is_assisted' => true
        );
        return $this->render('DecisionBundle:Player:player.success.html.twig',$arrParams);
    }

    public function addAttribAction(Request $request, $player_id) {
        $attributesRegular = new AttributesRegular();
        $data = new DataHolder();
        $form = $this->createFormBuilder($attributesRegular)
            ->add('strength', 'choice',array('label'=>'Player Strength','choices'=>$data->getStrength()))
            ->add('reactions', 'choice',array('label'=>'Player Reactions','choices'=>$data->getReactions()))
            ->add('height', 'text',array('label'=>'Player Height'))
            ->add('age', 'text',array('label'=>'Player Age'))
            ->add('accuracy', 'choice',array('label'=>'Player Accuracy','choices'=>$data->getAccuracy()))
            ->add('injuries', 'text',array('label'=>'Player Injuries'))
            ->add('save', 'submit')
            ->getForm();

        $form->handleRequest($request);

        $player = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->find($player_id);

        $outcome = 'Set attributes for player: ';

        if ($request->getMethod() == 'POST') {
            if($form->isValid()) {
                $attributesNormalized = $attributesRegular->Normalize();
                $attributesNormalized->setPlayer($player);
                $player->setAttributesNormalized($attributesNormalized);
                $em = $this->getDoctrine()->getManager();
                $player->setAttributesRegular($attributesRegular);
                $attributesRegular->setPlayer($player);
                $em->persist($player);
                $em->persist($attributesRegular);
                $em->persist($attributesNormalized);
                $em->flush();
                return $this->redirect($this->generateUrl('player_add_success',array('player_id'=>$player->getId())));
            }
        }

        $arrParams = array(
            'form' =>$form->createView(),
            'outcome'=>$outcome,
            'step' => 2,
            'player_name' => $player->getPlayerName(),
            'player_position' => $player->getPlayerPosition()
        );

        return $this->render('DecisionBundle:Player:player.form.html.twig', $arrParams);
    }

    public function addPlayerAction(Request $request) {
        $player = new Player();
        $data = new DataHolder();
        $form = $this->createFormBuilder($player)
        ->add('playerName', 'text',array('label'=>'Player Name'))
        ->add('playerPosition', 'choice',array('label'=>'Player Position','choices'=>$data->getPositions()))
        ->add('save', 'submit',array('label'=>'Next'))
        ->getForm();

        $form->handleRequest($request);
        $outcome = 'Add a new player';

        if ($request->getMethod() == 'POST') {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();

                return $this->redirect($this->generateUrl('player_add_attrib',array('player_id'=>$player->getId())));
            }
        }

        $arrParams = array(
            'form' =>$form->createView(),
            'outcome'=>$outcome,
            'step' => 1
        );
        return $this->render('DecisionBundle:Player:player.form.html.twig', $arrParams);
    }
}