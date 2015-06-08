<?
	if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

	$APPLICATION->AddHeadScript('http://code.jquery.com/jquery-1.11.0.min.js');

/*
	* Bitrix vars
	*
	* @var array $arParams
	* @var array $arResult
	* @global CMain $APPLICATION
	* @global CUser $USER
*/
?>
<div id="callback-block">

	<!-- start Show Eror/Ok Message -->
	<?if(!empty($arResult["ERROR_MESSAGE"]))
	{
		foreach($arResult["ERROR_MESSAGE"] as $v)
			ShowError($v);
	}
	if(strlen($arResult["OK_MESSAGE"]) > 0)
	{
		?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
	}
	?>
	<!-- end Show Eror/Ok Message -->
	
	<!-- start Callback Form -->
	<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
		
		<?=bitrix_sessid_post()?>
		
		<!-- start Name -->
		<div class="mf-name">
			<div class="mf-text">
				<?=GetMessage("MFT_NAME")?>
				<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?>
					<span class="mf-req">*</span>
				<?endif?>
			</div>
			<input id="user_name" type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
		</div>
		<!-- end Name -->
		
		<!-- start Phone -->
		<div class="mf-phone">
			<div class="mf-text">
				<?=GetMessage("MFT_PHONE")?>
				<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?>
					<span class="mf-req">*</span>
				<?endif?>
			</div>
			<input id="phone-mask" type="text" name="user_phone" value="">
		</div>
		<!-- end Phone -->
		
		<!-- start Email -->
		<?if($arParams["USE_EMAIL"]=="Y"):?>
			<div class="mf-email">
				<div class="mf-text">
					<?=GetMessage("MFT_EMAIL")?>
					<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?>
						<span class="mf-req">*</span>
					<?endif?>
				</div>
				<input id="user_email" type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
			</div>
		<?endif?>
		<!-- end Email -->
		
		<!-- start Theme List -->
		<?if(!empty($arResult['THEME_LIST'])):?>
			<div class="mf-theme"> 
				<div class="mf-text">
					<?=GetMessage("MFT_THEME")?>
				</div>
				<select id="user_theme" name="user_theme">
					<?foreach($arResult['THEME_LIST'] as $themeItems):?>
						<option value="<?=$themeItems['name']?>">
							<?=$themeItems['name']?>
						</option>
					<?endforeach?>
				</select>
			</div>
		<?endif?>
		<!-- end Theme List -->
		
		<!-- start Time Button -->
		<div class="mf-time">
			<?if($arParams["USE_TIME"]=="Y"&&$arParams["USE_DATE"]=="Y"):?>
				<div class="mf-text">
					<?=GetMessage("MFT_TIME")?>
				</div>
			<?endif?>
			<?if($arParams["USE_TIME"]=="Y"):?>
				<div id="time-bar"></div>
			<?endif?>
			<?if($arParams["USE_DATE"]=="Y"):?>    
				<ul id="date-items">
					<li id="today-link" class="button-time"><a><?=GetMessage("TODAY")?></a></li>
					<li id="tomorrow-link" class="button-time"><a><?=GetMessage("TOMORROW")?></a></li>
					<li id="click-day" class="button-time"><a onfocus="this.text;lcs(this)" onclick="event.cancelBubble=true;this.text;lcs(this);"><?=GetMessage("TAKEDAY")?></a></li>
				</ul>
			<?endif?>
			<input id="date-input" style="visibility: hidden;height: 1px;" type="text" name="user_time" value="">
			<input id="time-input" style="visibility: hidden;height: 1px;" type="text" name="user_day" value=""> 
		</div>
		<!-- end Time Button -->
		
		<!-- start Captcha -->
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<div class="mf-captcha">
				<div class="mf-captcha-image">
					<input id="captcha_sid" type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="150" height="40" alt="CAPTCHA">
				</div>
				<div class="captcha-form">
					<input type="text" name="captcha_word" size="30" maxlength="50" value="">
				</div>
				<div class="captcha-clear"></div>
				<div class="mf-captcha-text">
					<?=GetMessage("MFT_CAPTCHA")?>
					<span class="mf-req">*</span>
				</div>
				
			</div>
		<?endif;?>
		<!-- start Captcha -->
		
		<!-- start Bottons -->
		<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
		<input id ="ajax-form-submit" class="send-button" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
		<!-- end Bottons -->
	</form>
	<!-- end Callback Form -->
</div>
<!--********************************************JS****************************************************-->
<script>
    $(document).ready(function(){
     $("#phone-mask").mask("+7(999) 999-9999");
});


</script>