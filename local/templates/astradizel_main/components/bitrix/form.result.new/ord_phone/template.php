<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
if ($_GET["formresult"] == "addok") {
?>
 <h3 class="formaddok">Спасибо, ваша заявка принята.</h3>
<?
} else {
?>

	<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

	<?=$arResult["FORM_NOTE"]?>

	<?if ($arResult["isFormNote"] != "Y")
	{
	?>

	<?
		$arResult["FORM_HEADER"] = str_replace("POST_FORM_ACTION_URI", "",  $arResult["FORM_HEADER"]);
	?>

	<?=$arResult["FORM_HEADER"]?>


	<br />
	<?
	/***********************************************************************************
							form questions
	***********************************************************************************/
	?>



		<?
		foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
		{
		?>
			<div class="row form_order">
				<div class="col-md-12">
					<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
						<span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
					<?endif;?>
				</div>
			</div>

					
						<?=$arQuestion["HTML_CODE"]?>
					
			
		<?
		} //endwhile
		?>
	<?
	if($arResult["isUseCaptcha"] == "Y")
	{
	?>
			<div class="row form_order">
				<div class="col-md-12">
					<label><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></label>
					<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
				</div>
			</div>

			<div class="row form_order">
				<div class="col-md-12">
					<?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
					<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
				</div>
			</div>

	<?
	} // isUseCaptcha
	?>


					<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value= "Отправить" />
					<?if ($arResult["F_RIGHT"] >= 15):?>
					&nbsp;
					<?endif;?>
					&nbsp;



	<?=$arResult["FORM_FOOTER"]?>
	<?
	} //endif (isFormNote)
	?>
<?
}
?>