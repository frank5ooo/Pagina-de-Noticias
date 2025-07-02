<h2><?php echo $title; ?></h2>

<?php if (!empty($news)) : ?>
    <?php foreach ($news as $news_item): ?>
        <h3><?php echo $news_item->title; ?></h3>
        <div class="main">
            <?php echo $news_item->text; ?>
        </div>
        <p><a href="<?php echo site_url('news/' . $news_item->slug); ?>">Ver artículo</a></p>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay noticias disponibles.</p>
<?php endif; ?>

<?php if (!empty($pagination_links)) : ?>
    <div class="pagination">
        <?php echo $pagination_links; ?>
    </div>
<?php endif; ?>
