<?php

namespace Decision\DecisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributesNormalized
 */
class AttributesNormalized
{


    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $strength;

    /**
     * @var integer
     */
    private $reactions;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $accuracy;

    /**
     * @var integer
     */
    private $injuries;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var \Decision\DecisionBundle\Entity\Player
     */
    private $player;

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
     * Set strength
     *
     * @param integer $strength
     * @return AttributesNormalized
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set reactions
     *
     * @param integer $reactions
     * @return AttributesNormalized
     */
    public function setReactions($reactions)
    {
        $this->reactions = $reactions;

        return $this;
    }

    /**
     * Get reactions
     *
     * @return integer
     */
    public function getReactions()
    {
        return $this->reactions;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return AttributesNormalized
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set accuracy
     *
     * @param integer $accuracy
     * @return AttributesNormalized
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    /**
     * Get accuracy
     *
     * @return integer
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set injuries
     *
     * @param integer $injuries
     * @return AttributesNormalized
     */
    public function setInjuries($injuries)
    {
        $this->injuries = $injuries;

        return $this;
    }

    /**
     * Get injuries
     *
     * @return integer
     */
    public function getInjuries()
    {
        return $this->injuries;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return AttributesNormalized
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set player
     *
     * @param \Decision\DecisionBundle\Entity\Player $player
     * @return AttributesNormalized
     */
    public function setPlayer(\Decision\DecisionBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \Decision\DecisionBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
