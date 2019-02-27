import React, { Component } from 'react'
import styled from 'styled-components'

import { BtnAddToSee, BtnAddSee } from './button'

function SoftCards({ movie, ...props }) {
	const [imgReady, setImgReady] = React.useState(false)

	const redirectToMovie = () => {
		props.history.push('/app/movie/' + movie.imdbId)
	}

	const clickAddToSee = () => {
		let url = `/api/movies/toSee/${movie.imdbId}/add`

		fetch(url)
			.then(res => res.json())
			.then(res => {
				if (res == 'false') {
					alert('error')
				}
			})
	}

	const clickAddSee = () => {
		let url = `/api/movies/see/${movie.imdbId}/add`

		fetch(url)
			.then(res => res.json())
			.then(res => {
				if (res == 'false') {
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
				<header>
					<h2>{movie.title}</h2>
					<small>{movie.year}</small>
				</header>

				<Down>
					<BtnAddToSee onClick={clickAddToSee}/>
					<BtnAddSee onClick={clickAddSee}/>
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
	height: 100%;
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

export default SoftCards