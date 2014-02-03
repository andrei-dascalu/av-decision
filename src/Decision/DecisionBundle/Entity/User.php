<?php

namespace Decision\DecisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $userPassword;


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
     * Set userName
     *
     * @param string $userName
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string 
     */
    public function getUserPassword()
    {
        return $this->userPassword;
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
     * @param \Decision\DecisionBundle\Entity\Team $teamPlayers
     * @return User
     */
    public function addTeamPlayer(\Decision\DecisionBundle\Entity\Team $teamPlayers)
    {
        $this->team_players[] = $teamPlayers;

        return $this;
    }

    /**
     * Remove team_players
     *
     * @param \Decision\DecisionBundle\Entity\Team $teamPlayers
     */
    public function removeTeamPlayer(\Decision\DecisionBundle\Entity\Team $teamPlayers)
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
}
