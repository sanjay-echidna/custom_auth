<?php
namespace Pyz\Shared\Twig;

use Spryker\Shared\Twig\TwigConfig as SprykerTwigConfig;

class TwigConfig extends SprykerTwigConfig
{
    /**
     * @return string
     */
    public function getYvesThemeName(): string
    {
        return 'echidna';
    }
}