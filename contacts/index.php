<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "АСТ-сервис");
$APPLICATION->SetPageProperty("keywords_inner", "АСТ-сервис");
$APPLICATION->SetPageProperty("keywords", "АСТ-сервис");
$APPLICATION->SetTitle("Контакты");
?><p>
    Звоните:&nbsp;<a href="tel: +74852789278">(4852) 78-92-78</a>
</p>
<p>
    Факс:&nbsp;<a href="tel: +74852789278">(4852) 737-888</a>
</p>
<p>
    Viber: <a href="https://viber.click/79206589278">+7-920-658-92-78</a>
</p>
<p>
	 Пишите на e-mail:&nbsp;<a href="mailto: dkorotkov@mail.ru">dkorotkov@mail.ru</a>
</p>
 Почтовый адрес:&nbsp;150040, Ярославска обл., г.Ярославль, пр.Ленина, д.18/50, оф.89<br>
 <br>
 Адрес склада:&nbsp;150044, Ярославль,Ленинградский пр-т, д.27-Б,к2<br>
 <br>

<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"order_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "order_form",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"LIST_URL" => "",
		"SEF_FOLDER" => "/",
		"SEF_MODE" => "Y",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"WEB_FORM_ID" => "2"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>