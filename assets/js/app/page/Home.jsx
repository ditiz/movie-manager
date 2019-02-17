import React, { Component } from 'react'
import styled from 'styled-components';
import { Link } from 'react-router-dom' 

import { serverName } from '../server'

class Home extends Component {

	state = {
		lastMovieToSee: {},
		lastMovieSee: {}
	}

	componentDidMount() {
		fetch(serverName + 'api/movies/last')
		.then(res => res.json())
		.then(res => {
			if (res != null) {
				let lastMovieToSee = {
					title: res.toSee.name,
					year: res.toSee.year,
					director: res.toSee.director,
					plot: res.toSee.plot,
					actors: res.toSee.actors.split(','),
					poster: res.toSee.poster,
					imdbId: res.toSee.imdbID
				}

				let lastMovieSee = {
					title: res.see.name,
					year: res.see.year,
					director: res.see.director,
					plot: res.see.plot,
					actors: res.see.actors.split(','),
					poster: res.see.poster,
					imdbId: res.see.imdbID
				}

				this.setState({ 
					lastMovieToSee: lastMovieToSee, 
					lastMovieSee: lastMovieSee
				})
			}
		})
	}

	render() {
		return (
			<BoxParent>
				<Box>
					<Title>Dernier film ajouté à voir</Title>
					
				</Box>
				<Box>
					<Title>Dernier film vu</Title>
				</Box>
			</BoxParent>
		)
	}
}

const Box = (props) => (
	<BoxCss className="mdc-card">
		{props.children}
	</BoxCss>
)

const BoxCss = styled.div`
	width: 30rem;
	height: 35rem;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;
	text-align: center;
	font-family: Roboto;
	margin: 2rem auto;
	transition: all 0.3s cubic-bezier(.25,.8,.25,1);
	font-size: 1rem;

  	&:hover {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)
	}
`

const BoxParent = styled.div`
	display: flex;
	justify-content: space-evenly;;
	flex-flow: wrap row;
	width: 100%;
`

const Title = styled.h2`
	color: white;
`

export default Home