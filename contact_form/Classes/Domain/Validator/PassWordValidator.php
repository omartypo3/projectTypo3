<?php
namespace LeadGeneration\ContactForm\Domain\Validator;
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 20/10/2018
 * Time: 11:36
 */

class PassWordValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
/**
* @param array $value
* @return void
*/

    protected function isValid($value) {
        // get the option for the validation
        $minimumLength = 6;

        // check for password length
        if($value[1]== '') {
            $this->addError('Please enter Password ' , 1221560718);
        }
        // check for password length
        if(strlen($value[1]) < $minimumLength && ($value[1] != '')) {
            $this->addError('The password is to short, minimum length is ' . $minimumLength, 1221560718);
        }

        // check that the passwords are the same
        if(strcmp($value[1], $value[2]) != 0 && ($value[2] != '') && ($value[1] != '')) {
            $this->addError('The password do not match!', 1221560718);
        }
    }
}