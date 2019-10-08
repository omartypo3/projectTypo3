<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 14.08.2018
 * Time: 15:42
 */

namespace Pingag\PingagRealEstate\Service;

use Pingag\PingagRealEstate\Domain\Model\RealEstate;
use Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository;
use Pingag\PingagRealEstate\Form\RealEstateFilter;
use Pingag\PingagRealEstate\Util\GeneralUtil;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class RealEstateOptionFactory
{

    /**
     * @var \Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository
     * @inject
     */
    protected $realEstateRepository;

    protected $simpleProperties = [
        'offerType',
        'objectCategory',
        'floor'
    ];
    
    protected $options = [];

    /**
     * RealEstateOptionFactory constructor.
     */
    public function __construct()
    {
        $this->realEstateRepository = GeneralUtility::makeInstance(RealEstateRepository::class);
    }

    public function getFilterOptions(RealEstateFilter $realEstateFilter)
    {
        $selectedCategory = $realEstateFilter->getObjectCategory();
        $this->options = $this->getSimpleSelectOptions();
        
        if($selectedCategory && $selectedCategory !== RealEstateFilter::SELECT_ALL_KEYWORD){
            $this->buildObjectTypesByCategory($selectedCategory);
        }

        $properties = $realEstateFilter->getProperties();
        foreach (RealEstate::REAL_ESTATE_PROPERTIES as $property){
            $getter = RealEstate::propertyGetter($property);
            $this->options['properties'][$property] = in_array($property, $properties);
        }
        
        $this->options['priceMax'] = 10000;
        $this->options['priceStep'] = 50;
        if($realEstateFilter->getOfferType() == 'SALE'){
            $this->options['priceMax'] = 10000000;
            $this->options['priceStep'] = 1000;
        }
        
        return $this->options;
    }
    
    protected function getSimpleSelectOptions()
    {
        $filterOptions = [];
        foreach ($this->simpleProperties as $property) {
            if (is_array($property)) {
                continue;
            }
            $fieldName = GeneralUtil::camelCaseToSnake($property);
            $options = $this->realEstateRepository->getGroupedFieldValues($fieldName);

            foreach ($options as $option) {
                $optionLabel = $this->translateOption($property, $option);
                $filterOptions[$property][] = [
                    'value' => $option,
                    'label' => $optionLabel,
                ];
            }
        }
        return $filterOptions;
    }
    
    protected function buildObjectTypesByCategory($category)
    {
        $objectTypes = [];
        $condition = "object_category = '{$category}'";
        $types = $this->realEstateRepository->getGroupedFieldValues('object_type', $condition);
        
        foreach ($types as $type){
            $label = $this->translateOption('objectType', $category . '.' . $type);
            $this->options['objectType'][] = [
                'value' => $type,
                'label' => $label,
            ];
        }
    }
    
    // helper methods
    
    protected function translateOption($property, $option)
    {
        $translateFormat = 'realEstateOptions.%s.%s';
        $id = sprintf($translateFormat, $property, $option);
        return GeneralUtil::translate($id);
    }
}