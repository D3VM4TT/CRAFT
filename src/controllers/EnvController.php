<?php

namespace boost\envadmin\controllers;

use boost\envadmin\Plugin;
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

        dd('test');
//        /** @var SectionsService $sectionsService */
//        $sectionsService = EnvAdmin::getInstance()->section;
//
//        $sections = $sectionsService->getSectionsByType($type);
//        $columns = SectionSiteSettingsVueAdminTableHelper::columns();
//        $tableData = SectionSiteSettingsVueAdminTableHelper::data($sections);
//        $actions = Craft::$app->user->checkPermission(EnvAdmin::PERMISSION_CREATE) ?
//            SectionSiteSettingsVueAdminTableHelper::actions() :
//            false;
//
//        return $this->renderTemplate(self::PATH . '/site-settings.twig', [
//            'tableData' => $tableData,
//            'actions' => $actions,
//            'columns' => $columns,
//            'sectionTypes' => SectionTypes::getSectionTypes(),
//        ]);
    }

}
