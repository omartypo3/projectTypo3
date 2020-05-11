<?php /** @noinspection PhpUnusedParameterInspection */

namespace Cundd\CustomRest\Rest;

use Cundd\Rest\Handler\HandlerInterface;
use Cundd\Rest\Http\RestRequestInterface;
use Cundd\Rest\Router\Route;
use Cundd\Rest\Router\RouterInterface;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Example handler
 */
class Handler implements HandlerInterface
{
    /**
     * @var \Cundd\Rest\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * @var \Cundd\Rest\ResponseFactoryInterface
     * @inject
     */
    protected $responseFactory;

    /**
     * @var \Cundd\CustomRest\Rest\Helper
     * @inject
     */
    protected $helper;

    /**
     * @inheritDoc
     */
    public function configureRoutes(RouterInterface $router, RestRequestInterface $request)
    {
        /*------------------------------------------------------
         * Simple callback functions
         *-----------------------------------------------------*/

        /*
         * These custom handler example routes return hardcoded values. They do not call any
         * extbase controller functions. (For that, see PersonController and Routes below.)
         */

        # curl -X GET http://localhost:8888/rest/customhandler
        $router->add(
            Route::get(
                $request->getResourceType(),
                function (RestRequestInterface $request) {
                    return [
                        'path'         => $request->getPath(),
                        'uri'          => (string)$request->getUri(),
                        'resourceType' => (string)$request->getResourceType(),
                    ];
                }
            )
        );

        # curl -X GET http://localhost:8888/rest/customhandler/subpath
        $router->add(
            Route::get(
                $request->getResourceType() . '/subpath',
                function (RestRequestInterface $request) {
                    return [
                        'path'         => $request->getPath(),
                        'uri'          => (string)$request->getUri(),
                        'resourceType' => (string)$request->getResourceType(),
                    ];
                }
            )
        );

        # curl -X POST -d '{"username":"johndoe","password":"123456"}' http://localhost:8888/rest/customhandler/subpath
        $router->add(
            Route::post(
                $request->getResourceType() . '/subpath',
                function (RestRequestInterface $request) {
                    return [
                        'path'         => $request->getPath(),
                        'uri'          => (string)$request->getUri(),
                        'resourceType' => (string)$request->getResourceType(),
                        'data'         => $request->getSentData(),
                    ];
                }
            )
        );


        /*------------------------------------------------------
         * Sample Route for a "require" path
         *-----------------------------------------------------*/

        /*
         * To access this route a valid login is required.
         * This requirement is defined in ext_typoscript_setup.txt line 9
         */
        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-require
        $router->add(
            Route::get(
                'cundd-custom_rest-require',
                function () {
                    return 'Access Granted';
                }
            )
        );

        /*------------------------------------------------------
         * Sample Routes for Controller "Person"
         *-----------------------------------------------------*/

        /*
         * To define a new "base" route, a specific path is assigned to Route::get
         * instead of the universal $request->getResourceType(). Here it is the path
         * "/cundd-custom_rest-person"
         */

        /* ------------ GET ------------- */

        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-person/show/12
        $router->add(
            Route::get(
                '/cundd-custom_rest-content/{int}/?',
                function (RestRequestInterface $request, $pageUid) {
                    $arguments = [
                        'uid' => $pageUid,
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Content',
                        'show',
                        $arguments
                    );
                }
            )
        );
        /* ------------ GET ------------- */

        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-menu
        $router->add(
            Route::get(
                '/cundd-custom_rest-menu/constants/?',
                function (RestRequestInterface $request) {
                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Menu',
                        'menu',
                        []
                    );
                }
            )
        );

        /* ------------ GET ------------- */

        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-newsapp
        $router->add(
            Route::get(
                '/cundd-custom_rest-newsapp/?',
                function (RestRequestInterface $request) {
                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Dce',
                        'dce',
                        []
                    );
                }
            )
        );


        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-newsapp/12
        $router->add(
            Route::get(
                '/cundd-custom_rest-newsapp/{int}/?',
                function (RestRequestInterface $request, $pageUid) {
                    $arguments = [
                        'uid' => $pageUid,
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'News',
                        'show',
                        $arguments
                    );
                }
            )
        );

        /* ------------ POST ------------- */

        # curl -X POST -H "Content-Type: application/json" -d '{"firstName":"john","lastName":"john"}' http://localhost:8888/rest/customhandler/comment
        $router->add(
            Route::post(
                $request->getResourceType() . '/comment/?',
                function (RestRequestInterface $request) {
                    $arguments = [
                        'person' => $request->getSentData(),
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Person',
                        'create',
                        $arguments
                    );
                }
            )
        );
        # curl -X POST -H "Content-Type: application/json" -d '{"firstName":"john","lastName":"john"}' http://localhost:8888/rest/customhandler/reporter
        $router->add(
            Route::post(
                $request->getResourceType() . '/reporter/?',
                function (RestRequestInterface $request) {
                    $arguments = [
                        'person' => $request->getSentData(),
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Reporter',
                        'create',
                        $arguments
                    );
                }
            )
        );

        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-likes/12
        $router->add(
            Route::get(
                '/cundd-custom_rest-likes/{int}/?',
                function (RestRequestInterface $request, $pageUid) {
                    $arguments = [
                        'uid' => $pageUid,
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Dce',
                        'likes',
                        $arguments
                    );
                }
            )
        );
        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-dislikes/12
        $router->add(
            Route::get(
                '/cundd-custom_rest-dislikes/{int}/?',
                function (RestRequestInterface $request, $pageUid) {
                    $arguments = [
                        'uid' => $pageUid,
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Dce',
                        'dislikes',
                        $arguments
                    );
                }
            )
        );

        # curl -X POST -H "Content-Type: application/json" -d '{"firstName":"john","lastName":"john"}' http://localhost:8888/rest/customhandler/email
        $router->add(
            Route::post(
                $request->getResourceType() . '/email/?',
                function (RestRequestInterface $request) {
                    $arguments = [
                        'email' => $request->getSentData(),
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'Email',
                        'create',
                        $arguments
                    );
                }
            )
        );

        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-voteslike/12
        $router->add(
            Route::get(
                '/cundd-custom_rest-voteslike/{int}/?',
                function (RestRequestInterface $request, $pageUid) {
                    $arguments = [
                        'uid' => $pageUid,
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'News',
                        'voteslike',
                        $arguments
                    );
                }
            )
        );


        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-send/1
        $router->add(
            Route::post(
                '/cundd-custom_rest-send/?',
                function (RestRequestInterface $request) {
                    $arguments = [
                        /*'uid' => 4,
                        'field' => [
                            array(
                                'uid' => '1',
                                'value' => 'omar jmal'
                            ),
                            array(
                                'uid' => '1',
                                'value' => '1'
                            ),
                            array(
                                'uid' => '1',
                                'value' => '1'
                            ),
                        ]*/
                        'formdata'=>$request->getSentData()
                    ];

                    return $this->helper->callExtbasePlugin(
                        'customRest',
                        'Cundd',
                        'CustomRest',
                        'News',
                        'send',
                        $arguments
                    );
                }
            )
        );
    }
}
