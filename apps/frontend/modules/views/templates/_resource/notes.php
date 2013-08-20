<ul class="unstyled" id="notes_list">
    <?php foreach($notes as $note): ?>
    <?php include_partial("views/resource/note", array('note' => $note)) ?>
    <?php endforeach; ?>
</ul>