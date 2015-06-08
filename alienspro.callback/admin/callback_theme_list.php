<?

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
global $DB;
ClearVars();

$sTableID = "tbl_callbck";
$oSort = new CAdminSorting($sTableID, "ID", "desc");
$lAdmin = new CAdminList($sTableID, $oSort);

IncludeModuleLangFile(__FILE__);
if(!CModule::IncludeModule("alienspro.callback")){
    echo "Callback_Module not find";
    exit;
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/prolog.php");
$CALLBACK_RIGHT = $APPLICATION->GetGroupRight("alienspro.callback");
if ($CALLBACK_RIGHT <= "D"):
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
endif;



/*******************************Action********************************/
if($_GET["action"]==="delete" && $CALLBACK_RIGHT =="W") {
    callback::deleteTheme($id);
}

if(($arID = $lAdmin->GroupAction()) && $CALLBACK_RIGHT=="W" && check_bitrix_sessid())
{
    
		if($_REQUEST['action_target']=='selected')
		{
				$arID = Array();
				$rsData = callback::getListTheme($by, $order);
				while($arRes = $rsData->Fetch())
						$arID[] = $arRes['id'];
		}

		foreach($arID as $ID)
		{
				if(strlen($ID)<=0)
						continue;
				$ID = IntVal($ID);
				switch($_REQUEST['action'])
				{
				case "delete":
						@set_time_limit(0);
						callback::deleteTheme($ID);
						break;
				
				}
		}
}
/********************************************************************
				Data
********************************************************************/

$rsData = callback::getListTheme($by,$order);
$rsData = new CAdminResult($rsData, $sTableID);
$rsData->NavStart();
$lAdmin->NavText($rsData->GetNavPrint(GetMessage("CALLBACK_PAGES")));
$lAdmin->AddHeaders(array(
	array("id"=>"id", "content"=>"ID", "sort"=>"id", "default"=>true),
	array("id"=>"name", "content"=>GetMessage("CALLBACK_THEME_NAME"), "sort"=>"name", "default"=>true),
));

while($arRes = $rsData->NavNext(true, "f_"))
{
	$row =& $lAdmin->AddRow($f_id, $arRes);
	
	$arActions = Array();
        $arActions[] = array("DEFAULT"=>"Y","ICON"=>"edit", "TEXT"=>GetMessage("MAIN_ADMIN_MENU_EDIT"), "ACTION"=>$lAdmin->ActionRedirect("callback_theme_edit.php?ID=".$f_id));
	$arActions[] = array("SEPARATOR"=>true);
	$arActions[] = array("ICON" => "delete", "TEXT" => GetMessage("MAIN_ADMIN_MENU_DELETE"),
		"ACTION"=>"if(confirm('".GetMessage("CALLBACK_CONFIRM_DEL_CALLBACK")."')) window.location='callback_theme_list.php?lang=".LANGUAGE_ID."&action=delete&id=$f_id&".bitrix_sessid_get()."'");
	if ($CALLBACK_RIGHT < "W")
		$row->bReadOnly = True;
	else
		$row->AddActions($arActions);
}

/************** Footer *********************************************/
$lAdmin->AddFooter(array(
	array("title"=>GetMessage("MAIN_ADMIN_LIST_SELECTED"), "value"=>$rsData->SelectedRowsCount()),
	array("counter"=>true, "title"=>GetMessage("MAIN_ADMIN_LIST_CHECKED"), "value"=>"0")));

$aMenu = array(); $aContext = array();

	$lAdmin->AddGroupActionTable(Array(
		"delete" => GetMessage("CALLBACK_DELETE"),
		));
	$aMenu[] = array(
		"TEXT"	=>GetMessage("CALLBACK_THEME_CREATE"),
		"TITLE"=>GetMessage("CALLBACK_THEME_CREATE"),
		"LINK"=>"callback_theme_edit.php?lang=".LANG,
		"ICON" => "btn_new"
	);

$lAdmin->AddAdminContextMenu($aMenu);
$lAdmin->CheckListMode();
/********************************************************************
				/Data
********************************************************************/

$APPLICATION->SetTitle(GetMessage("CALLBACK_PAGE_TITLE"));
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>

<?
$lAdmin->DisplayList();
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
