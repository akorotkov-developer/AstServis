<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовая страница");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>

<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "ord_phone", Array(
	"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"WEB_FORM_ID" => "3",	// ID веб-формы
		"LIST_URL" => "",	// Страница со списком результатов
		"EDIT_URL" => "result_edit.php",	// Страница редактирования результата
		"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
		"IGNORE_CUSTOM_TEMPLATE" => "Y",	// Игнорировать свой шаблон
		"USE_EXTENDED_ERRORS" => "Y",	// Использовать расширенный вывод сообщений об ошибках
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"SEF_FOLDER" => "/",	// Каталог ЧПУ (относительно корня сайта)
		"COMPONENT_TEMPLATE" => "order_form"
	),
	false
);?>

<?

//Получаем товары по PRODUCT_ID
/*function getNameProduct($PRODUCT_ID) {
	$arSelect = Array("ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>5, "ID"=>$PRODUCT_ID);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->GetNextElement())
	{
	 $arFields = $ob->GetFields();
	 $product = $arFields["NAME"];
	}
	return $product;
}

// Выведем актуальную корзину для текущего пользователя
$arBasketItems = array();
$dbBasketItems = CSaleBasket::GetList(
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", 
              "PRODUCT_ID", "QUANTITY", "PRICE")
    );
$i = 0;	
while ($arItems = $dbBasketItems->Fetch())
{
    $arBasketItems[] = $arItems;
	$arBasketItems[$i]["NAME"] = getNameProduct($arBasketItems[$i]["PRODUCT_ID"]);
	$i++;
}

//Формируем Html табличку для почтового сообщения
$messageTable = "<table>
					<tr>
						<td>Наименование</td>
						<td>Количество</td>
						<td>Цена</td>
					</tr>";
foreach ($arBasketItems as $arItemsBasket) {
	$messageTable .= "<tr><td>".$arItemsBasket["NAME"]."</td> <td>".$arItemsBasket["QUANTITY"]."</td> <td>".$arItemsBasket["PRICE"]."</td></tr>";
}
$messageTable .= "</table>";
*/
?> 



<?
/*Ищем раздел указанный в первом столбце*/
/*$arFilter = Array('IBLOCK_ID' => 5, "NAME" => "V-6");
$db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, true);

while ($ar_result = $db_list->GetNext()) {
    echo "<pre>";
    var_dump($ar_result["IBLOCK_SECTION_ID"]);
    echo "</pre>";
}*/
?>

<?
/*$string[0] = "Запчасти ЯМЗ/V/коленвал";
$IBLOCK_SECTION_ID_ARRY = explode("/", $string[0]);
foreach ($IBLOCK_SECTION_ID_ARRY as $IBLOCK_SECTION_ID){
    echo $IBLOCK_SECTION_ID;
}

echo "<br><br><br><br>";
echo end($IBLOCK_SECTION_ID_ARRY);*/

/*$arFilter = Array(
    "IBLOCK_ID" => 5,
    "=NAME" => "6521-1000186-23"
);
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter);
while ($ar_fields = $res->GetNext()) {
    echo "<pre>";
    var_dump($ar_fields["IBLOCK_SECTION_ID"]);
    echo "</pre>";
}*/
?>





<?
/*$sectionID = findSection("dvigateli_yamz/v-6/e-0");
echo "<pre>";
var_dump($sectionID);
echo "</pre>";*/
?>


<?
//Функция поиска раздела по символьному коды
/*function findSection($IBLOCK_SECTION_CODE) {
    $arFilter = Array('IBLOCK_ID' => 5, "CODE" => $IBLOCK_SECTION_CODE);
    $db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, true);

    while ($ar_result = $db_list->GetNext()) {
        $isSectionID = $ar_result['ID'];
    }
    return $isSectionID;
}

//Создать каталог если не существует
function creatCatalogIfnotFind($IBLOCK_SECTION_ARRY)
{
    $IBLOCK_SECTION_ID_ARRY = explode("/", $IBLOCK_SECTION_ARRY);
    $sectionPath = $IBLOCK_SECTION_ID_ARRY[0]; //Переводим переменную путь к каталогу в начало
    $iterrator = 0;
    $sectionID = "";
    foreach ($IBLOCK_SECTION_ID_ARRY as $IBLOCK_SECTION_CODE) {
        if ($iterrator > 0) {
            $sectionPath .= "/" . $IBLOCK_SECTION_CODE;
        }
        //Если раздел не найден то создаем его
        if (!findSection($sectionPath)) {
            $newSection = new CIBlockSection; //Новый раздел
            $arFields = Array(
                "ACTIVE" => "Y",
                "IBLOCK_SECTION_ID" => $sectionID,
                "IBLOCK_ID" => 5,
                "CODE" => $sectionPath,
                "NAME" => $IBLOCK_SECTION_CODE
            );
            $isSectionID = $newSection->Add($arFields);
        }
        $iterrator++;
        $sectionID = findSection($sectionPath);
    }

    return $isSectionID;
}

$section = creatCatalogIfnotFind("dvigateli_yamz/v-7/e-000");*/
?>

