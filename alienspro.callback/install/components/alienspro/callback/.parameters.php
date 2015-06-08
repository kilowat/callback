<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "CALLBACK_FORM", "ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["CALLBACK"];

$arComponentParameters = array(
	"PARAMETERS" => array(
		"USE_CAPTCHA" => Array(
			"NAME" => GetMessage("MFP_CAPTCHA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
                "USE_THEME"=>array(
                    "NAME" => GetMessage("USE_THEME"), 
                    "TYPE" => "CHECKBOX",
                    "PARENT" => "BASE",
                    "DEFAULT" => "Y"),
               "USE_EMAIL"=>array(
                    "NAME" => GetMessage("USE_EMAIL"), 
                    "TYPE" => "CHECKBOX",
                    "PARENT" => "BASE",
                    "DEFAULT" => "Y"),
               "USE_DATE"=>array(
                    "NAME" => GetMessage("USE_DATE"), 
                    "TYPE" => "CHECKBOX",
                    "PARENT" => "BASE",
                    "DEFAULT" => "Y"),
               "USE_TIME"=>array(
                    "NAME" => GetMessage("USE_TIME"), 
                    "TYPE" => "CHECKBOX",
                    "PARENT" => "BASE",
                    "DEFAULT" => "Y"),
		"OK_TEXT" => Array(
			"NAME" => GetMessage("MFP_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MFP_OK_TEXT"), 
			"PARENT" => "BASE",
		),
                "TIME_BEFORE" => Array(
			"NAME" => GetMessage("TIME_BEFORE"), 
			"TYPE" => "INTEGER",
			"DEFAULT" => 8, 
			"PARENT" => "BASE",
		),
                "TIME_AFTER" => Array(
			"NAME" => GetMessage("TIME_AFTER"), 
			"TYPE" => "INTEGER",
			"DEFAULT" => 18, 
			"PARENT" => "BASE",
		),
                "USE_JQUERY" => Array(
			"NAME" => GetMessage("USE_JQUERY"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"EMAIL_TO" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TO"), 
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
			"PARENT" => "BASE",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("MFP_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => Array("NONE" => GetMessage("MFP_ALL_REQ"), "NAME" => GetMessage("MFP_NAME"), "EMAIL" => "E-mail","PHONE" => GetMessage("MFP_PHONE")),
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),

		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"Y", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),

	)
);

?>