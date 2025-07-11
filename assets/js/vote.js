export function upvote(event) {
	const newsId = parseInt(event.target.dataset.newsId, 10);
	console.log(newsId);
	vote(newsId, 'up',event.target);
}

export function downvote(event) {
	const newsId = parseInt(event.target.dataset.newsId, 10);
	console.log(newsId);
	vote(newsId, 'down',event.target);
}

function vote(newsId, type, button) {
	fetch(`http://localhost/codeigniter/index.php/news/vote/${newsId}`, {
		method: 'POST',
		headers: {
		'Content-Type': 'application/json',
		},
		body: JSON.stringify({ newsId, vote: type })
	})
	.then(response => {
		if (!response.ok) {
			return response.json().then(error => {
				alert(error.error || 'Ocurrió un error');
			});
		}
		return response.json();
	})
	.then(data => {
		console.log('Voto registrado:', data);

		const parent = button.parentElement;
		const up = parent.querySelector('.upvote');
		const down = parent.querySelector('.downvote');

		up?.classList.remove('voted');
		down?.classList.remove('voted');
		
		if (data.mensaje === 'Voto Nuevo' || data.mensaje === 'Voto Actualizado') {
			button.classList.add('voted');
		}
		
		document.getElementById('ResultNeto').innerText = 'Votos: ' + data.ResultNeto;
		
	})

	.catch(error => {
		console.error('Error:', error);
	});
}

