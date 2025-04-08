<?php

namespace BeerBuddy;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUninstallTrait;
    use StepRunnerUpgradeTrait;

    public function installStep1()
    {
        $this->schema()->createTable('xf_beerbuddy_cache', function ($table) {
            $table->addColumn('beer_name', 'varchar', 255)->primaryKey();
            $table->addColumn('url', 'text');
        });
    }

    public function uninstallStep1()
    {
        $this->schema()->dropTable('xf_beerbuddy_cache');
    }
}
