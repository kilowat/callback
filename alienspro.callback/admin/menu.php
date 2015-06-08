<?php 
IncludeModuleLangFile(__FILE__);
$aMenu = array(
    "parent_menu" => "global_menu_services", // поместим в раздел "Сервис"
    "sort"        => 1,                    // вес пункта меню
    "text"        => GetMessage("CALLBACK_NAME"),       // текст пункта меню
    "title"       => GetMessage("CALLBACK_NAME"), // текст всплывающей подсказки
    "icon"        => "callback_icon", // малая иконка
    "page_icon"   => "callback_icon", // большая иконка
    "items_id"    => "callback",  // идентификатор ветви
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