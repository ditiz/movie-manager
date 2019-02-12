import React from 'react';
import ReactDOM from 'react-dom';

import { CardMovie } from './component/cards.jsx'

class Main extends React.Component {
	render() {

		const movie = {
			poster: 'https://m.media-amazon.com/images/M/MV5BMjM5MDk2NDIxMF5BMl5BanBnXkFtZTgwNjU5NDk3NTM@._V1_.jpg',
			title: 'Predator',
			plot: "Les pires prédateurs de l'univers sont maintenant plus forts et plus intelligents que jamais, ils se sont génétiquement perfectionnés grâce à l'ADN d'autres espèces. Alors qu’un jeune garçon devient accidentellement leur cible, seul un équipage hétéroclite d'anciens soldats et un professeur de science contestataire peuvent empêcher l’extinction de la race humaine.",
		}

		return (
			<React.Fragment>
				<h1>Hello world!</h1>

				<CardMovie movie={movie}>
					première carte
				</CardMovie>

				<div ref={this.divRef}></div>
			</React.Fragment>
		);
	}
}

ReactDOM.render(
	<Main/>,
	document.getElementById('app')
);