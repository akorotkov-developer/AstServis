<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Request;
use Bitrix\Main\Context;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Localization\Loc as Loc;
use Bitrix\Main\SystemException;

class StandardComponent extends CBitrixComponent
{
    /**
     * кешируемые ключи arResult
     * @var []
     */
    protected $cacheKeys = [];
    /**
     * вохвращаемые значения
     * @var mixed
     */
    protected $returned;
    /**
     * кеш
     * @var mixed
     */
    protected $cache;

    /**
     * подключает языковые файлы
     */
    public function onIncludeComponentLang()
    {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    /**
     * подготавливает входные параметры
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($params)
    {
        $result = [
            'CACHE_TIME' => intval($params['CACHE_TIME']) > 0 ? intval($params['CACHE_TIME']) : 3600,
            'AJAX' => Context::getCurrent()->getRequest()->isAjaxRequest(),
            'CACHE_TYPE' => $params["CACHE_TYPE"] == "N" ? $params["CACHE_TYPE"] : "Y",
        ];
        return $result;
    }

    /**
     * выполняет логику работы компонента
     */
    public function executeComponent()
    {
        global $APPLICATION;
        try {
            $this->executeProlog();
            if ($this->arParams['AJAX']) {
                $APPLICATION->RestartBuffer();
            }

            if (!$this->readDataFromCache()) {
                $this->startCache();
                $this->executeMain();
                $this->endCache();
            }
            $this->includeComponentTemplate();
            $this->executeEpilog();

            if ($this->arParams['AJAX']) {
                die();
            }

            return $this->returned;
        } catch (SystemException $e) {
            ShowError($e->getMessage());
            $this->abortCache();
        }
    }

    /**
     * выполяет действия перед кешированием
     */
    protected function executeProlog()
    {
    }

    /**
     * определяет читать данные из кеша или нет
     * @return bool
     */
    protected function readDataFromCache()
    {

        if ($this->arParams['CACHE_TYPE'] == 'N') {
            return false;
        }

        $this->cache = cache::createInstance();
        $this->setCacheKeys();

        if ($this->cache->initCache($this->arParams['CACHE_TIME'], $this->cacheKeys)) {
            $this->arResult = $this->cache->getVars();

            return $this->arResult;
        } else {
            return false;
        }
    }

    /**
     * Устанавливаем ключи для кеша
     */
    protected function setCacheKeys()
    {

        $this->cacheKeys = 'standardKeys';
    }

    /**
     * кеширует ключи массива arResult
     */
    protected function startCache()
    {
        if ($this->arParams['CACHE_TYPE'] == 'N') {
            return false;
        }

        $this->cache->startDataCache();

        if (is_array($this->cacheKeys) && sizeof($this->cacheKeys) > 0) {
            $this->SetResultCacheKeys($this->cacheKeys);
        }
    }

    public static function removeForbiddenWords($string)
    {
        /*$forbiddenWords = [
            'Ярославль' => 'Ярославль',
            'язда' => 'Ярославль',
            'Тутаев' => 'Тутаев',
            'белаз' => 'РБ',
            'Автодизель' => 'Ярославль',
            'ОАО "Автодизель"' => 'Ярославль'
        ];

        foreach ($forbiddenWords as $key => $value) {
            $string = preg_replace("/(^|\\s)($key)(\\s|,|\\.|$)/iu", "$1$value$3", $string);
        }*/

        return $string;
    }

    /**
     * Основная логика компонента
     */
    protected function executeMain()
    {
        global $APPLICATION;
        global $USER;

        if ($_POST['check-import'] == 'y') {
            //Записываем содержимое файла в $list
            if (($fp = fopen($_SERVER["DOCUMENT_ROOT"]."/import/price.csv", "r")) !== FALSE) {

                while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
                    $list[] = $data;
                }
                $total = count($list);
                $i = 1;

                //Читаем $list построчно
                foreach ($list as $string) {?>
                    <?$percent = intval($i/$total * 100 )."%";?>
                    <?
                    /*Обрабатываем пременные для AJAX*/
                    $string6 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[6]);
                    $string7 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[7]);
                    $string8 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[8]);
                    $string9 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[9]);
                    $string10 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[10]);
                    ?>
                    <script>
                        function getdetails(){
                            var string0 = '<?=$string[0]?>';
                            var string1 = '<?=$string[1]?>';
                            var string2 = '<?=$string[2]?>';
                            var string3 = '<?=$string[3]?>';
                            var string4 = '<?=$string[4]?>';
                            var string5 = '<?=$string[5]?>';
                            var string6 = '<?=$string6?>';
                            var string7 = '<?=$string7?>';
                            var string8 = '<?=$string8?>';
                            var string9 = '<?=$string9?>';
                            var string10 = '<?=$string10?>';
                            var string11 = '<?=$string[11]?>';
                            var string12 = '<?=$string[12]?>';
                            var string14 = '<?=$string[13]?>';
                            var string15 = '<?=$string[14]?>';

                            $.ajax({
                                type: "POST",
                                url: "<?=$APPLICATION->GetCurPage()?>",
                                data: {start_import: 'y', string0:string0, string1:string1, string2:string2, string3:string3, string4:string4, string5:string5, string6:string6, string7:string7, string8:string8, string9:string9, string10:string10, string11:string11, string12:string12, string14:string14, string15:string15 }
                            }).done(function( result )
                            {
                                $("#msg").html( result );
                                <?if ($percent == 100) {?>
                                document.getElementById("progress").innerHTML="<div style=\'width:<?=$percent?>;background-color:#ddd;\'>&nbsp;</div>";
                                document.getElementById("information").innerHTML="Импорт завершен";
                                <?} else {?>
                                document.getElementById("progress").innerHTML="<div style=\'width:<?=$percent?>;background-color:#ddd;\'>&nbsp;</div>";
                                document.getElementById("information").innerHTML="<?=$i?> Товаров(а) обработано.";
                                <?}?>
                            });
                        }
                    </script>
                    <script>
                        getdetails();
                    </script>

                    <?$i++;?>

                    <?
                }
                fclose($fp);
            }
        }

        if ($_POST["start_import"] == "y") {
            //Процесс имопрта
            sleep(1);
            CModule::IncludeModule("iblock");
            $string = array();
            $string[0] = $_POST['string0']; // Раздел
            $string[1] = $_POST['string1']; // SHORT_NAME - короткое имя
            $string[2] = $_POST['string2']; // NAME - название
            $string[3] = $_POST['string3']; // APPELLATION - Наименование продукции
            $string[4] = $_POST['string4']; // Цена
            $string[5] = $_POST['string5']; // Ссылка на фотографию
            $string[6] = $_POST['string6']; // Описание PREVIEW_TEXT
            $string[7] = $_POST['string7']; // Описание PREVIEW_TEXT
            $string[8] = $_POST['string8']; // Описание PREVIEW_TEXT
            $string[9] = $_POST['string9']; // TECHNICAL - Технические характеристики
            $string[10] = $_POST['string10']; // KOMPLEKTNOST - Комплектность
            $string[11] = $_POST['string11']; // PAY - Оплата
            $string[12] = $_POST['string12']; // SROK - Срок поставки
            $string[14] = $_POST['string14']; // CREATOR - Производитель
            $string[15] = $_POST['string15']; // KEY_WORDS_STRING - Ключевые слова


            /*ФУНКЦИИ ДЛЯ ПОИСКА И СОЗДАНИЯ КАТАЛОГА*/
            function translit($str) {
                $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ');
                $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_');
                return str_replace($rus, $lat, $str);
            }
            //Первеодим наш путь в транслит
            $nameSection = $string[0];
            $string[0] = mb_strtolower(translit($string[0]));

            //Функция поиска раздела по символьному коды
            function findSection($IBLOCK_SECTION_CODE) {

                //Заменяем слэш в названии на нижнее подчеркивание
                $name = $IBLOCK_SECTION_CODE;
                $arParams = array("replace_space"=>"/","replace_other"=>"_");
                $trans = Cutil::translit($name,"ru",$arParams);

                $arFilter = Array('IBLOCK_ID' => 5, "CODE" => $trans);
                $db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, true);

                while ($ar_result = $db_list->GetNext()) {
                    $isSectionID = $ar_result['ID'];
                }
                return $isSectionID;
            }

            //Создать каталог если не существует
            function creatCatalogIfnotFind($IBLOCK_SECTION_ARRY)
            {
                $SECTION_NAME = explode("/", $_POST['string0']);

                $IBLOCK_SECTION_ID_ARRY = explode("/", $IBLOCK_SECTION_ARRY);
                $sectionPath = $IBLOCK_SECTION_ID_ARRY[0]; //Переводим переменную путь к каталогу в начало


                $iterrator = 0;
                $sectionID = "";
                \Bitrix\Main\Diag\Debug::dumpToFile(['$IBLOCK_SECTION_ID_ARRY' => $IBLOCK_SECTION_ID_ARRY], '', 'log.txt');
                foreach ($IBLOCK_SECTION_ID_ARRY as $IBLOCK_SECTION_CODE) {
                    if ($iterrator > 0) {
                        $sectionPath .= "/" . $IBLOCK_SECTION_CODE;
                    }

                    //Если раздел не найден то создаем его
                    if (!findSection($sectionPath)) {

                        //Заменяем слэш в названии на нижнее подчеркивание
                        $name = $sectionPath;
                        $arParams = array("replace_space"=>"/","replace_other"=>"_");
                        $trans = Cutil::translit($name,"ru",$arParams);

                        \Bitrix\Main\Diag\Debug::dumpToFile(['$trans' => $trans], '', 'log.txt');
                        \Bitrix\Main\Diag\Debug::dumpToFile(['$sectionID' => $sectionID], '', 'log.txt');

                        $newSection = new CIBlockSection; //Новый раздел
                        $arFields = Array(
                            "ACTIVE" => "Y",
                            "IBLOCK_SECTION_ID" => $sectionID,
                            "IBLOCK_ID" => 5,
                            "CODE" => $trans,
                            "NAME" => $SECTION_NAME[$iterrator]
                        );
                        $isSectionID = $newSection->Add($arFields);
                    }
                    $iterrator++;
                    $sectionID = findSection($sectionPath);
                }

                return $isSectionID;
            }
            /*КОНЕЦ ФУНКЦИЙ ДЛЯ ПОИСКА И СОЗДАНИЯ КАТАЛОГА*/


            /*Если в файле CSV не задан раздел, значит в этой строке вообще товара нет*/
            if ($string[0] != "") {
                /*1. Ищем в каталоге товар с таким же кодом как в CSV файле*/
                $find_position = false;

                $arFilter = Array(
                    "IBLOCK_ID" => 5,
                    "=NAME" => $string[2]
                );
                $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter);
                while ($ar_fields = $res->GetNext()) {
                    /*Если товар нашелся, то обновим его поля в соответствии с CSV файлом*/
                    if ($ar_fields["ID"]) {
                        if ($string[8]!=""){
                            $string[8]="<h2>Назначение</h2><p>".$string[8]."</p>";
                        }
                        if ($string[6]=="" and $string[7]=="" and $string[8]=="") {
                            $preview = "";
                        } else {
                            $preview = '<p>' . $string[6] . '</p>' . '<br><p>' . $string[7] . '</p>' . '<br>' . $string[8];
                        }

                        if ($string[9] == "") {
                            $technical = "";
                        } else {
                            $technical = '<p>' . $string[9] . '</p>';
                        }

                        if ($string[10] == "") {
                            $komplekt = "";
                        } else {
                            $komplekt = '<p>' . $string[10] . '</p>';
                        }

                        $el = new CIBlockElement;
                        $PROP = array();
                        $PROP['APPELLATION'] = $string[3];
                        $PROP['TECHNICAL'] = $technical;
                        $PROP['PAY'] = $string[11];
                        $PROP['SROK'] = $string[12];
                        $PROP['KOMPLEKTNOST'] = $komplekt;
                        $PROP['GARANTY'] = '12 месяцев';
                        $PROP['SHORT_NAME'] = $string[1];
                        $PROP['CREATOR'] = $string[14];
                        $PROP['KEY_WORDS_STRING'] = $string[15];

                        $picture = array();
                        if ($string[5]) {
                            $picture = CFile::MakeFileArray($string[5]);
                        } else {
                            $picture = CFile::MakeFileArray("http://" . $_SERVER['SERVER_NAME'] . '/local/templates/astradizel_main/img/no-photo.png');
                        }

                        $arLoadProductArray = Array(
                            "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
                            "PROPERTY_VALUES" => $PROP,
                            "PREVIEW_TEXT" => $preview,
                            "ACTIVE" => "Y",
                            "PREVIEW_PICTURE" => $picture
                        );

                        $PRODUCT_ID = $ar_fields['ID'];  //Меняем сам товар
                        $result = $el->Update($PRODUCT_ID, $arLoadProductArray);//Обновляем поля товара

                        /*Обновляем цену товара*/
                        $price = $string[4]; // take first value
                        $price = str_replace(',', '', $price); // replace coma
                        $price = str_replace('р.', '', $price); // replace coma
                        $price = str_replace(' ', '', $price); // replace coma

                        $arField = Array(
                            "PRODUCT_ID" => $PRODUCT_ID,
                            "CATALOG_GROUP_ID" => 1,
                            "PRICE" => $price,
                            "CURRENCY" => "RUB"
                        );
                        $res = CPrice::GetList(array(), array("PRODUCT_ID" => $PRODUCT_ID, "CATALOG_GROUP_ID" => 1));
                        if ($arr = $res->Fetch()) {
                            CPrice::Update($arr["ID"], $arField);
                        } else {
                            CPrice::Add($arField);
                        }

                        /*Проверим в каком каталоге находится товар и если каталог неправильный, то переместим его в нужный каталог*/
                        //Если товар находится в том же каталоге что указано в прайс листе, то все норм, если нет, то создаем
                        //создаем этот каталог и перемещаем туда товар
                        if ($ar_fields["IBLOCK_SECTION_ID"] != findSection($string[0])){
                            $ar = $ar_fields["IBLOCK_SECTION_ID"];

                            //Создаем каталог если его нет
                            if (!findSection($string[0])) {
                                $sectID = creatCatalogIfnotFind($string[0]);
                                \Bitrix\Main\Diag\Debug::dumpToFile(['$sectID1' => $sectID], '', 'log.txt');
                            } else {
                                $sectID = findSection($string[0]);
                                \Bitrix\Main\Diag\Debug::dumpToFile(['$sectID2' => $sectID], '', 'log.txt');
                            }

                            $arLoadProductArray = Array(
                                "MODIFIED_BY" => $USER->GetID(),
                                "IBLOCK_SECTION_ID" => $sectID
                            );

                            $PRODUCT_ID = $ar_fields['ID'];  //Меняем сам товар
                            $result = $el->Update($PRODUCT_ID, $arLoadProductArray);//Обновляем поля товара
                        }

                        $find_position = true; //Товар обновился дальше не идем, переходим на следующую строку CSV файла.

                    }
                }


                /*Если товар не нашелся*/
                if (!$find_position) {
                    $isSectionID = false;// Устнавливаем переменную false, которая означает, что раздел пока не найден.

                    /*Ищем раздел указанный в первом столбце*/
                    //Заменяем слэш в названии на нижнее подчеркивание
                    $name = $string[0];
                    $arParams = array("replace_space"=>"/","replace_other"=>"_");
                    $trans = Cutil::translit($name,"ru",$arParams);

                    $arFilter = Array('IBLOCK_ID' => 5, "CODE" => $trans);
                    $db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, true);

                    while ($ar_result = $db_list->GetNext()) {
                        $isSectionID = $ar_result['ID'];
                    }

                    /*Если раздел не нашелся, то создаем раздел добавляем товар в этот раздел*/
                    if (!$isSectionID) {
                        /*Создаем раздел*/
                        $isSectionID = creatCatalogIfnotFind($string[0]);
                    }

                    $newProduct = new CIBlockElement;

                    $picture = array();
                    if ($string[5]) {
                        $picture = CFile::MakeFileArray($string[5]);
                    } else {
                        $picture = CFile::MakeFileArray("http://" . $_SERVER['SERVER_NAME'] . '/local/templates/astradizel_main/img/no-photo.png');
                    }

                    if ($string[6]=="" and $string[7]=="" and $string[8]=="") {
                        $preview = "";
                    } else {
                        $preview = '<p>' . $string[6] . '</p>' . '<br><p>' . $string[7] . '</p>' . '<br><p>' . $string[8] . '</p>';
                    }

                    if ($string[9] == "") {
                        $technical = "";
                    } else {
                        $technical = '<p>' . $string[9] . '</p>';
                    }

                    if ($string[10] == "") {
                        $komplekt = "";
                    } else {
                        $komplekt = '<p>' . $string[10] . '</p>';
                    }


                    $PROP = array();
                    $PROP['APPELLATION'] = $string[3];
                    $PROP['TECHNICAL'] = $technical;
                    $PROP['PAY'] = 'Предоплата 50%';
                    $PROP['SROK'] = 'От 5 дней';
                    $PROP['KOMPLEKTNOST'] = $komplekt;
                    $PROP['GARANTY'] = '12 месяцев';
                    $PROP['CREATOR'] = $string[14];
                    $PROP['KEY_WORDS_STRING'] = $string[15];

                    $arLoadProductArray = Array(
                        "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
                        "IBLOCK_SECTION_ID" => $isSectionID,
                        "IBLOCK_ID" => 5,
                        "PROPERTY_VALUES" => $PROP,
                        "NAME" => $string[2],
                        "ACTIVE" => "Y",
                        "PREVIEW_TEXT" => $preview,
                        "PREVIEW_TEXT_TYPE" => "html",
                        "PREVIEW_PICTURE" => $picture
                    );

                    $PRODUCT_ID = $newProduct->Add($arLoadProductArray); //Добавили товар

                    /*Добавляем цену товара*/
                    $price = $string[4]; // take first value
                    $price = str_replace(',', '', $price); // replace coma
                    $price = str_replace('р.', '', $price); // replace coma
                    $price = str_replace(' ', '', $price); // replace coma

                    $arField = Array(
                        "PRODUCT_ID" => $PRODUCT_ID,
                        "CATALOG_GROUP_ID" => 1,
                        "PRICE" => $price,
                        "CURRENCY" => "RUB"
                    );
                    $res = CPrice::GetList(array(), array("PRODUCT_ID" => $PRODUCT_ID, "CATALOG_GROUP_ID" => 1));
                    if ($arr = $res->Fetch()) {
                        CPrice::Update($arr["ID"], $arField);
                    } else {
                        CPrice::Add($arField);
                    }

                    /*Добавляем количество товара*/
                    CCatalogProduct::Add(Array("ID" => $PRODUCT_ID, "QUANTITY" => 100, "QUANTITY_TRACE" => "N"));
                }
            }

        }

    }

    /**
     * завершает кеширование
     * @return bool
     */
    protected function endCache()
    {
        if ($this->arParams['CACHE_TYPE'] == 'N') {
            return false;
        }

        $this->cache->endDataCache($this->arResult);
    }

    /**
     * выполняет действия после выполения компонента
     */
    protected function executeEpilog()
    {
    }

    /**
     * прерывает кеширование
     */
    protected function abortCache()
    {
        if ($this->arParams['CACHE_TYPE'] == 'N') {
            return false;
        }

        $this->cache->abortDataCache();
    }
}
