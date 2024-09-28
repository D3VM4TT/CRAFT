<?php

namespace boost\envadmin\controllers;

use boost\envadmin\Plugin;
use Craft;
use craft\web\Controller;

class EnvController extends Controller
{
    const DEFAULT_SITE_HANDLE = 'default';

    // ACTIONS
//    const ACTION_UPDATE_STATUS = self::PATH . '/update-status';
//    const ACTION_UPDATE_ENTRY_TYPES = self::PATH . '/update-entry-types';
//    const ACTION_COPY_SETTINGS = self::PATH . '/copy-settings';
//    const ACTION_UPDATE_PROPAGATION_METHOD = self::PATH . '/update-propagation-method';


    public function actionIndex(): \yii\web\Response
    {

        $envPath = Craft::getAlias('@root/.env');
        $envContent = file_get_contents($envPath);

// Process the contents (e.g., parse into key-value pairs)
        $envLines = explode("\n", $envContent);
        $envVars = [];

        foreach ($envLines as $line) {
            if (!empty($line) && strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $envVars[$key] = $value;
            }
        }

        dd($envVars);
    }

}
