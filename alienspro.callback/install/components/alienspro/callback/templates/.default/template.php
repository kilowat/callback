<?
if (! defined ( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true)
	die ();
if($arParams["USE_JQUERY"]=="Y")
	$APPLICATION->AddHeadScript ( 'http://code.jquery.com/jquery-2.1.4.min.js' );
$APPLICATION->AddHeadScript ( $this->GetFolder().'/jquery-ui.min.js' );
$APPLICATION->AddHeadString('<link href="'.$this->GetFolder().'/jquery-ui.min.css" type="text/css" rel="stylesheet" />',true);
$APPLICATION->AddHeadString('<link href="'.$this->GetFolder().'/jquery-ui.theme.css" type="text/css" rel="stylesheet" />',true);
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
<button id="open-btn" class="send-button"><?=GetMessage("MFT_PHONE_TAKE")?></button>
<div id="callback-block" class="alienspro-callback">
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

		<!--start slider time-->
		<?if($arParams["USE_TIME"]=="Y"):?>
			<div class="slider-time">
				<div class="call-time">
					<span>
						<?=GetMessage("CALL_ME")?>
						<span id="time-after"><?=$arParams["TIME_BEFORE"]?>:00</span>
						<?=GetMessage("BEFORE")?> <span id="time-before"><?=$arParams["TIME_AFTER"]?>:00</span>
					</span>
				</div>				
				<div id="slider-time"></div>
					<div class="clocks">
	           			 <canvas id="canvas" width="160" height="160"></canvas>
	        		</div>
			</div>
		<!--end slider time-->
		<?endif?>
		<!-- start Captcha -->
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<div class="mf-captcha">
					<div class="mf-captcha-image">
						<input id="captcha_sid" type="hidden" name="captcha_sid"
							value="<?=$arResult["capCode"]?>"> <img id="captcha_img"
							src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>"
							width="150" height="40" alt="CAPTCHA">
					</div>
					<div id="reload-captcha"></div>
				<div class="captcha-form">
					<input id="captcha_word" type="text" name="captcha_word" size="30" maxlength="50"
						value="">
				</div>
				
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
</div>
<script>
/*Check jquery*/
(window.jQuery)||alert('<?=GetMessage("MFT_JQUERY_NOT_INSALL")?>');

$(document).ready(function(){

	var lang={
		title:'<?=GetMessage("MFT_TITLE")?>'
	};
	/*init dialog and clock*/
	alienspro_callback(lang);
	
	<?if($arParams["USE_PHONE_MASK"] == "Y"):?>
	/*init phone mask, if you want to modify mask, just edit this options, see http://digitalbush.com/projects/masked-input-plugin/*/
		$("#user_phone").mask("<?=$arParams['PHONE_MASK']?>");
	<?endif?>
	/*init ui slider*/
	$( "#slider-time" ).slider({
      range: true,
      min: <?=$arParams["TIME_BEFORE"]>0?$arParams["TIME_BEFORE"]:8?>,
      max: <?=$arParams["TIME_AFTER"]>0?$arParams["TIME_AFTER"]:20?>,
      values: [ 
		<?=$arParams["TIME_BEFORE"]>0?$arParams["TIME_BEFORE"]:8?>, 
		<?=$arParams["TIME_AFTER"]>0?$arParams["TIME_AFTER"]:20?> 
	],
      step: 1,
      slide: function( event, ui ) {
	     $('#time-after').text((ui.values[ 0 ])+':00'); 
	      $('#time-before').text((ui.values[ 1 ])+':00');
      }
    });
});
</script>
