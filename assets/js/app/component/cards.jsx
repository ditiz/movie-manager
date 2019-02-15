import React from 'react';
import styled from 'styled-components';

import { BtnAddToSee, BtnAddSee } from './button';

export const CardMovie = (props) => {

	let actors = props.movie.actors.map((actor, index) => (
		<li key={index}>{actor}</li>
	));

	return (
		<Card className="mdc-card">
			<Poster src={props.movie.poster} alt="poster"/>
			<Right>
				<header>
					<h2>{props.movie.title}</h2>
					<small>{props.movie.year}</small>
				</header>

				<div>
					<h3>Synopsis</h3>
					<p>{props.movie.plot}</p>
				</div>

				<CastInfo>
					<div>
						<h3>Acteurs</h3>
						<ul>{actors}</ul>
					</div>

					<div>
						<h3>Réalisateur</h3>
						<p>{props.movie.realisator}</p>
					</div>
				</CastInfo>

				<Bottom>
					<BtnAddToSee/>
					<BtnAddSee/>
				</Bottom>
			</Right>
		</Card>
	);
}

const Card = styled.div`
	width: 50rem;
	height: 35rem;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: row nowrap;
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
`

const Right = styled.div`
	flex-shrink: 1;
	min-width: 30%;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;
	padding: 0 0.875rem;

	& header {
		text-align: center;
	}

	& > p {
		padding: 0 50px;
	}
`

const Bottom = styled.div`
	display: flex;
	justify-content: flex-end;
	flex-flow: row nowrap;
	margin: 5px 0px;
`

const CastInfo = styled.div`
	display: flex;
	flex-flow: row nowrap;
	justify-content: space-around;
`