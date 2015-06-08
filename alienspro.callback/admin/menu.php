<?php 
IncludeModuleLangFile(__FILE__);
$aMenu = array(
    "parent_menu" => "global_menu_services", // �������� � ������ "������"
    "sort"        => 1,                    // ��� ������ ����
    "text"        => GetMessage("CALLBACK_NAME"),       // ����� ������ ����
    "title"       => GetMessage("CALLBACK_NAME"), // ����� ����������� ���������
    "icon"        => "callback_icon", // ����� ������
    "page_icon"   => "callback_icon", // ������� ������
    "items_id"    => "callback",  // ������������� �����
    "items"       => array(
        array(
            "url" =>"callback_list.php?lang=".LANG,
            "text"=>GetMessage("CALLBACK_LIST_MSG"),
            "title"=>GetMessage("CALLBACK_LIST_MSG"),
        ),
         array(
            "url" =>"callback_theme_list.php?lang=".LANG,
            "text"=>GetMessage("CALLBACK_THEME"),
            "title"=>GetMessage("CALLBACK_THEME"),
        )
    ),          
  );
  return $aMenu;
?>