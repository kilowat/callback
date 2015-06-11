<?
if (! defined ( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die ();

$APPLICATION->AddHeadScript ( 'http://code.jquery.com/jquery-1.11.0.min.js' );
//$APPLICATION->AddHeadScript ( 'http://code.jquery.com/ui/1.11.4/jquery-ui.js' );
$APPLICATION->AddHeadScript ( $this->GetFolder().'/jquery-ui.min.js' );
//$APPLICATION->AddHeadString('<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">');

$APPLICATION->AddHeadString('<link href="'.$this->GetFolder().'/jquery-ui.css" type="text/css" rel="stylesheet" />',true);
 
/*work with ajax*/
 /*
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<button id="open-btn">Открыть</button>
<div id="callback-block">
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
			<input id="user_name" type="text" name="user_name"
				value="<?=$arResult["AUTHOR_NAME"]?>">
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
			<input id="user_phone" type="text" name="user_phone" value="">
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
			<input id="user_email" type="text" name="user_email"
				value="<?=$arResult["AUTHOR_EMAIL"]?>">
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
		<!-- start Captcha -->
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<div class="mf-captcha">
			<div class="mf-captcha-image">
				<input id="captcha_sid" type="hidden" name="captcha_sid"
					value="<?=$arResult["capCode"]?>"> <img
					src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>"
					width="150" height="40" alt="CAPTCHA">
			</div>
			<div class="captcha-form">
				<input id="captcha_word" type="text" name="captcha_word" size="30" maxlength="50"
					value="">
			</div>
			<div class="captcha-clear"></div>
			<div class="mf-captcha-text">
					<?=GetMessage("MFT_CAPTCHA")?>
					<span class="mf-req">*</span>
			</div>
		</div>
		<?endif;?>
		<!-- end Captcha -->

		<!-- start Bottons -->
		<div class="row-button">
			<input id = "PARAMS_HASH" type="hidden" name="PARAMS_HASH"
				value="<?=$arResult["PARAMS_HASH"]?>"> <input id="ajax-form-submit"
				class="send-button" type="submit" name="submit"
				value="<?=GetMessage("MFT_SUBMIT")?>">
		</div>
		<!-- end Bottons -->
	</form>
	<!-- end Callback Form -->

<!--start alert msg-->

<!-- end alert msg -->
</div>
<script>
$(document).ready(function(){
	var lang={
		title:'Заказ обратного звонка'
	};
	alienspro_callback(lang);
});
</script>
