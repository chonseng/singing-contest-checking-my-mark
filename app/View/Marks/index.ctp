<div class="row">
		<?php echo $this->Session->flash(); ?>
</div>
<?php 

// var_dump($marks);

	$percents = array();
	foreach ($marks as $key => $mark) {
	
		$percents[$key] = $mark["Mark"]["overall"];

	}
	
?>

<style>
	
	<?php foreach ($marks as $key => $mark) : ?>
	#singer<?= $key+1 ?> {
		width: <?=$percents[$key]?>%;
		background: orange;

	}
	
	<?php endforeach?>

	table tbody tr:nth-child(-n+8) .bar{
		background: lightgreen !important;
	}

</style>
<link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/admin.css">
<div class="row">

		<h2>參賽者編號: <?=$_SESSION["singer_id"]?></h2>	
		<h4>組別: <?=$type?></h4>

		<table width="100%">
			<thead>
				<tr>
					<td class="large-1 medium-1 small-1">評判</td>
					<td class="large-1 medium-1 small-1" >歌唱技巧(40%)</td>
					<td class="large-1 medium-1 small-1" >歌曲詮釋(40%)</td>
					<td class="large-1 medium-1 small-1" >個人台風(10%)</td>
					<td class="large-1 medium-1 small-1" >個人創意(10%)</td>
					<td class="large-7 medium-7 small-7" >總分(100%)</td>
				</tr>
			</thead>
			<tbody>
				<?php $total=0 ?>
				<?php foreach ($marks as $key => $mark) : ?>
				<tr>
					<td><div><?=$key+1?></div></td>
					<td><div><?= $mark["Mark"]["skill"] ?></div></td>
					<td><div><?= $mark["Mark"]["interpretation"] ?></div></td>
					<td><div><?= $mark["Mark"]["style"] ?></div></td>
					<td><div><?= $mark["Mark"]["creativity"] ?></div></td>
					<td><div id="singer<?= $key+1 ?>" class="bar"><?= $mark["Mark"]["overall"]?></div></td>
				</tr>
					<?php $total += $mark["Mark"]["overall"]; ?>
				<?php endforeach ?>
			</tbody>
		</table>
		<h2>總分(滿分<?= 100*$users_amount ?>): <?=$total?></h2>
		<h2>排名: <?=$rank?> <small>此排名截至 <?=$today?></small></h2>
		<div class="announce">
			<h2>免責聲明</h2>
			<p>本網頁內的資料只供參考之用。「澳門培正中學學生會」致力確保所提供資料的準確性，但並不保證或陳述該等資料是否完整或精準。</p>
			<p>當你一旦使用「分數查詢系統」，即表示你無條件接受上述所載的免責條款。「澳門培正中學學生會」可在毋須事先通知你的情況下而可隨時對上述條款作出修改及/或增補，且有最終解釋權。</p>
		</div>
		<a href="<?php $this->Path->myroot(); ?>marks/logout" class="button small">登出</a>

</div>