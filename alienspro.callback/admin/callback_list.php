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

if($_GET["action"]==="delete" && $CALLBACK_RIGHT=="W" ){
    callback::deleteMsg($id);
    LocalRedirect("callback_list.php");
}
if($_GET["action"]==="answer" && $CALLBACK_RIGHT=="W" ){
    
    $user_a = "";
    $rsUser = CUser::GetByID($USER->GetID());   
    $arUser = $rsUser->Fetch();
    $user_a = $arUser["NAME"]." ".$arUser["LAST_NAME"]." [".$arUser["LOGIN"]."]";
    callback::updateMsg($id,$user_a);
    LocalRedirect("callback_list.php");
}
if(($arID = $lAdmin->GroupAction()) && $CALLBACK_RIGHT=="W" && check_bitrix_sessid())
{
    
		if($_REQUEST['action_target']=='selected')
		{
				$arID = Array();
				$rsData = callback::getListMsg($by, $order);
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
						callback::deleteMsg($ID);
						break;
				case "answer":
                                                $user_a = "";
                                                $rsUser = CUser::GetByID($USER->GetID());   
                                                $arUser = $rsUser->Fetch();
                                                $user_a = $arUser["NAME"]." ".$arUser["LAST_NAME"]." ".$arUser["LOGIN"];
						@set_time_limit(0);
						callback::updateMsg($ID,$user_a);
						break;
				}
		}
}
/********************************************************************
				Data
********************************************************************/

$rsData = callback::getListMsg($by,$order);

$rsData = new CAdminResult($rsData, $sTableID);

$rsData->NavStart();
$lAdmin->NavText($rsData->GetNavPrint(GetMessage("CALLBACK_PAGES")));
$lAdmin->AddHeaders(array(
	array("id"=>"id", "content"=>"ID", "sort"=>"id", "default"=>true),
	array("id"=>"name", "content"=>GetMessage("CALLBACK_NAME"), "sort"=>"name", "default"=>true),
	array("id"=>"phone", "content"=>GetMessage("CALLBACK_PHONE"), "sort"=>"phone", "default"=>true),
	array("id"=>"email", "content"=>GetMessage("CALLBAKC_EMAIL"), "sort"=>"email", "default"=>true),
	array("id"=>"time_t", "content"=>GetMessage("CALLBACK_TIME"), "sort"=>"time_t", "default"=>true),
	array("id"=>"theme", "content"=>GetMessage("CALLBACK_THEME_NAME"), "sort"=>"theme", "default"=>true),
	array("id"=>"date_t", "content"=>GetMessage("CALLBACK_DATE"), "sort"=>"date_t", "default"=>true),
        array("id"=>"status", "content"=>GetMessage("CALLBACK_STATUS"), "sort"=>"status", "default"=>true),
        array("id"=>"user_answer", "content"=>GetMessage("CALLBACK_USER_ANSWER"), "sort"=>"user_answer", "default"=>true),
        array("id"=>"date_answer", "content"=>GetMessage("CALLBACK_DATE_ANSWER"), "sort"=>"date_t", "default"=>true),
));

while($arRes = $rsData->NavNext(true, "f_"))
{       
        
	$row = &$lAdmin->AddRow($f_id, $arRes);

        if((int)$f_status==2){
            $f_status = "red";
        }else{
            $f_status='green';
        }
        $row->AddViewField("status", "<img src='/bitrix/themes/.default/images/lamp/$f_status.gif'>");
	$arActions = Array();
	$arActions[] = array("SEPARATOR"=>true);
         $arActions[] = array("ICON" => "edit", "TEXT" => GetMessage("CALLBACK_ANSWER"),
                "ACTION"=>"window.location='callback_list.php?lang=".LANGUAGE_ID."&action=answer&id=$f_id&".bitrix_sessid_get()."'");
	
         $arActions[] = array("ICON" => "delete", "TEXT" => GetMessage("MAIN_ADMIN_MENU_DELETE"),     
		"ACTION"=>"if(confirm('".GetMessage("CALLBACK_CONFIRM_DEL_CALLBACK")."')) window.location='callback_list.php?lang=".LANGUAGE_ID."&action=delete&id=$f_id&".bitrix_sessid_get()."'");
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
if ($CALLBACK_RIGHT >= "W"):
	$lAdmin->AddGroupActionTable(Array(
		"delete" => GetMessage("CALLBACK_DELETE"),
                "answer" => GetMessage("CALLBACK_ANSWER"),
		));
	 
endif;

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
