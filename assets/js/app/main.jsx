import React from 'react';
import ReactDOM from 'react-dom';

import { CardMovie } from './component/cards.jsx'

class Main extends React.Component {
	render() {

		const movie1 = {
			poster: 'https://m.media-amazon.com/images/M/MV5BMjM5MDk2NDIxMF5BMl5BanBnXkFtZTgwNjU5NDk3NTM@._V1_.jpg',
			title: 'Predator',
			plot: "Les pires prédateurs de l'univers sont maintenant plus forts et plus intelligents que jamais, ils se sont génétiquement perfectionnés grâce à l'ADN d'autres espèces. Alors qu’un jeune garçon devient accidentellement leur cible, seul un équipage hétéroclite d'anciens soldats et un professeur de science contestataire peuvent empêcher l’extinction de la race humaine.",
			actors: ['Boyd Holbrook', 'Trevante Rhodes', 'Jacob Tremblay'],
			realisator: 'Shane Black',
			year: 2018
		}

		const movie2 = {
			poster: 'https://m.media-amazon.com/images/M/MV5BYTViNzMxZjEtZGEwNy00MDNiLWIzNGQtZDY2MjQ1OWViZjFmXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg',
			title: 'Terminator',
			plot: "A Los Angeles en 1984, un Terminator, cyborg surgi du futur, a pour mission d'exécuter Sarah Connor, une jeune femme dont l'enfant à naître doit sauver l'humanité. Kyle Reese, un résistant humain, débarque lui aussi pour combattre le robot, et aider la jeune femme...",
			actors: ["Arnold Schwarzenegger", "Michael Biehn", "Linda Hamilton"],
			realisator: 'James Cameron',
			year: 1984
		}

		return (
			<React.Fragment>
				<h1>Hello world!</h1>

				<CardMovie movie={movie1}/>
				<CardMovie movie={movie2}/>
			</React.Fragment>
		);
	}
}

ReactDOM.render(
	<Main/>,
	document.getElementById('app')
);