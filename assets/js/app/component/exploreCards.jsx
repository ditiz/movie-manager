import React, { useState } from 'react'
import styled from 'styled-components'
import PropTypes from 'prop-types'

import { Card, Poster, Bottom, Down } from './cardsElement'

function ExploreCards({ movie, ...props }) {
	const [imgReady, setImgReady] = useState(false)

	const toSearch = () => {
		if (movie.title) {
			let title = encodeURIComponent(movie.title)
			props.history.push('/app/movie/search/' + title)
		}
	}

	const toMovie = () => {
		let title = movie.title,
			year = movie.year,
			url = `/api/movies/title/${title}/${year}`

		return fetch(url)
		.then(res => res.json())
		.then(mov => {
			if (mov.imdbID) {
				props.history.push(`/app/movie/${mov.imdbID}`)
			} else {
				alert('film non trouvé')
			}
		})
	}

	return (
		<Card className="mdc-card">
			<Poster
				src={movie.poster}
				alt="poster"
				onLoad={() => setImgReady(true)}
			/>

			<Bottom>
				<header>
					<h2>{movie.title}</h2>
					<small>{movie.year}</small>
				</header>

				<Down>
					<Button onClick={toSearch}>Recherche</Button>
					<Button onClick={toMovie}>Film</Button>
				</Down>
			</Bottom>
		</Card>
	)
}

const Button = (props) => {
	return (
		<button className="mdc-button mdc-button--raised" {...props}>
			<span className="mdc-button__label">{props.children}</span>
		</button>
	)
}

export default ExploreCards

