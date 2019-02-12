import React from 'react';
import styled from 'styled-components';

import { BtnAddToSee, BtnAddSee } from './button';

export const CardMovie = (props) => {
	return (
		<Card className="mdc-card">
			<Poster src={props.movie.poster} alt="poster"/>
			<Right>
				<h2>{props.movie.title}</h2>

				<p>
					{props.movie.plot}
				</p>

				<p>{props.movie.actors}</p>

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
	height: 30rem;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: row nowrap;
	font-family: Roboto;
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

	& h2 {
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
	margin: 10px 10px;
`