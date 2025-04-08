<?php

namespace BeerBuddy;

use XF\AddOn\AbstractSetup;

class Setup extends AbstractSetup
{
    public function install(array $stepParams = [])
    {
        // just use the database instead of this; placeholder
    }

    public function uninstall(array $stepParams = [])
    {
        // add an uninstaller later
    }

    public function upgrade(array $stepParams = [])
    {
        // placeholder for an upgrader thing
    }
}
