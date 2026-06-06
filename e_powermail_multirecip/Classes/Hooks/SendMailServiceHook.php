<?php

declare(strict_types=1);

namespace Emagineurs\EPowermailMultirecip\Hooks;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hook to add BCC recipients based on multirecipients field selection
 * 
 * This hook processes Powermail form submissions and adds BCC recipients
 * based on the selected option in multirecipients fields.
 */
class SendMailServiceHook 
{
    protected ConnectionPool $connectionPool;

    public function __construct(?ConnectionPool $connectionPool = null)
    {
        $this->connectionPool = $connectionPool ?? GeneralUtility::makeInstance(ConnectionPool::class);
    }

    /**
     * Set receiver emails based on multirecipients field selection
     * 
     * @param object $message The email message object
     * @param object|null $emailParent The email parent object (unused, kept for backward compatibility)
     * @param object $parent The parent object containing the mail
     * @return void
     */
    public function setReceiverEmailsSignal($message, $emailParent, $parent): void
    {
        $mail = $parent->getMail();
        $emailArray = [];
      
        foreach ($mail->getAnswers() as $answer) {
            $properties = $answer->_getProperties();
            if (!isset($properties['field'])) {
                continue;
            }
            
            $field = $properties['field'];
           
            if ($field->getType() === 'multirecipients') {
                $value = $answer->getValue();
                $id = $field->getUid();
               
                // Use QueryBuilder instead of deprecated $GLOBALS['TYPO3_DB']
                $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_powermail_domain_model_field');
                $queryBuilder->getRestrictions()->removeAll();
                
                $result = $queryBuilder
                    ->select('*')
                    ->from('tx_powermail_domain_model_field')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT))
                    )
                    ->executeQuery()
                    ->fetchAssociative();

                if ($result && isset($result['optionsmails']) && isset($result['settings'])) {
                    $optionMails = (string)$result['optionsmails'];
                    $options = (string)$result['settings'];
                   
                    $tabMail = array_map('trim', explode("\n", $optionMails));
                    $tabValue = array_map('trim', explode("\n", $options));
       
                    // Find matching option and corresponding email
                    $mykey = null;
                    foreach ($tabValue as $key => $option) {
                        $option = trim($option);
                        if (trim((string)$value) === $option) {
                            $mykey = $key;
                            break;
                        }
                    }
                   
                    if ($mykey !== null && isset($tabMail[$mykey])) {
                        $cc = trim($tabMail[$mykey]);
                        if (!empty($cc)) {
                            // Preserve existing behavior: use email as key and value as value
                            $emailArray[$cc] = $value;
                        }
                    }
                }
            }
        }
        
        // Merge with existing BCC recipients
        if (!empty($emailArray)) {
            $configuredRecipientsArray = $message->getBcc() ?? [];
           
            if (is_array($configuredRecipientsArray)) {
                $newRecipientsArray = array_merge($configuredRecipientsArray, $emailArray);
            } else {
                $newRecipientsArray = $emailArray;
            }
           
            $message->setBcc($newRecipientsArray);
        }
    }
}



