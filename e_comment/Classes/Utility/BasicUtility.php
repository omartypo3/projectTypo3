<?php
namespace Emagineurs\EComment\Utility;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class BasicUtility
{
    /*
     * Create a random string
     * @param $length the length of the string to create
     * @return $str the string
     */
    public static function randomString($length = 20) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /**
     * Send an email using template to generate the body text
     *
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     * @return boolean TRUE on success, otherwise false
     */
    public static function sendTemplateEmail(array $recipient, array $sender, $subject, $template, array $variables = array()) {
        /** @var StandaloneView $emailView */
        $emailView = GeneralUtility::makeInstance(StandaloneView::class);
        $emailView->setFormat('html');
        $emailView->setTemplatePathAndFilename($template);
        $emailView->assignMultiple($variables);
        $serverRequest = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if ($serverRequest instanceof ServerRequestInterface) {
            $emailView->getRenderingContext()->setRequest($serverRequest);
        }
        $emailBody = $emailView->render();

        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource($subject);
        $view->assignMultiple($variables);
        if ($serverRequest instanceof ServerRequestInterface) {
            $view->getRenderingContext()->setRequest($serverRequest);
        }
        $subject = $view->render();

        /** @var MailMessage $message */
        $message = GeneralUtility::makeInstance(MailMessage::class);
        $message->setTo($recipient)->setFrom($sender)->setSubject($subject);

        $message->html($emailBody);

        $message->send();
        return $message->isSent();
    }

    /**
     * Parse string like begin[step1][step2]
     *
     * @param string $str
     * @return array like ['begin', 'step1', 'step2']
     */
    public static function parseParamPath($str) {
        if(empty($str)) {
            return array();
        }

        return explode('.', preg_replace('/\[(\w+)\]/i', '.${1}', $str));
    }

    /**
     * Parse string like begin[step1][step2]
     *
     * @param array $array
     * @param array $path
     * @return mixed value
     */
    public static function traverseArrayByPath($array, $path) {
        if(count($path) == 0) {
            return $array;
        } else {
            $key = array_shift($path);

            if(count($path) == 0) {
                return isset($array[$key]) ? $array[$key] : null;
            } else {
                return (isset($array[$key]) AND is_array($array[$key])) ? self::traverseArrayByPath($array[$key], $path) : null;
            }
        }
    }

    /**
     * Get post/get var using path string like begin[step1][step2]
     *
     * @param string $path
     * @return mixed value
     */
    public static function getParamByStringPath($path) {
        $path = self::parseParamPath($path);
        $key = array_shift($path);
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if ($request instanceof \Psr\Http\Message\ServerRequestInterface) {
            $bodyParams = $request->getParsedBody() ?? [];
            $queryParams = $request->getQueryParams() ?? [];
            $allParams = is_array($bodyParams) ? array_merge($queryParams, $bodyParams) : $queryParams;
        } else {
            $allParams = array_merge($_GET ?? [], $_POST ?? []);
        }
        $param = $allParams[$key] ?? null;

        if(!empty($param)) {
            return self::traverseArrayByPath($param, $path);
        } else {
            return null;
        }
    }
}