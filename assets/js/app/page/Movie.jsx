import React, { Component } from 'react'
import styled from 'styled-components'

import { serverName } from '../server'
import { CardMovie } from '../component/cards'
import { Loader } from '../component/loader'

class Movie extends Component {

	state = {
		ready: false,
		error: '',
		movie: {}
	}

	componentDidMount() {
		let imdbId = this.props.match.params.imdbId;
		let url = serverName + "api/movies/imdbID/" + imdbId

		console.log(url)

		fetch(url)
		.then(res => res.json())
		.then(res => {
			if (res != null) {
				let movie = {
					title: res.name,
					year: res.year,
					director: res.director,
					plot: res.plot,
					actors: res.actors.split(','),
					poster: res.poster,
					imdbId: res.imdbID
				}
				this.setState({ ready: true, movie: movie })
			} else {
				this.setState({ ready: true, error: "la film n'a pas pu être trouvé" })
			}
		})
	}

	render() {
		return (
			<div>
				<RenderReady 
					movie={this.state.movie} 
					error={this.state.error} 
					ready={this.state.ready}
					{...this.props}
				/> 
			</div>
		)
	}
}


const RenderReady = (props) => {
	if (props.ready) {
		return <RenderError movie={props.movie} error={props.error} {...props}/>
	} else {
		return <Loader/>
	}
}

const RenderError = (props) => {
	if (props.error.length > 0) {
		return <Error error={props.error}/>
	} else {
		return <CardMovie movie={props.movie} {...props}/>
	}
} 

const Error = (props) => (
	<ErrorDivParent>
		<ErroDivChild>
			<h2>{props.error}</h2>
		</ErroDivChild>
	</ErrorDivParent>
)

const ErroDivChild = styled.div`
	width: 100%;
	display: flex;
	justify-content: center;
	border:1px solid black;
	background: #212121;
	color: white;
	`
	
const ErrorDivParent = styled.div`
	display: flex;
	justify-content: center;
	flex-flow: wrap column;
	height:100%;
`

export default Movie