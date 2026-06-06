<?php
namespace Emagineurs\EPackage\Hooks;

/*  | This extension is made for TYPO3 CMS and is licensed
 *  | under GNU General Public License.
 *  |
 *  | (c) 2016-2017 Markus Klein, Reelworx GmbH https://reelworx.at/
 *  |     2016-2017 Armin Vieweg <armin@v.ieweg.de>
 */
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Backend\Template\Components\Buttons\SplitButton;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Xclass SplitButton to change rendering
 */
class UnrolledSplitButton extends SplitButton
{
    /**
     * Renders the better configured SplitButton
     *
     * @return string
     */
    public function render()
    {
        $defaultSettings = [
            'buttons' => '_savedok,_savedokview,_savedoknew,_saveandclosedok',
            'unroll' => '1',
            'hideLabelSave' => '1',
            'hideLabelSaveDokView' => '1',
            'hideLabelSaveAndClose' => '1',
            'hideLabelSaveAndNew' => '1',
        ];
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['unroll']);
        if (!is_array($settings)) {
            $settings = [];
        }
        $settings = array_merge($defaultSettings, $settings);

        // Get flat array of buttons. Button name is key in array.
        $buttonsByName = $this->getButtonsByName();
        $hideButtonLabels = [];
        if ($settings['hideLabelSave']) {
            $hideButtonLabels[] = '_savedok';
        }
        if ($settings['hideLabelSaveDokView']) {
            $hideButtonLabels[] = '_savedokview';
        }
        if ($settings['hideLabelSaveAndClose']) {
            $hideButtonLabels[] = '_saveandclosedok';
        }
        if ($settings['hideLabelSaveAndNew']) {
            $hideButtonLabels[] = '_savedoknew';
        }
        $settings['buttons'] = '_savedok,_savedokview,_savedoknew,_saveandclosedok';
        // Get flat array of buttons in new order
        $newOrderedButtons = [];
        foreach (GeneralUtility::trimExplode(',', $settings['buttons'], true) as $buttonName) {
            if (isset($buttonsByName[$buttonName])) {
                $newOrderedButtons[] = $buttonsByName[$buttonName];
                unset($buttonsByName[$buttonName]);
            }
        }
        $newOrderedButtonsOriginal = array_merge($newOrderedButtons, $buttonsByName);
        $buttons = array_merge($newOrderedButtons, $buttonsByName);
        // Change button order in configuration
        $this->items = ['primary' => array_shift($buttons), 'options' => $buttons];


        if ((bool) $settings['unroll']) {
            // This code is originally from EXT:rx_unrollsavebuttons ("Unroll TYPO3 save buttons") by Markus Klein
            // Url: https://typo3.org/extensions/repository/view/rx_unrollsavebuttons
            $content = '';
            /** @var InputButton $button */
            foreach ($newOrderedButtonsOriginal as $button) {
                $attributes = [
                    'type' => 'submit',
                    'class' => 'btn btn-sm btn-default ' . $button->getClasses(),
                    'name' => $button->getName(),
                    'value' => $button->getValue()
                ];
                $onClick = $button->getOnClick();
                if ($onClick) {
                    $attributes['onclick'] = $onClick;
                }
                $form = $button->getForm();
                if ($form) {
                    $attributes['form'] = $form;
                }
                $buttonTitle = $button->getTitle();
                if (in_array($button->getName(), $hideButtonLabels)) {
                    $attributes['title'] = $buttonTitle;
                    $buttonTitle = '';
                }
                $optionAttributesString = '';
                foreach ($attributes as $key => $value) {
                    $optionAttributesString .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
                }
                $content .= '<button' . $optionAttributesString . '> ' .
                    $button->getIcon()->render() . ' ' . htmlspecialchars($buttonTitle) .
                    '</button>';
            }
            return '<div class="btn-group">' . $content . '</div>';
        }
        return parent::render();
    }

    /**
     * @return InputButton[] name attribute is key of array
     */
    protected function getButtonsByName()
    {
        $items = $this->getButton();
        /** @var InputButton[] $buttons */
        $buttons = array_merge([$items['primary'] ], $items['options']);
        $buttonsByName = [];
        foreach ($buttons as $button) {
            $key = $button->getName();
            if ($button->getValue() != '1') {
                $key = $button->getValue();
            }
            $buttonsByName[$key] = $button;
        }
        return $buttonsByName;
    }
}
