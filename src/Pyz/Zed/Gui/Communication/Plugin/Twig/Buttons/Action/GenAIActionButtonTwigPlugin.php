<?php


namespace Pyz\Zed\Gui\Communication\Plugin\Twig\Buttons\Action;

use Spryker\Zed\Gui\Communication\Plugin\Twig\Buttons\AbstractButtonTwig;

/**
 * @method \Spryker\Zed\Gui\GuiConfig getConfig()
 * @method \Spryker\Zed\Gui\Communication\GuiCommunicationFactory getFactory()
 */
class GenAIActionButtonTwigPlugin extends AbstractButtonTwig
{
    /**
     * @return string
     */
    protected function getFunctionName(): string
    {
        return 'genAIActionButton';
    }

    /**
     * @return string
     */
    protected function getButtonClass(): string
    {
        return 'btn-edit';
    }

    /**
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" style="vertical-align: middle; margin-right: 4px;">
        <path d="M20 10.0196C14.6358 10.3431 10.3431 14.6358 10.0196 20H9.98042C9.65687 14.6358 5.36425 10.3431 0 10.0196V9.98043C5.36425 9.65688 9.65687 5.36424 9.98042 0H10.0196C10.3431 5.36424 14.6358 9.65688 20 9.98043V10.0196Z" fill="url(#paint0_radial_809_11874)"/>
        <defs>
            <radialGradient id="paint0_radial_809_11874" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(-6.13727 9.97493) scale(21.6266 172.607)">
                <stop offset="0.385135" stop-color="#9E72BA"/>
                <stop offset="0.734299" stop-color="#D65C67"/>
                <stop offset="0.931035" stop-color="#D6635C"/>
            </radialGradient>
        </defs>
        </svg>';
    }

    /**
     * @return string
     */
    protected function getButtonDefaultClass(): string
    {
        return 'btn-sm btn-outline safe-submit';
    }
}
