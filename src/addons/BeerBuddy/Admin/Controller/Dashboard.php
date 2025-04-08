<?php

namespace BeerBuddy\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Dashboard extends AbstractController
{
    public function actionIndex()
    {
        $beerRepo = $this->em()->getRepository('BeerBuddy:BeerCache');
        $beers = $beerRepo->find()->fetch();

        $viewParams = [
            'beers' => $beers
        ];
        return $this->view('BeerBuddy:Dashboard', 'beerbuddy_dashboard', $viewParams);
    }

    public function actionAdd()
    {
        if ($this->isPost()) {
            $beerName = $this->filter('beer_name', 'str');
            $url = $this->filter('url', 'str');

            $beer = $this->em()->create('BeerBuddy:BeerCache');
            $beer->beer_name = strtolower($beerName);
            $beer->url = $url;
            $beer->save();

            return $this->redirect($this->buildLink('beerbuddy'));
        }

        return $this->view('BeerBuddy:Dashboard\Add', 'beerbuddy_add');
    }

    public function actionEdit(ParameterBag $params)
    {
        $beer = $this->assertBeerExists($params->beer_name);
        if ($this->isPost()) {
            $beer->url = $this->filter('url', 'str');
            $beer->save();
            return $this->redirect($this->buildLink('beerbuddy'));
        }

        return $this->view('BeerBuddy:Dashboard\Edit', 'beerbuddy_edit', ['beer' => $beer]);
    }

    public function actionDelete(ParameterBag $params)
    {
        $beer = $this->assertBeerExists($params->beer_name);
        if ($this->isPost()) {
            $beer->delete();
            return $this->redirect($this->buildLink('beerbuddy'));
        }

        return $this->view('BeerBuddy:Dashboard\Delete', 'beerbuddy_delete', ['beer' => $beer]);
    }

    protected function assertBeerExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('BeerBuddy:BeerCache', $id, $with, $phraseKey);
    }
}
