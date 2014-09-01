<?php

namespace Decision\DecisionBundle\Entity;

class DataHolder 
{
    private $positions;
    private $strength;
    private $accuracy;
    private $reactions;

    public function __construct() 
    {
        $this->positions = array(
            'SG' => 'Shooting Guard',
            'PG' => 'Point Guard',
            'C' => "Center",
            'D' => 'Defender'
        );

        $this->accuracy = array(
            'very innaccurate' => 'Very Innacurate',
            'innaccurate' => 'Innaccurate',
            'moderate' => "Moderate",
            'accurate' => 'Accurate',
            'very accurate' => 'Very Accurate'
        );

        $this->strength = array(
            'very weak' => 'Very Weak',
            'weak' => 'Weak',
            'moderate' => "Moderate",
            'strong' => 'Very Strong',
            'very strong' => 'Very Strong'
        );

        $this->reactions = array(
            'very slow' => 'Very Slow',
            'slow' => 'Slow',
            'average' => "Average",
            'fast' => 'Fast',
            'very fast' => 'Very Fast',
            'blazing' => 'Blazing'
        );

    }

    public function getPositions() 
    {
        return $this->positions;
    }

    public function getAccuracy() 
    {
        return $this->accuracy;
    }

    public function getStrength() 
    {
        return $this->strength;
    }

    public function getReactions() 
    {
        return $this->reactions;
    }
}
