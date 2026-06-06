<?php
namespace Emagineurs\EMagineurs\Xclass;

/**
 * Class SelectViewHelper
 * @package Emagineurs\EMagineurs\Xclass
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper
{
    /**
     * Render the option tags.
     *
     * @param array $options the options for the form.
     * @return string rendered tags.
     */
    protected function renderOptionTags($options)
    {
        $output = '';

        $level = 0;
        $re = '/^(- )+/m';
        $first = true;
        $opened = false;

        $previousLabel = '';
        foreach ($options as $value => $label) {
            $prefix = '';

            // Group children
            if (!$first) {
                $matches = [];
                preg_match_all($re, $label, $matches, PREG_SET_ORDER, 0);
                if ($matches) {
                    $currentLevel = substr_count($matches[0][0], '-');
                } else {
                    $currentLevel = 0;
                }

                $label = preg_replace($re, '', $label);

                if ($currentLevel > $level && !$opened) {
                    $opened = true;
                    $groupLabel = $previousLabel;
                    $prefix = '<optgroup label=" ' . $groupLabel . ' ">' . LF;
                } elseif ($currentLevel < $level) {
                    $prefix = '</optgroup>' . LF;
                    $opened = false;
                }
            }

            $isSelected = $this->isSelected($value);
            $output .= $prefix . $this->renderOptionTag($value, $label, $isSelected) . LF;

            $level = $currentLevel;
            $first = false;
            $previousLabel = $label;
        }

        // Close tags
        if ($opened) {
            $output .= '</optgroup>';
        }

        return $output;
    }

    /**
     * Render one option tag
     *
     * @param string $value value attribute of the option tag (will be escaped)
     * @param string $label content of the option tag (will be escaped)
     * @param bool $isSelected specifies wheter or not to add selected attribute
     * @return string the rendered option tag
     */
    protected function renderOptionTag($value, $label, $isSelected)
    {
        $output = '<option value="' . htmlspecialchars($value) . '"';
        if ($isSelected) {
            $output .= ' selected="selected"';
        }
        $output .= '>' . htmlspecialchars($label) . '</option>';
        return $output;
    }
}
