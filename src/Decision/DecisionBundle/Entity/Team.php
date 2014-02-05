<?php

namespace Decision\DecisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 */
class Team
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $teamName;

    /**
     * @var integer
     */
    private $teamAssisted;

    /**
     * @var integer
     */
    private $teamUserId;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set teamName
     *
     * @param string $teamName
     * @return Team
     */
    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;

        return $this;
    }

    /**
     * Get teamName
     *
     * @return string
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * Set teamAssisted
     *
     * @param integer $teamAssisted
     * @return Team
     */
    public function setTeamAssisted($teamAssisted)
    {
        $this->teamAssisted = $teamAssisted;

        return $this;
    }

    /**
     * Get teamAssisted
     *
     * @return integer
     */
    public function getTeamAssisted()
    {
        return $this->teamAssisted;
    }

    /**
     * Set teamUserId
     *
     * @param integer $teamUserId
     * @return Team
     */
    public function setTeamUserId($teamUserId)
    {
        $this->teamUserId = $teamUserId;

        return $this;
    }

    /**
     * Get teamUserId
     *
     * @return integer
     */
    public function getTeamUserId()
    {
        return $this->teamUserId;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $team_players;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->team_players = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add team_players
     *
     * @param \Decision\DecisionBundle\Entity\Player $teamPlayers
     * @return Team
     */
    public function addTeamPlayer(\Decision\DecisionBundle\Entity\Player $teamPlayers)
    {
        $this->team_players[] = $teamPlayers;

        return $this;
    }

    /**
     * Remove team_players
     *
     * @param \Decision\DecisionBundle\Entity\Player $teamPlayers
     */
    public function removeTeamPlayer(\Decision\DecisionBundle\Entity\Player $teamPlayers)
    {
        $this->team_players->removeElement($teamPlayers);
    }

    /**
     * Get team_players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamPlayers()
    {
        return $this->team_players;
    }

    /**
     * Calculate percentage score based on given ideal
     */
    public function getScore($idealScore) {
        $arrTeamPlayers = $this->getTeamPlayers();

        if(count($arrTeamPlayers) == 5) {
            $arrWeights = array();

            foreach($arrTeamPlayers as $player) {
                $arrWeights[] = $player->getEQWScore();
            }

            $currentTeamScore = array_sum($arrWeights);

            $score = round(($currentTeamScore/$idealScore)*100,2).'%';

        } else {
            $score = -1;
        }

        return $score;
    }
}
