<?php

namespace boost\envadmin;

use boost\multie\models\Settings;
use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use craft\web\UrlManager;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;
use yii\base\Event;

/**
 * Env Admin plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author Matthew De Jager <matthewdejager5@gmail.com>
 * @copyright Matthew De Jager
 * @license MIT
 */
class Plugin extends BasePlugin
{
    const HANDLE = 'env-admin';

    const PERMISSION_PLUGIN = 'accessPlugin-'.self::HANDLE;
    const PERMISSION_CREATE = self::HANDLE . '-create';
    const PERMISSION_EDIT = self::HANDLE . '-edit';
    const PERMISSION_DELETE = self::HANDLE . '-delete';

    /** @var string The plugin’s schema version number */
    public string $schemaVersion = '1.0.0';


    /**
     * Returns the base config that the plugin should be instantiated with.
     *
     * It is recommended that plugins define their internal components from here:
     *
     * ```php
     * public static function config(): array
     * {
     *     return [
     *         'components' => [
     *             'myComponent' => ['class' => MyComponent::class],
     *             // ...
     *         ],
     *     ];
     * }
     * ```
     *
     * Doing that enables projects to customize the components as needed, by
     * overriding `\craft\services\Plugins::$pluginConfigs` in `config/app.php`:
     *
     * ```php
     * return [
     *     'components' => [
     *         'plugins' => [
     *             'pluginConfigs' => [
     *                 'my-plugin' => [
     *                     'components' => [
     *                         'myComponent' => [
     *                             'myProperty' => 'foo',
     *                             // ...
     *                         ],
     *                     ],
     *                 ],
     *             ],
     *         ],
     *     ],
     * ];
     * ```
     *
     * The resulting config will be passed to `\Craft::createObject()` to instantiate the plugin.
     *
     * @return array
     */
    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    /**
     * Initializes the module.
     *
     * This method is called after the module is created and initialized with property values
     * given in configuration. The default implementation will initialize [[controllerNamespace]]
     * if it is not set.
     *
     * If you override this method, please make sure you call the parent implementation.
     */
    public function init(): void
    {
        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
        });

        // REGISTER SERVICES
//        $this->setComponents([
//
//        ]);
    }


    private function attachEventHandlers(): void
    {
        $this->_registerPermissions();
        $this->_registerNav();
        $this->_registerRoutes();
    }


    private function _registerNav() : void
    {
        // CP NAV
        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                if (Craft::$app->getUser()->checkPermission(self::PERMISSION_PLUGIN)) {
                    $event->navItems[] = [
                        'url' => self::HANDLE ,
                        'label' => 'ENV Admin',
                        'icon' => '@boost/multie/icon-mask.svg',
                    ];

                }
            }
        );
    }

    private function _registerRoutes() : void
    {
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            // ROUTES
            Event::on(
                UrlManager::class,
                UrlManager::EVENT_REGISTER_CP_URL_RULES,
                function (RegisterUrlRulesEvent $event) {
                    $event->rules[self::HANDLE] = self::HANDLE . '/env/index';
                }
            );
        }
    }
    private function _registerPermissions(): void
    {
        // PERMISSIONS
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function (RegisterUserPermissionsEvent $event) {
                $event->permissions[] = [
                    'heading' => 'ENV Admin',
                    'permissions' => [
                        self::PERMISSION_PLUGIN => [
                            'label' => \Craft::t('app','Manage Env Admin'),
                            'nested' => [
                                self::PERMISSION_EDIT => [
                                    'label' => \Craft::t('app','Update env variables'),
                                ],
                                self::PERMISSION_CREATE => [
                                    'label' => \Craft::t('app','Create env sections'),
                                ],
                                self::PERMISSION_DELETE => [
                                    'label' => \Craft::t('app','Delete env sections'),
                                ],
                            ]
                        ],
                    ],
                ];
            }
        );
    }
}
