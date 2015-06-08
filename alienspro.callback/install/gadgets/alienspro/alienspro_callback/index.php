<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule('alienspro.callback')){
    echo "Callback_module not find!";
    exit;
}
global $APPLICATION;
$APPLICATION->SetAdditionalCSS('/bitrix/gadgets/alienspro/alienspro_callback/style.css');

$arrListRes = callback::getListMsg("id","desc",$arGadgetParams["COUNT"],$arGadgetParams["ROW"]);
$result = array();
$i=0;

$countRow = count($arGadgetParams["ROW"]);
?>
<div class="<?=$arGadgetParams["THEME"]?>" >
<table>
    <tr>
        <?if(is_array($arGadgetParams["ROW"])):?>
            <?foreach($arGadgetParams["ROW"] as $paramsItem):?>
            <td><?=GetMessage("GD_CALLBACK_$paramsItem")?></td>
            <?endforeach;?>
        <?endif?>       
    </tr>
    <?
         while($item = $arrListRes->fetch()){
            if((int)$item["status"]===1){
                 $item["status"] ='<img src="/bitrix/themes/.default/images/lamp/green.gif">';
             }
             elseif((int)$item["status"]===2){
                 $item["status"] ='<img src="/bitrix/themes/.default/images/lamp/red.gif">';
             }
             
             echo "<tr>";
                foreach($arGadgetParams["ROW"] as $pItem){
                    echo "<td>{$item[strtolower($pItem)]}</td>";
                }       
             echo "</tr>";
        }
    ?>
    
</table>
</div>