<?php

namespace Decision\DecisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Decision\DecisionBundle\Entity\AttributesNormalized;
use Decision\DecisionBundle\Entity\DataHolder;

/**
 * AttributesRegular
 */
class AttributesRegular
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $strength;

    /**
     * @var string
     */
    private $reactions;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var string
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
     * @param string $strength
     * @return AttributesRegular
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength
     *
     * @return string 
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set reactions
     *
     * @param string $reactions
     * @return AttributesRegular
     */
    public function setReactions($reactions)
    {
        $this->reactions = $reactions;

        return $this;
    }

    /**
     * Get reactions
     *
     * @return string 
     */
    public function getReactions()
    {
        return $this->reactions;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return AttributesRegular
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
     * @param string $accuracy
     * @return AttributesRegular
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    /**
     * Get accuracy
     *
     * @return string 
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set injuries
     *
     * @param integer $injuries
     * @return AttributesRegular
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
     * @return AttributesRegular
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
     * @return AttributesRegular
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


    public function Normalize() {
        $strength = $this->NormalizeStrength($this->getStrength());
        $age = $this->NormalizeAge($this->getAge());
        $injuries = $this->NormalizeInjuries($this->getInjuries());
        $height = $this->NormalizeHeight($this->getHeight());
        $accuracy= $this->NormalizeAccuracy($this->getAccuracy());
        $reactions = $this->NormalizeReactions($this->getReactions());


        $attributesNormalized = new AttributesNormalized();
        $attributesNormalized->setStrength($strength);
        $attributesNormalized->setAge($age);
        $attributesNormalized->setInjuries($injuries);
        $attributesNormalized->setHeight($height);
        $attributesNormalized->setAccuracy($accuracy);
        $attributesNormalized->setReactions($reactions);

        return $attributesNormalized;
    }

    private function NormalizeStrength($strength) {
        $dataHolder = new DataHolder();
        $arrStrength = array_keys($dataHolder->getStrength());
        $items = count($arrStrength);

        $step = ceil(100/$items);
        $current = 0;

        $i=0;
        while($strength != $arrStrength[$i]) {
            $current += $step;
            $i++;
        }

        return $current;
    }

    private function NormalizeAccuracy($accuracy) {
        $dataHolder = new DataHolder();
        $arrAccuracy = array_keys($dataHolder->getAccuracy());
        $items = count($arrAccuracy);
        $step = ceil(100/$items);
        $current = 0;

        $i=0;
        while($accuracy != $arrAccuracy[$i]) {
            $current += $step;
            $i++;
        }

        return $current;
    }

    private function NormalizeReactions($reactions) {
        $dataHolder = new DataHolder();
        $arrReactions = array_keys($dataHolder->getReactions());
        $items = count($arrReactions);

        $step = ceil(100/$items);
        $current = 0;

        $i=0;
        while($reactions != $arrReactions[$i]) {
            $current += $step;
            $i++;
        }

        return $current;
    }

    private function NormalizeInjuries($injuries) {
        $min=0;
        $max = 12;

        $step = ceil(100/($max-$min));
        $i=$max;
        $current = 0;

        while($i >= $injuries) {
            $current += $step;
            $i--;
        }

        return $current;
    }

    private function NormalizeAge($age) {
        $min=17;
        $max = 35;

        $step = ceil(100/($max-$min));
        $i=$max;
        $current = 0;

        while($i >= $age) {
            $current += $step;
            $i--;
        }

        return $current;
    }

    private function NormalizeHeight($height) {
        $min=15;
        $max = 25;

        $step = ceil(100/($max-$min));
        $i=$min;
        $current = 0;

        while($i <= floor($height/10)) {
            $current += $step;
            $i++;
        }

        return $current;
    }
}
