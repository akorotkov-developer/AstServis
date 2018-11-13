<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? if ($_POST['start_import'] != 'y') {?>
    <script src="http://code.jquery.com/jquery-latest.js"></script>

    <!-- Кнопка, вызывающее модальное окно -->
    <a href="#myModal" class="btn btn-primary" data-toggle="modal">Начать импорт товаров</a>
    <!-- HTML-код модального окна -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">?</button>
                    <h4 class="modal-title">Импорт товаров</h4>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
                    Прежде чем начать импорт товаров лучше бы сделать резервную копию каталога, на тот случай если в csv файлике будут какие-то несоответствия и что-то пойдет не так)
                </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <form action="" method="POST">
                        <button type="button" class="btn btn-default btn-close-formimport" data-dismiss="modal">Закрыть</button>
                        <input type="hidden" name="check-import" value="y" />
                        <button type="submit" class="btn btn-primary">Приступить к импорту</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?
    if ($_POST['check-import'] == 'y') {
    ?>
        <!-- Progress bar holder -->
        <div id="progress" style="width:500px;border:1px solid #ccc; margin-top: 10px;"></div>
        <!-- Progress information -->
        <div id="information" style="width"></div>
    <?}?>


    <div id="msg"></div>
<?}?>
