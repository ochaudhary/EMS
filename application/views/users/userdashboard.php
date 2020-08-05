<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<main role="main" class="flex-shrink-0">
	<div class="container">
		<h2 class="text-center"></h2>
		<?php
		$firstMsg = $this->session->flashdata('msg');
		if($firstMsg !=''){
			echo '<h3>'.$firstMsg.'</h3>';
		}
		?>
	</div>
</main>
