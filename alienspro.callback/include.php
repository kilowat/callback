<?
global $DB;
$db_type = strtolower($DB->type);
CModule::AddAutoloadClasses(
    'alienspro_callback',
    array(
		'callbackGeneral' => 'classes/general/callback.php',
    'callback' => 'classes/".$db_type."/callback.php',


        )
);
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/classes/".$db_type."/callback.php");

?>