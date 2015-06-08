<?
// ��������� ��� ����������� �����:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // ������ ����� ������

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/include.php"); // ������������� ������
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/prolog.php"); // ������ ������
if(!CModule::IncludeModule("alienspro.callback")){
    echo "Callback_Module not find";
    exit;
}
// ��������� �������� ����
IncludeModuleLangFile(__FILE__);

// ������� ����� ������� �������� ������������ �� ������
$POST_RIGHT = $APPLICATION->GetGroupRight("alienspro.callback");
// ���� ��� ���� - �������� � ����� ����������� � ���������� �� ������
if ($POST_RIGHT == "D")
  $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

// ���������� ������ ��������
$aTabs = array(
  array("DIV" => "edit1", "TAB" => GetMessage("call_tab_callback"), "ICON"=>"main_user_edit", "TITLE"=>GetMessage("call_tab_callback_title")),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);

$ID = intval($ID);		// ������������� ������������� ������
$message = null;		// ��������� �� ������
$bVarsFromForm = false; // ���� "������ �������� � �����", ������������, ��� ��������� ������ �������� � �����, � �� �� ��.

// ******************************************************************** //
//                ��������� ��������� �����                             //
// ******************************************************************** //

if(
	$REQUEST_METHOD == "POST" // �������� ������ ������ ��������
	&&
	($save!="" || $apply!="") // �������� ������� ������ "���������" � "���������"
	&&
	$POST_RIGHT=="W"          // �������� ������� ���� �� ������ ��� ������
	&&
	check_bitrix_sessid()     // �������� �������������� ������
)
{



  

  // ���������� ������
  if($ID > 0)
  {
    $res = callback::updateTheme($ID, $NAME);
    
  }
  else
  {
    $ID = callback::addTheme($NAME);
    $res = ($ID > 0);
  }

  if($res)
  {
    // ���� ���������� ������ ������ - ������������ �� ����� �������� 
    // (� ����� ������ �� ��������� �������� ����� �������� ������ "��������" � ��������)
    if ($apply != "")
      // ���� ���� ������ ������ "���������" - ���������� ������� �� �����.
      LocalRedirect("/bitrix/admin/callback_theme_edit.php?ID=".$ID."&mess=ok&lang=".LANG."&".$tabControl->ActiveTabParam());
    else
      // ���� ���� ������ ������ "���������" - ���������� � ������ ���������.
      LocalRedirect("/bitrix/admin/callback_theme_list.php?lang=".LANG);
  }
  else
  {
    // ���� � �������� ���������� �������� ������ - �������� ����� ������ � ������ ��������������� ����������
    if($e = $APPLICATION->GetException())
      $message = new CAdminMessage(GetMessage("call_save_error"), $e);
    $bVarsFromForm = true;
  }
}

// ******************************************************************** //
//                ������� � ���������� ������ �����                     //
// ******************************************************************** //

// ������� ������
if($ID>0)
{
  $THEME = callback::getTheme($ID);
  $callback = callback::getTheme($ID);
  
}

// ���� ������ �������� �� �����, �������������� ��
if($bVarsFromForm)
  $DB->InitTableVarsForEdit("b_list_callback", "", "str_");

// ******************************************************************** //
//                ����� �����                                           //
// ******************************************************************** //

// ��������� ��������� ��������
$APPLICATION->SetTitle(($ID>0? GetMessage("call_title_edit")."-".$ID : GetMessage("call_title_add")));

// �� ������� ��������� ���������� ������ � �����
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

// ������������ ����������������� ����
$aMenu = array(
  array(
    "TEXT"=>GetMessage("call_list"),
    "TITLE"=>GetMessage("call_list_title"),
    "LINK"=>"callback_admin.php?lang=".LANG,
    "ICON"=>"btn_list",
  )
);
?>

<?
// ���� ���� ��������� �� ������� ��� �� �������� ���������� - ������� ��.
if($_REQUEST["mess"] == "ok" && $ID>0)
  CAdminMessage::ShowMessage(array("MESSAGE"=>GetMessage("call_saved"), "TYPE"=>"OK"));

?>

<?
// ����� ������� ���������� �����
?>
<form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
<?// �������� �������������� ������ ?>
<?echo bitrix_sessid_post();?>
<?
// ��������� ��������� ��������
$tabControl->Begin();
?>
<?
//********************
// ������ �������� - ����� �������������� ���������� ��������
//********************
$tabControl->BeginNextTab();
?>
  <tr>
    <td><span class="required">*</span><?echo GetMessage("call_name")?></td>
    <td><input type="text" name="NAME" value="<?echo $THEME['name'];?>" size="30" maxlength="100"></td>
  </tr>
<?
//********************
// ������ �������� - ��������� �������������� ��������� ��������
//********************

// ���������� ����� - ����� ������ ���������� ���������
$tabControl->Buttons(
  array(
    "disabled"=>($POST_RIGHT<"W"),
    "back_url"=>"callback_admin.php?lang=".LANG,
    
  )
);
?>
<input type="hidden" name="lang" value="<?=LANG?>">
<?if($ID>0 && !$bCopy):?>
  <input type="hidden" name="ID" value="<?=$ID?>">
<?endif;?>
<?
// ��������� ��������� ��������
$tabControl->End();
?>

<?
// �������������� ����������� �� ������� - ����� ������ ����� ����, � ������� �������� ������
$tabControl->ShowWarnings("post_form", $message);
?>

<?
// �������������: ������������ ���������� ��������, ���� ���������.
?>
<script language="JavaScript">
<!--
  if(document.post_form.AUTO.checked)
    tabControl.EnableTab('edit2');
  else
    tabControl.DisableTab('edit2');
//-->
</script>

<?
// ���������� ��������
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>