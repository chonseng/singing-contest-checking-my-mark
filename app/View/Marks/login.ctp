<div id="marking_wrapper">
	<div class="row">
			<?php echo $this->Session->flash(); ?>
	</div>
	<div class="row">
		<div class="login_logo"></div>
		<div class="login_title"></div>
	</div>
		<div class="row">
			<div class="marking_login">
					<?= $this->Form->create("Singer") ?>


					<?= $this->Form->input("password", array("label"=>false, "placeholder"=>"登入碼", "type"=>"text")) ?>



					<?php 
						$options = array(
						    'label' => '登入',
						    'class' => 'button login_btn medium large-12 medium-12 small-12'
						);
					?>
					<?= $this->Form->end($options) ?>
			</div>
		</div>
</div>