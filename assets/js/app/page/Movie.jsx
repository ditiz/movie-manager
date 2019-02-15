import React, { Component } from 'react'

import { CardMovie } from '../component/cards'

class Movie extends Component {

	state = {
		ready: false,
		movie: {}
	}

	componentDidMount() {

		console.log("pouet")
		let url = server + "api/movies/imdbID/" + this.props.match.params.imdbId
		
		fetch(url)
		.then(res => res.json())
		.then(res => {
			let movie = {
				title: res.name,
				year: res.year,
				director: res.director,
				plot: res.plot,
				actors: res.actors.split(','),
				poster: res.poster
			}

			this.setState({ ready: true, movie: movie})
		})
	}

	render() {
		return (
			<div>
				{this.state.render ?
					<Loader/> : 
					<CardMovie movie={this.state.movie}/>
				}
			</div>
		)
	}
}

const server = "http://127.0.0.1:8000/"

export default Movie;