<?
$nameSection = "Запчасти ЯМЗ/V/кпп-запчасти";
$nameSection = explode("/", "Запчасти ЯМЗ/V/кпп-запчасти");
echo end($nameSection);
?>

<?
/*$arFilter = Array(
    "IBLOCK_ID" => 5,
    "=NAME" => "6521-1000186-23"
);

$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter);
while ($ar_fields = $res->GetNext()) {
    echo "<pre>";
    var_dump($ar_fields["IBLOCK_SECTION_ID"]);
    echo "</pre>";
}*/
?>

<?
/*$name = "Текст/89";
$arParams = array("replace_space"=>"/","replace_other"=>"_");
$trans = Cutil::translit($name,"ru",$arParams);
var_dump($trans);*/
?>
<?php
/*
function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_');
    return str_replace($rus, $lat, $str);
}
echo mb_strtolower(translit("Двигатели ЯМЗ/V-6T/E-0".'<br>'));
echo mb_strtolower(translit("Запчасти ЯМЗ".'<br>'));
echo mb_strtolower(translit("Ремкомплекты ЯМЗ".'<br>'));
echo mb_strtolower(translit("Ремкомплекты ЯМЗ".'<br>'));
echo mb_strtolower(translit("ТНВД".'<br>'));
echo mb_strtolower(translit("Запчасти ЯМЗ-530".'<br>'));
echo mb_strtolower(translit("Запчасти ЯМЗ-650".'<br>'));
echo mb_strtolower(translit("Топливная аппаратура ЯМЗ".'<br>'));
echo mb_strtolower(translit("Запчасти ТМЗ".'<br>'));
echo mb_strtolower(translit("Двигатели ТМЗ".'<br>'));
echo mb_strtolower(translit("Комплектующие ЯМЗ".'<br>'));*/

?>












<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script language="javascript">
        $(document).ready(function() {
            $(".topnav").accordion({
                accordion:true,
                speed: 500,
                closedSign: '+',
                openedSign: '-'
            });
        });
	</script>
	<style>

	</style>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<ul class="topnav">
				<li><a href="http://pcvector.net" target="_blank">Главная</a></li>
				<li><a href="#" class="parrent_a main_level">Двигатели ЯМЗ</a>
					<ul>
						<li><a href="#">ЯМЗ 236М</a></li>
						<li><a href="#">ЯМЗ 237М</a></li>
						<li><a href="#">ЯМЗ 3</a></li>
						<li><a href="#">ТМЗ - 456</a></li>
						<li><a href="#" class="parrent_a">V6</a>
							<ul class="parent_menu">
								<li><a href="#">ZVP V6</a></li>
								<li><a href="#">ZPV V8</a></li>
								<li><a href="#">ZPV V9</a></li>
							</ul>
						</li>
						<li><a href="#">ЯМЗ 238</a></li>
					</ul>
				</li>
				<li><a href="#"  class="parrent_a main_level">Запчасти ЯМЗ</a>
					<ul>
						<li class="active"><a href="#">HTML</a></li>
						<li><a href="#">CSS</a></li>
						<li><a href="#">javascript</a></li>
						<li><a href="#"  class="parrent_a">Java</a>
							<ul class="parent_menu">
								<li><a href="#">JSP</a></li>
								<li><a href="#">JSF</a></li>
								<li><a href="#">JPA</a></li>
							</ul>
						</li>
						<li><a href="#">Вкладки</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>-->





<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>