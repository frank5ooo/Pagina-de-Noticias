<link rel="stylesheet" href="<?= base_url('assets/css/view.css') ?>">

<?= $news_item['text'] ?>

<p>Noticia creada por <?php echo $news_item['fullname']; ?></p>


<?=$votedUp = $currentVote === 'up' ? 'voted' : '';?>
<?=$votedDown = $currentVote === 'down' ? 'voted' : '';?>

<button type="hidden"  class="vote-button upvote <?= $votedUp ?>" id="upvote" data-news-id="<?= $news_item['id'] ?>">&uArr;</button>

<button type="hidden" class="vote-button downvote <?= $votedDown ?>"  id="downvote" data-news-id="<?= $news_item['id'] ?>">&dArr;</button> 

<script type="module">
	import {upvote, downvote} from 'http://localhost/<?= URL_PREFIX?>assets/js/vote.js';
	
	/** @type {HTMLButtonElement} */
	const upvoteButton = document.getElementById('upvote');
	upvoteButton.addEventListener('click', upvote);

	/** @type {HTMLButtonElement} */
	const downvoteButton = document.getElementById('downvote');
	downvoteButton.addEventListener('click', downvote);
</script>
	
