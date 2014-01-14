<div class="notes private">
	<?php foreach($notes as $note): ?>
	<?php include_partial("views/resource/note", array('note' => $note)) ?>
	<?php endforeach; ?>
</div>