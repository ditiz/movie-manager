import React from 'react';
import styled from 'styled-components';

export const CardMovie = (props) => {
	console.log(props.movie)

	return (
		<Card className="mdc-card">
			<Poster src={props.movie.poster} alt="poster"/>
			<p>
				{props.movie.title}
			</p>
		</Card>
	);
}

const Card = styled.div`
	width: 50em;
	height: 30em;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: row wrap;
`

const Poster = styled.img`
	height: 100%;
`