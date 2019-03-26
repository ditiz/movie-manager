import React, { PureComponent } from 'react'
import styled from 'styled-components'

import SoftCards from '../component/softCards'
import { Loader } from '../component/loader'

class Explore extends PureComponent {

	state = {
		ready: false,
		movies: [],
	}

	componentDidMount() {
		this.useApi()
	}

	useApi = () => {
		const url = '/api/discover/movies'

		fetch(url)
		.then(res => res.json())
		.then(res => {
			console.log(res)
			this.setState({
				ready: true,
				movies: res
			})
		})
	}

	pouet = ()  => console.log(this.state.movies)

	render() {
		if (this.state.ready) {
			return (
				<ListCards onClick={this.pouet}>
					<Movies movies={this.state.movies} {...this.props}/> 
				</ListCards>
			)
		} else {
			return (
				<div>
					<Loader/>
				</div>
			)
		}
	}
}

const Movies = ({movies, ...props}) => {
	let urlImg = 'https://image.tmdb.org/t/p/w300_and_h450_bestv2/'
	return movies.map(mov => {
		let movie = {
			title: mov.title,
			year: mov.release_date.slice(0,4),
			poster: urlImg + mov.poster_path,
			imdbId: mov.imdbID,
			toSee: mov.to_see,
			see: mov.see
		}

		return <SoftCards key={mov.id} movie={movie} {...props}/>
	})
}

const ListCards = (props) => {
	const style = {
		display: "flex",
		justifyContent: "space-around",
		flexFlow: "row wrap"
	}

	return (
		<div style={style}>
			{props.children}
		</div>
	)
}

export default Explore