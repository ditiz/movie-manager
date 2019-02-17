import React, { Component } from 'react'
import styled from 'styled-components'

import { serverName } from '../server'
import { CardMovie } from '../component/cards'
import { Loader } from '../component/loader'

class MovieList extends Component {

	state = {
		ready: false,
		error: '',
		movies: []
	}

	componentDidMount() {
		this.getMovies()
	}

	getMovies() {
		let url = ''

		if (this.props.location.pathname == '/app/toSee') {
			url = serverName + "api/movies/toSee"
		} else {
			url = serverName + "api/movies/see"
		}

		fetch(url)
			.then(res => res.json())
			.then(res => {
				if (res) {
					let movies = res.map(mov => {
						let movie = {
							title: mov.m_name,
							year: mov.m_year,
							director: mov.m_director,
							plot: mov.m_plot,
							actors: mov.m_actors.split(','),
							poster: mov.m_poster,
							imdbId: mov.m_imdbID
						}

						return movie;
					})

					this.setState({ ready: true, movies: movies })
				} else {
					this.setState({ ready: true, error: "Les films n'ont pas pu être récupéré" })
				}
			})
	}

	render() {
		return (
			<div>
				<RenderReady
					movies={this.state.movies}
					error={this.state.error}
					ready={this.state.ready}
					{...this.props}
				/>
			</div>
		)
	}
}


const RenderReady = (props) => {
	if (props.ready) {
		return <RenderError movies={props.movies} error={props.error} {...props} />
	} else {
		return <Loader />
	}
}

const RenderError = (props) => {
	if (props.error.length > 0) {
		return <Error error={props.error} />
	} else {
		return props.movies.map(movie => (
			<CardMovie key={movie.imdbId} movie={movie} {...props} />
		))
	}
}

const Error = (props) => (
	<ErrorDivParent>
		<ErroDivChild>
			<h2>{props.error}</h2>
		</ErroDivChild>
	</ErrorDivParent>
)

const ErroDivChild = styled.div`
	width: 100%;
	display: flex;
	justify-content: center;
	border:1px solid black;
	background: #212121;
	color: white;
	`

const ErrorDivParent = styled.div`
	display: flex;
	justify-content: center;
	flex-flow: wrap column;
	height:100%;
`

export default MovieList