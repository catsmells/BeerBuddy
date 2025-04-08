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

        $db = \XF::db();
        $content = preg_replace_callback(
            $beerRegex,
            function ($matches) use ($db) {
                $fullMatch = $matches[0];
                $beerName = strtolower($fullMatch);
                $cachedUrl = $db->fetchOne("SELECT url FROM xf_beerbuddy_cache WHERE beer_name = ?", $beerName);
                $url = $cachedUrl ?: 'https://www.beeradvocate.com/search/?q=' . urlencode($fullMatch) . '&qt=beer';

                // Aqua-inspired yellow badge style
                $style = 'display: inline-block; ' .
                         'background: linear-gradient(to bottom, #fffacd, #ffd700); ' . // Light yellow to gold gradient
                         'border: 1px solid #daa520; ' . // Goldenrod border
                         'border-radius: 12px; ' . // Rounded pill shape
                         'padding: 2px 8px; ' . // Cozy padding
                         'box-shadow: 0 1px 2px rgba(0,0,0,0.2), inset 0 1px 1px rgba(255,255,255,0.5); ' . // Shadow and highlight
                         'color: #333; ' . // Darker text for contrast
                         'text-decoration: none; ' . // No underline
                         'cursor: pointer; ' .
                         'font-weight: bold;';

                return '<span style="' . $style . '" onclick="window.open(\'' . htmlspecialchars($url) . '\', \'_blank\')">' . htmlspecialchars($fullMatch) . '</span>';
            },
            $message
        );

        $params['message'] = $content;
    }
}
