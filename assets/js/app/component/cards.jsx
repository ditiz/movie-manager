import React, {Component} from 'react';
import styled from 'styled-components';
import { Link } from "react-router-dom";
import PropTypes from 'prop-types';

import { BtnAddToSee, BtnAddSee } from './button'

class CardMovie extends Component {
	state = {
		ready: false
	}

	imgLoad = () => {
		this.setState({ ready: true})
	}

	redirectToMovie = () => {
		this.props.history.push('/app/movie/' + this.props.movie.imdbId)
	}  

	render() {
		console.log(this.props)
		return (
			<Card className="mdc-card">
				<Poster 
					src={this.props.movie.poster} 
					alt="poster" 
					onLoad={this.imgLoad} 
					onClick={this.redirectToMovie}
				/>

				<WaitImg imgReady={this.state.ready} {...this.props} />
			</Card>
		);
	}
}

const WaitImg = (props) => {
	if (props.imgReady) {
		let actors = <li>Pas d'acteur</li>

		if (Array.isArray(props.movie.actors)) {
			actors = props.movie.actors.map((actor, index) => (
				<li key={index}>{actor}</li>
			));
		}

		const clickAddToSee = () => {
			let url = `/api/movies/toSee/${props.movie.imdbId}/add`

			fetch(url)
			.then(res => res.json())
			.then(res => {
				if (res == 'false') {
					alert('error')
				} else {
					props.getMovies()
				}
			})

		}

		const clickAddSee = () => {
			let url = `/api/movies/see/${props.movie.imdbId}/add`
			
			fetch(url)
			.then(res => res.json())
			.then(res => {
				if (res == 'false') {
					alert('error')
				} else {
					props.getMovies()
				}
			})
		}

		return (
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
						<p>{props.movie.director}</p>
					</div>
				</CastInfo>

				<Bottom>
					<BtnAddToSee onClick={clickAddToSee}/>
					<BtnAddSee onClick={clickAddSee}/>
				</Bottom>
			</Right>
		)
	} else {
		return <></>
	}
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
	width: 100%;
`

const Right = styled.div`
	flex-shrink: 1;
	min-width: 30%;
	width: 100%;
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

CardMovie.propsTypes = {
	movie: PropTypes.number
}

export default CardMovie