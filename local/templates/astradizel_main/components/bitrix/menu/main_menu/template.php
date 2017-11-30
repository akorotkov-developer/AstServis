<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="mainmenu-area">
	<div class="container">
		<div class="row">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?
					foreach($arResult as $arItem):
						if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
							continue;
					?>
						<?if($arItem["SELECTED"]):?>
							<li><a href="<?=$arItem["LINK"]?>" class="active"><?=$arItem["TEXT"]?></a></li>
						<?else:?>
							<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
						<?endif?>

					<?endforeach?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?endif?>