import React, { Component } from 'react'
import styled from 'styled-components';
import { Link } from 'react-router-dom' 

import { serverName } from '../server'
import { Loader } from '../component/loader'

class Home extends Component {

	state = {
		lastMovieToSee: {
			title: '',
			year: '',
			director: '',
			plot: '',
			actors: [],
			poster: '',
			imdbId: ''
		},
		lastMovieSee: {
			title: '',
			year: '',
			director: '',
			plot: '',
			actors: [],
			poster: '',
			imdbId: ''
		},
		ready: false
	}

	componentDidMount() {
		fetch( 'api/movies/last')
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
					lastMovieSee: lastMovieSee,
					ready: true
				})
			}
		})
	}

	render() {
		if  (this.state.ready) {
			return (
				<BoxParent>
					<Box>
						<Link to={'app/movie/' + this.state.lastMovieToSee.imdbId}>
							<Head>Dernier film ajouté à voir</Head>
							<Title>{this.state.lastMovieToSee.title}</Title>
							<Poster src={this.state.lastMovieToSee.poster} alt='poster' />
						</Link>
						<Btn className="mdc-button">Vu</Btn>
					</Box>
					<Box>
						<Link to={'app/movie/' + this.state.lastMovieSee.imdbId}>
							<Head>Dernier film vu</Head>
							<Title>{this.state.lastMovieSee.title}</Title>
							<Poster src={this.state.lastMovieSee.poster} alt='poster' />
						</Link>
						<Btn className="mdc-button">Revoir</Btn>
					</Box>
				</BoxParent>
			)
		} else {
			return <Loader/>
		}
	}
}

const Box = (props) => (
	<BoxCss className="mdc-card">
		{props.children}
	</BoxCss>
)

const BoxCss = styled.div`
	width: 30rem;
	max-height: 36rem;
	background: #212121;
	color: #FFF;
	display: flex;
	flex-flow: column nowrap;
	justify-content: space-between
	text-align: center;
	font-family: Roboto;
	margin: 2rem auto;
	transition: all 0.3s cubic-bezier(.25,.8,.25,1);
	font-size: 1rem;

	* {
		margin: .3rem;
	} 

  	&:hover {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)
	}
`

const BoxParent = styled.div`
	display: flex;
	justify-content: space-evenly;;
	flex-flow: wrap row;
	width: 100%;

	a {
		text-decoration:none
	}
`

const Title = styled.p`
	color: white;
	text-decoration: none;
`

const Poster = styled.img`
	height: auto;
	margin: auto;
	flex: 18rem;
	padding: .3rem;
	max-height: 27.8rem;
`

const Head = styled.h2`
	color: white;
	text-decoration: none;
`

const Btn = styled.button`
	min-height: 2rem;
`
export default Home