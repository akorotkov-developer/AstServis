<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовая страница");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>

<?
const CLIENT = "http://cbr.ru/CreditInfoWebServ/CreditOrgInfo.asmx?WSDL";
$client = new \SoapClient(CLIENT, array('exceptions' => false));

/*echo "<pre>";
var_dump($banks);
echo "</pre>";*/



$intCode = $client->BicToIntCode(array('BicCode' => "044525201"));
echo "<pre>";
var_dump($intCode);
echo "</pre>";

/*CreditInfoByIntCodeEx
$this->client->Data135FormFullXML(array("CredorgNumber" => $regNumber, "OnDate" => $response));*/
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>