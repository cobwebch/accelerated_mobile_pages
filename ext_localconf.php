<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Cobweb.' . $_EXTKEY,
	'Ad',
	array('Ad' => 'show'),
	array()
);


$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_eofe']['amp'] = 'Cobweb\\AcceleratedMobilePages\\Hooks\\AmpHooks->hook_eofe';