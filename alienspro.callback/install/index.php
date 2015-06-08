<?
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/alienspro.callback/install/index.php");
IncludeModuleLangFile(__FILE__);

Class alienspro_callback extends CModule{
	var $MODULE_ID = "alienspro.callback";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function alienspro_callback(){
    $this->PARTNER_NAME = "ALIENS.PRO"; 
    $this->PARTNER_URI = "http://www.aliens.pro";
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_NAME = GetMessage("CALLBACK_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("CALLBACK_DESC");
	}

	function InstallFiles($arParams = array()){
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);
		CopyDirFiles( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/alienspro.callback/install/themes/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes', true, true );
		CopyDirFiles( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/alienspro.callback/install/gadgets/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/gadgets', true, true );
    return true;
	}

	function InstallDB($arParams = array()){
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;
		$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/install/db/".strtolower($DB->type)."/install.sql");

		if($this->errors !== false){
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		else{
			return true;
		}
	}
	  
	function UnInstallDB($arParams = array()){
		global $DB, $DBType, $APPLICATION;
		$this->errors = false;
		$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/install/db/".strtolower($DB->type)."/uninstall.sql");
		if($this->errors !== false){
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		return true;
	}
			
	function UnInstallFiles(){
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		DeleteDirFilesEx("/bitrix/components/alienspro/");
		DeleteDirFiles( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/alienspro.callback/install/themes/.default/' , $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default' );  
		DeleteDirFilesEx( '/bitrix/themes/.default/icons/callback' );
		DeleteDirFilesEx("/bitrix/gadgets/alienspro/");
    return true;
	}
	  
	function EmailEventsInstall(){
		$oEventType = new CEventType();
		$oEventType->Add( array(
			'LID' => 'ru',
			'EVENT_NAME' => 'CALLBACK_FORM',
			'NAME' => GetMessage("CALLBACK_NAME"),
			'DESCRIPTION' => 
				"#AUTHOR# - ".GetMessage('CALLBACK_AUTHOR').",
				#AUTHOR_EMAIL# - ".GetMessage('CALLBACK_AUTHOR_EMAIL').",
				#PHONE# - ".GetMessage('CALLBACK_PHONE').",
				#THEME# - ".GetMessage('CALLBACK_THEME').",
				#TIME# - ".GetMessage('CALLBACK_TIME')
		) );
		$oEventMessage  = new CEventMessage();
		$arrSites = array();
		$objSites = CSite::GetList();
		while ($arrSite = $objSites->Fetch())
			$arrSites[] = $arrSite["ID"];
		$oEventMessage->Add( array(
			'ACTIVE'    => 'Y',
			'EVENT_NAME'    => "CALLBACK_FORM",
			'LID'           => $arrSites,
			'EMAIL_FROM'    => "#DEFAULT_EMAIL_FROM#",
			'EMAIL_TO'      => "#EMAIL_TO#",
			'SUBJECT'       => GetMessage('CALLBACK_SUBJECT')." #SITE_NAME#",
			'MESSAGE'       => GetMessage('CALLBACK_MESSAGE')." #SITE_NAME#<br>"
								.GetMessage('CALLBACK_AUTHOR').": #AUTHOR#<br>"
								.GetMessage('CALLBACK_AUTHOR_EMAIL').": #AUTHOR_EMAIL#<br>"
								.GetMessage('CALLBACK_PHONE').": #PHONE#<br>"
								.GetMessage('CALLBACK_THEME').": #THEME#<br>"
								.GetMessage('CALLBACK_TIME').":#TIME#<br>",
			'BODY_TYPE'     => 'html',
		) );
		return true;
	}
	  
	function EmailEventsUninstall(){
		$arFilter = array("TYPE_ID"=>"CALLBACK_FORM");
		$oEventMessage  = new CEventMessage();
		$arTypes= CEventMessage::GetList($by="site_id", $order="desc", $arFilter);

		if(!empty($arTypes)){
			while($arType = $arTypes->GetNext()){
				$oEventMessage->Delete($arType["ID"]);        
			}         
		}
		$oEventType = new CEventType();
		$oEventType->Delete(array("EVENT_NAME"=>"CALLBACK_FORM"));
		return true;  
	}

	function DoInstall(){
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallFiles();               
		RegisterModule("alienspro.callback");
		$this->InstallDB(false);
		$this->EmailEventsInstall();
		$APPLICATION->IncludeAdminFile(GetMessage("CALLBACK_INSTALL_OK"), $DOCUMENT_ROOT."/bitrix/modules/alienspro.callback/install/step.php");
		return true;
	}

	function DoUninstall(){
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallDB();
		$this->UnInstallFiles();
		UnRegisterModule("alienspro.callback");
		$this->EmailEventsUninstall();
		$APPLICATION->IncludeAdminFile(GetMessage("CALLBACK_UNINSTALL_OK"), $DOCUMENT_ROOT."/bitrix/modules/alienspro.callback/install/unstep.php");
		return true;
	}
  
}

?>