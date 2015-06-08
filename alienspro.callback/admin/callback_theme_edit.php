<?
// подключим все необходимые файлы:
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php"); // первый общий пролог

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/include.php"); // инициализация модуля
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/alienspro.callback/prolog.php"); // пролог модуля
if(!CModule::IncludeModule("alienspro.callback")){
    echo "Callback_Module not find";
    exit;
}
// подключим языковой файл
IncludeModuleLangFile(__FILE__);

// получим права доступа текущего пользователя на модуль
$POST_RIGHT = $APPLICATION->GetGroupRight("alienspro.callback");
// если нет прав - отправим к форме авторизации с сообщением об ошибке
if ($POST_RIGHT == "D")
  $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

// сформируем список закладок
$aTabs = array(
  array("DIV" => "edit1", "TAB" => GetMessage("call_tab_callback"), "ICON"=>"main_user_edit", "TITLE"=>GetMessage("call_tab_callback_title")),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);

$ID = intval($ID);		// идентификатор редактируемой записи
$message = null;		// сообщение об ошибке
$bVarsFromForm = false; // флаг "Данные получены с формы", обозначающий, что выводимые данные получены с формы, а не из БД.

// ******************************************************************** //
//                ОБРАБОТКА ИЗМЕНЕНИЙ ФОРМЫ                             //
// ******************************************************************** //

if(
	$REQUEST_METHOD == "POST" // проверка метода вызова страницы
	&&
	($save!="" || $apply!="") // проверка нажатия кнопок "Сохранить" и "Применить"
	&&
	$POST_RIGHT=="W"          // проверка наличия прав на запись для модуля
	&&
	check_bitrix_sessid()     // проверка идентификатора сессии
)
{



  

  // сохранение данных
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
    // если сохранение прошло удачно - перенаправим на новую страницу 
    // (в целях защиты от повторной отправки формы нажатием кнопки "Обновить" в браузере)
    if ($apply != "")
      // если была нажата кнопка "Применить" - отправляем обратно на форму.
      LocalRedirect("/bitrix/admin/callback_theme_edit.php?ID=".$ID."&mess=ok&lang=".LANG."&".$tabControl->ActiveTabParam());
    else
      // если была нажата кнопка "Сохранить" - отправляем к списку элементов.
      LocalRedirect("/bitrix/admin/callback_theme_list.php?lang=".LANG);
  }
  else
  {
    // если в процессе сохранения возникли ошибки - получаем текст ошибки и меняем вышеопределённые переменные
    if($e = $APPLICATION->GetException())
      $message = new CAdminMessage(GetMessage("call_save_error"), $e);
    $bVarsFromForm = true;
  }
}

// ******************************************************************** //
//                ВЫБОРКА И ПОДГОТОВКА ДАННЫХ ФОРМЫ                     //
// ******************************************************************** //

// выборка данных
if($ID>0)
{
  $THEME = callback::getTheme($ID);
  $callback = callback::getTheme($ID);
  
}

// если данные переданы из формы, инициализируем их
if($bVarsFromForm)
  $DB->InitTableVarsForEdit("b_list_callback", "", "str_");

// ******************************************************************** //
//                ВЫВОД ФОРМЫ                                           //
// ******************************************************************** //

// установим заголовок страницы
$APPLICATION->SetTitle(($ID>0? GetMessage("call_title_edit")."-".$ID : GetMessage("call_title_add")));

// не забудем разделить подготовку данных и вывод
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

// конфигурация административного меню
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
// если есть сообщения об ошибках или об успешном сохранении - выведем их.
if($_REQUEST["mess"] == "ok" && $ID>0)
  CAdminMessage::ShowMessage(array("MESSAGE"=>GetMessage("call_saved"), "TYPE"=>"OK"));

?>

<?
// далее выводим собственно форму
?>
<form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
<?// проверка идентификатора сессии ?>
<?echo bitrix_sessid_post();?>
<?
// отобразим заголовки закладок
$tabControl->Begin();
?>
<?
//********************
// первая закладка - форма редактирования параметров рассылки
//********************
$tabControl->BeginNextTab();
?>
  <tr>
    <td><span class="required">*</span><?echo GetMessage("call_name")?></td>
    <td><input type="text" name="NAME" value="<?echo $THEME['name'];?>" size="30" maxlength="100"></td>
  </tr>
<?
//********************
// вторая закладка - параметры автоматической генерации рассылки
//********************

// завершение формы - вывод кнопок сохранения изменений
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
// завершаем интерфейс закладок
$tabControl->End();
?>

<?
// дополнительное уведомление об ошибках - вывод иконки около поля, в котором возникла ошибка
$tabControl->ShowWarnings("post_form", $message);
?>

<?
// дополнительно: динамическая блокировка закладки, если требуется.
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
// завершение страницы
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>