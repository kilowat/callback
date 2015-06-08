<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParameters = Array(
      "USER_PARAMETERS"=> Array(
         "COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("GD_CALLBACK_COUNT"),
            "TYPE" => "STRING",
            "DEFAULT"=> 10,
         ),
          "THEME" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("GD_CALLBACK_COLOR_THEME"),
            "TYPE" => "LIST",
            "DEFAULT" => "red",
            "VALUES" => array("red"=>"red","black"=>"black","blue"=>"blue",)
         ),
          "ROW" => Array(
			"NAME" => GetMessage("USE_ROW"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => array("NAME"=>GetMessage("GD_CALLBACK_NAME"),
                                         "PHONE"=> GetMessage("GD_CALLBACK_PHONE"),
                                         "EMAIL"=>GetMessage("GD_CALLBACK_EMAIL"),
                                         "TIME_T"=> GetMessage("GD_CALLBACK_TIME_T"),
                                         "THEME"=> GetMessage("GD_CALLBACK_THEME"),
                                         "DATE_T"=>GetMessage("GD_CALLBACK_DATE_T"),
                                         "STATUS"=> GetMessage("GD_CALLBACK_STATUS"),
                                         "USER_ANSWER" =>GetMessage("GD_CALLBACK_USER_ANSWER"),
                                         "DATE_ANSWER"=>GetMessage("GD_CALLBACK_DATE_ANSWER"),
                                            ),
			"DEFAULT"=>array("NAME","PHONE","TIME_T","DATE_T","STATUS"), 
			"COLS"=>"8",
                        "SIZE"=>"20",
                        "ADDITIONAL_VALUES" => "N",
			"PARENT" => "BASE",
		),

      ),
   );
?>
