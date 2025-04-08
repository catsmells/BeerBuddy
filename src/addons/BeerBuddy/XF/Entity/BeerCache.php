<?php

namespace BeerBuddy\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class BeerCache extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_beerbuddy_cache';
        $structure->shortName = 'BeerBuddy:BeerCache';
        $structure->primaryKey = 'beer_name';
        $structure->columns = [
            'beer_name' => ['type' => self::STR, 'maxLength' => 255, 'required' => true],
            'url' => ['type' => self::STR, 'required' => true]
        ];
        return $structure;
    }
}
