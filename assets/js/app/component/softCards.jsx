import React, { Component } from 'react'
import styled from 'styled-components'
import PropTypes from 'prop-types'

import { Card, Poster, Bottom, Down } from './cardsElement'
import { BtnAddToSee, BtnAddSee } from './button'

function SoftCards({ movie, ...props }) {
	const [imgReady, setImgReady] = React.useState(false)
	const [toSee, setToSee] = React.useState(movie.toSee)
	const [see, setSee] = React.useState(movie.see)

	const redirectToMovie = () => {
		if (movie.imdbId) {
			props.history.push('/app/movie/' + movie.imdbId)
		}
	}

	const clickAddToSee = () => {
		let url = `/api/movies/toSee/${movie.imdbId.trim()}/add`,
			watching = {
				toSee: true,
				see: false
			}
		api(url, watching)
	}

	const clickAddSee = () => {
		let url = `/api/movies/see/${movie.imdbId.trim()}/add`,
		watching = {
			toSee: false,
			see: true
		}
		console.log(url)
		api(url, watching)
	}

	const api = (url, watching) => {
		fetch(url)
			.then(res => res.json())
			.then(res => {
				console.log(res)
				if (res) {
					setToSee(watching.toSee)
					setSee(watching.see)
				} else {
					alert('error')
				}
			})
	}

	return (
		<Card className="mdc-card">
			<Poster
				src={movie.poster}
				alt="poster"
				onLoad={() => setImgReady(true)}
				onClick={redirectToMovie}
			/>

			<Bottom>
				<header onClick={redirectToMovie} style={{cursor:'pointer'}}>
					<h2>{movie.title}</h2>
					<small>{movie.year}</small>
				</header>

				<Down>
					<BtnAddToSee toSee={toSee} onClick={clickAddToSee}/>
					<BtnAddSee see={see} onClick={clickAddSee}/>
				</Down>
			</Bottom>
		</Card>
	)
}

SoftCards.propTypes = {
	movie: PropTypes.object
}

SoftCards.defaultProps = {
	movie: {
		poster: '',
		title: '',
		year: 0,
		imdbId: 'notFound',
	}
}

export default SoftCards