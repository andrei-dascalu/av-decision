<?php

namespace Decision\DecisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 */
class Player
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $playerName;

    /**
     * @var string
     */
    private $playerPosition;

    /**
     * @var \Decision\DecisionBundle\Entity\AttributesRegular
     */
    private $attributesRegular;

    /**
     * @var \Decision\DecisionBundle\Entity\AttributesNormalized
     */
    private $attributesNormalized;

    /**
     * @var \Decision\DecisionBundle\Entity\Team
     */
    private $playerTeamId;


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
     * Set playerName
     *
     * @param string $playerName
     * @return Player
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;

        return $this;
    }

    /**
     * Get playerName
     *
     * @return string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * Set playerPosition
     *
     * @param string $playerPosition
     * @return Player
     */
    public function setPlayerPosition($playerPosition)
    {
        $this->playerPosition = $playerPosition;

        return $this;
    }

    /**
     * Get playerPosition
     *
     * @return string
     */
    public function getPlayerPosition()
    {
        return $this->playerPosition;
    }

    /**
     * Set attributesRegular
     *
     * @param \Decision\DecisionBundle\Entity\AttributesRegular $attributesRegular
     * @return Player
     */
    public function setAttributesRegular(\Decision\DecisionBundle\Entity\AttributesRegular $attributesRegular = null)
    {
        $this->attributesRegular = $attributesRegular;

        return $this;
    }

    /**
     * Get attributesRegular
     *
     * @return \Decision\DecisionBundle\Entity\AttributesRegular
     */
    public function getAttributesRegular()
    {
        return $this->attributesRegular;
    }

    /**
     * Set attributesNormalized
     *
     * @param \Decision\DecisionBundle\Entity\AttributesNormalized $attributesNormalized
     * @return Player
     */
    public function setAttributesNormalized(\Decision\DecisionBundle\Entity\AttributesNormalized $attributesNormalized = null)
    {
        $this->attributesNormalized = $attributesNormalized;

        return $this;
    }

    /**
     * Get attributesNormalized
     *
     * @return \Decision\DecisionBundle\Entity\AttributesNormalized
     */
    public function getAttributesNormalized()
    {
        return $this->attributesNormalized;
    }

    /**
     * Set playerTeamId
     *
     * @param \Decision\DecisionBundle\Entity\Team $playerTeamId
     * @return Player
     */
    public function setPlayerTeamId(\Decision\DecisionBundle\Entity\Team $playerTeamId = null)
    {
        $this->playerTeamId = $playerTeamId;

        return $this;
    }

    /**
     * Get playerTeamId
     *
     * @return \Decision\DecisionBundle\Entity\Team
     */
    public function getPlayerTeamId()
    {
        return $this->playerTeamId;
    }

    public function getEQWScore() {
        $an = $this->getAttributesNormalized();
        return $an->getStrength()+$an->getReactions()+$an->getHeight()+$an->getAccuracy()+$an->getInjuries()+$an->getAge();
    }
}
