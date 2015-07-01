<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/***********************************************************/
if(!CModule::IncludeModule("alienspro.callback")){
	echo 'WORNING! callback_module not find';
	exit;
}
 
/***********************************************************/

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

/**reload captch**/
if($_POST['reload_captcha']=='y'){
	$GLOBALS['APPLICATION']->RestartBuffer();
	echo json_encode($arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode()));
	die();
}
/*********************/

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());
$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "CALLBACK";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if($arParams["USE_THEME"]=="Y"){
	$dbrs = callback::getListTheme();
	while ($result = $dbrs->getNext()){
		$arResult["THEME_LIST"][]=array("id"=>$result["id"],"name"=>$result["name"]);
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"  && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])){
	$arResult["ERROR_MESSAGE"] = array();
	if(check_bitrix_sessid()){
		if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
		{
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1){
				$arResult["ERROR_MESSAGE"]["COSTUM_ERROR"]["user_name"] = true;
				$arResult["ERROR_MESSAGE"]["NAME"] =  GetMessage("MF_REQ_NAME");		
			}
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1&& $arParams["USE_EMAIL"] == "Y"){
				$arResult["ERROR_MESSAGE"]["COSTUM_ERROR"]["user_email"] = true;
				$arResult["ERROR_MESSAGE"]["EMAIL"] =  GetMessage("MF_REQ_EMAIL");	
				
			}   
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_phone"]) <= 1){
				$arResult["ERROR_MESSAGE"]["COSTUM_ERROR"]["user_phone"] = true;
				$arResult["ERROR_MESSAGE"]["PHONE"] =  GetMessage("MF_REQ_PHONE");	
			}

		}
		if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"])){
			$arResult["ERROR_MESSAGE"]["COSTUM_ERROR"]["EMAIL_VALID"] = true;
			$arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
		}
		if($arParams["USE_CAPTCHA"] == "Y")
		{
			include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
			$captcha_code = $_POST["captcha_sid"];
			$captcha_word = $_POST["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
			{
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass)){
					$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
					$arResult["ERROR_MESSAGE"]["COSTUM_ERROR"]["captcha_sid"] = true;
				}
			}
			else{
					$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");
					$arResult["ERROR_MESSAGE"]["COSTUM_ERROR"]["captcha_word"] = true;
				}

		}	
		if(empty($arResult["ERROR_MESSAGE"]))
		{       
			$curUser=null;
			if($USER->GetLogin()!==null){
				$curUser = ' ['.$USER->GetLogin().']'; 
			}
			$arFields = Array(
				"AUTHOR" => $_POST["user_name"].$curUser,
				"AUTHOR_EMAIL" => $_POST["user_email"],
				"EMAIL_TO" => $arParams["EMAIL_TO"],
				"PHONE" => $_POST["user_phone"],
				"THEME" => $_POST["user_theme"],
				"TIME" => $_POST["user_time"],
			);                      
			callback::addMsg($arFields["AUTHOR"], $arFields["PHONE"], $arFields["TIME"], $arFields["THEME"],$arFields["AUTHOR_EMAIL"]);
			if(!empty($arParams["EVENT_MESSAGE_ID"]))
			{
				foreach($arParams["EVENT_MESSAGE_ID"] as $v)
					if(IntVal($v) > 0)
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
			}
			else
				CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
				$_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
				$_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
				
		}
		
		$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);

	}
	else
		$arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}

elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"])
{
	$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
	if($USER->IsAuthorized())
	{
		$arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
	}
	else
	{
		if(strlen($_SESSION["MF_NAME"]) > 0)
			$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
		if(strlen($_SESSION["MF_EMAIL"]) > 0)
			$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
	}
}


if($arParams["USE_CAPTCHA"] == "Y" && $_POST['reload_captcha']!='y')
	$arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

if($_POST['ajax']=='y' && count($arResult ["ERROR_MESSAGE"]["COSTUM_ERROR"]) > 0){
	$arResult ["ERROR_MESSAGE"]["COSTUM_ERROR"]['success']='no';
	$GLOBALS['APPLICATION']->RestartBuffer();
	echo json_encode($arResult ["ERROR_MESSAGE"]["COSTUM_ERROR"]);
	die();
}
if($_POST['ajax']=='y' && count($arResult ["ERROR_MESSAGE"]["COSTUM_ERROR"]) == 0){
		$GLOBALS['APPLICATION']->RestartBuffer();
		echo json_encode(array('success'=>$arParams["OK_TEXT"]));
		die();
}
if($_POST['ajax']!='y')
	$this->IncludeComponentTemplate();
?>
