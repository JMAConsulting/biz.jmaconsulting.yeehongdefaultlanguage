<?php

require_once 'yeehongdefaultpreferredlanguage.civix.php';
use CRM_Yeehongdefaultpreferredlanguage_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function yeehongdefaultpreferredlanguage_civicrm_config(&$config) {
  _yeehongdefaultpreferredlanguage_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function yeehongdefaultpreferredlanguage_civicrm_xmlMenu(&$files) {
  _yeehongdefaultpreferredlanguage_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function yeehongdefaultpreferredlanguage_civicrm_install() {
  _yeehongdefaultpreferredlanguage_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function yeehongdefaultpreferredlanguage_civicrm_postInstall() {
  _yeehongdefaultpreferredlanguage_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function yeehongdefaultpreferredlanguage_civicrm_uninstall() {
  _yeehongdefaultpreferredlanguage_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function yeehongdefaultpreferredlanguage_civicrm_enable() {
  _yeehongdefaultpreferredlanguage_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function yeehongdefaultpreferredlanguage_civicrm_disable() {
  _yeehongdefaultpreferredlanguage_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function yeehongdefaultpreferredlanguage_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _yeehongdefaultpreferredlanguage_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function yeehongdefaultpreferredlanguage_civicrm_managed(&$entities) {
  _yeehongdefaultpreferredlanguage_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function yeehongdefaultpreferredlanguage_civicrm_caseTypes(&$caseTypes) {
  _yeehongdefaultpreferredlanguage_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function yeehongdefaultpreferredlanguage_civicrm_angularModules(&$angularModules) {
  _yeehongdefaultpreferredlanguage_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function yeehongdefaultpreferredlanguage_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _yeehongdefaultpreferredlanguage_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_pre().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pre
 */
function yeehongdefaultpreferredlanguage_civicrm_pre($op, $objectName, $id, &$params) {
  if (strtolower($op) == 'create'
    && in_array(
      strtolower($objectName),
      [
        'contact',
        'individual' ,
        'organization',
        'household'
      ]
    )
  ) {
    if (empty($params['preferred_language'])) {
      $params['preferred_language'] = yeehongdefaultpreferredlanguage_getDefaultLanguage();
    }
  }
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function yeehongdefaultpreferredlanguage_civicrm_buildForm($formName, &$form) {
  if ('CRM_Contact_Form_Contact' == $formName
    && $form->_action & CRM_Core_Action::ADD
  ) {
    $defaults['preferred_language']= yeehongdefaultpreferredlanguage_getDefaultLanguage();
    $form->setDefaults($defaults);
  }

  if ('CRM_Admin_Form_Options' == $formName
    && $form->getVar('_gName') == 'languages'
  ) {
    $form->add('checkbox', 'is_default', ts('Default Option?'));
    $form->assign('showDefault', TRUE);
  }
}

/*
*  Get default Preferred language.
*
* @return string
*/
function yeehongdefaultpreferredlanguage_getDefaultLanguage() {
  $preferredLanguage = CRM_Contact_DAO_Contact::buildOptions(
    'preferred_language',
    'validate',
    ['condition' => ' v.is_default = 1 ']
  );
  return reset($preferredLanguage);
}
