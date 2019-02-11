import React from 'react';
import ReactDOM from 'react-dom';

import { CardMovie } from './component/cards.jsx'

class Main extends React.Component {
	render() {

		const movie = {
			poster: 'https://m.media-amazon.com/images/M/MV5BMjM5MDk2NDIxMF5BMl5BanBnXkFtZTgwNjU5NDk3NTM@._V1_.jpg',
			title: 'hereafter'
		}

		return (
			<React.Fragment>
				<h1>Hello world!</h1>
				<button className="mdc-button">
					<span className="mdc-button__label">Button</span>
				</button>

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