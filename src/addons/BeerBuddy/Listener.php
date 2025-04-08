<?php

namespace BeerBuddy;

class Listener
{
    public static function postRender(\XF\Template\Templater $templater, &$content, $params)
    {
        if (!isset($params['message'])) {
            return;
        }

        $message = $params['message'];
        $beerRegex = '/\b([A-Za-z\s&-]+)\s+(Pale Ale|IPA|Stout|Lager|Porter|Ale|Draft|Draught|Beer|Red|Blonde|Amber|Wheat|Hefeweizen|Saison|Pilsner|Brown|Bock|Double|Triple|Imperial|Session|Barleywine|Witbier|Gose|Sour)\b/i';

        // Local cache for known beers (in production, just use the db)
        $beerCache = [
            'sierra nevada pale ale' => 'https://www.beeradvocate.com/beer/profile/140/276/',
            'guinness draught' => 'https://www.beeradvocate.com/beer/profile/209/1368/'
        ];

        $content = preg_replace_callback(
            $beerRegex,
            function ($matches) use ($beerCache) {
                $fullMatch = $matches[0];
                $beerName = strtolower($fullMatch);
                $url = isset($beerCache[$beerName]) 
                    ? $beerCache[$beerName] 
                    : 'https://www.beeradvocate.com/search/?q=' . urlencode($fullMatch) . '&qt=beer';

                return '<span style="background-color: #ffeb3b; cursor: pointer;" onclick="window.open(\'' . htmlspecialchars($url) . '\', \'_blank\')">' . htmlspecialchars($fullMatch) . '</span>';
            },
            $message
        );

        // Update the content
        $params['message'] = $content;
    }
}
