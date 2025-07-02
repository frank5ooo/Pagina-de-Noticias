<h2><?php echo $title; ?></h2>


<?php
if (!empty($news)) : ?>
    <?php echo '<h2>'.$news_item['title'].'</h2>'; ?>
    
    <?php echo $news_item['text']; ?>
<?php else: ?>
    <p>No hay noticias disponibles.</p>
<?php endif; ?>

