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

    public function deletePlayerAction(Request $request, $player_id) {
        $player = $this->getDoctrine()
                    ->getRepository('DecisionBundle:Player')
                    ->find($player_id);
        $obj = array();
        $obj['from_team'] = 0;

        $an = $player->getAttributesNormalized();
        $ar = $player->getAttributesRegular();

        try {
            $team = $player->getPlayerTeamId();

            $em = $this->getDoctrine()->getManager();
            if(!is_null($team)) {
                $team->removeTeamPlayer($player);
                $em->persist($team);
                $obj['from_team'] = 1;
                $obj['players'] = $team->getTeamPlayers()->count();
            }
            if(!is_null($an)) {
                $em->remove($an);
            }
            if(!is_null($ar)) {
                $em->remove($ar);
            }
            $em->remove($player);
            $em->flush();

            $obj['message'] = "Player deleted";
            $obj['error'] = 0;

        } catch (Exception $ex) {
             $obj['message'] = 'Error';
             $obj['error'] = 1;
        } 

        $strJSON = json_encode($obj);

        $arrParams=array(
            'json' => $strJSON
        );

        return $this->render('DecisionBundle:Team:team.json.html.twig', $arrParams); 
    }

    public function randomGenerateAction(Request $request, $counter) {
        if($counter <1 || $counter > 30 || !is_numeric($counter)) return false;
        $data = new DataHolder();
        $arrPositions = array_keys($data->getPositions());
        $arrStrength = array_keys($data->getStrength());
        $arrAccuracy = array_keys($data->getAccuracy());
        $arrReactions = array_keys($data->getReactions());
        for($i=0;$i<$counter;$i++) {
            $player = new Player();
            $player->setPlayerName("Player ".$i);
            $player->setPlayerPosition($arrPositions[rand(0,3)]);

            $ar = new AttributesRegular();
            $ar->setStrength($arrStrength[rand(0,4)]);
            $ar->setAccuracy($arrAccuracy[rand(0,4)]);
            $ar->setReactions($arrReactions[rand(0,5)]);

            $ar->setHeight(rand(150,250));
            $ar->setAge(rand(17,35));
            $ar->setInjuries(rand(0,12));

            $an = $ar->Normalize();

            $player->setAttributesRegular($ar);
            $player->setAttributesNormalized($an);

            $an->setPlayer($player);
            $ar->setPlayer($player);

            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->persist($an);
            $em->persist($ar);
            $em->flush();
        }

        $arrParams=array(
            "generator" => true,
            "generated" => $counter
        );

        return $this->render('DecisionBundle:Default:index.html.twig');
    }

    public function listAllAction(Request $request) {
        $arrPlayers = $this->getDoctrine()
                ->getRepository('DecisionBundle:Player')
                ->findAll();

        $nbPages = ceil(count($arrPlayers)/9);

        $arrPlayersSliced = array();

        for($i=0;$i<$nbPages;$i++) {
            $arrPlayersSliced[$i] = array_slice($arrPlayers,$i*9,9);
        }

        $arrParams = array(
            'nbPages' => $nbPages,
            'arrPlayers' => $arrPlayersSliced,
            'nPlayers' => count($arrPlayers),
            'ajax_remove_player' => $this->generateUrl('player_remove',array(   'player_id'=>'PPPP'))
        );

        return $this->render('DecisionBundle:Player:player.list.all.twig', $arrParams);
    }
}