import React, { Component } from 'react'
import styled from 'styled-components'
import PropTypes from 'prop-types'

import { BtnAddToSee, BtnAddSee } from './button'

function SoftCards({ movie, ...props }) {
	const [imgReady, setImgReady] = React.useState(false)
	const [toSee, setToSee] = React.useState(movie.toSee)
	const [see, setSee] = React.useState(movie.see)

	const redirectToMovie = () => {
		if (movie.imdbId) {
			props.history.push('/app/movie/' + movie.imdbId)
		} else {
			getImdbId(movie.title, movie.year)
		}
	}

	const getImdbId = (title, year) => {
		let url = `/api/movies/title/${title}/${year}`

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

	const clickAddToSee = () => {
		let url = `/api/movies/toSee/${movie.imdbId}/add`,
			watching = {
				toSee: true,
				see: false
			}
		api(url, watching)
	}

	const clickAddSee = () => {
		let url = `/api/movies/see/${movie.imdbId}/add`,
			watching = {
				toSee: false,
				see: true
			}
		api(url, watching)
	}

	const api = (url, watching) => {
		fetch(url)
			.then(res => res.json())
			.then(res => {
				if (res == 'false') {
					alert('error')
				} else {
					setToSee(watching.toSee)
					setSee(watching.see)
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


const Card = styled.div`
	width: 19rem;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;
	font-family: Roboto;
	margin: 2rem auto;
	transition: all 0.3s cubic-bezier(.25,.8,.25,1);
	font-size: 1rem;

  	&:hover {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)
	}
`

const Poster = styled.img`
	width: 100%;
	cursor: pointer;
`

const Bottom = styled.div`
	flex-shrink: 1;
	min-width: 30%;
	width: 100%;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;

	& header {
		text-align: center;
	}

	& > p {
		padding: 0 50px;
	}
`

const Down = styled.div`
	display: flex;
	justify-content: space-evenly;
	flex-flow: row nowrap;
	margin: .375rem .7rem;

	button {
		margin: 0;
	}
`

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