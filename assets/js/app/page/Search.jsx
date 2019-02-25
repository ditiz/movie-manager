import React, { Component } from 'react'
import SoftCards from '../component/softCards'

class Search extends Component {

	state = {
		movies: [],
		ready: false
	}

	componentDidMount() {
		let search = this.props.match.params.search,
			url = '/api/movies/search/' + search

		fetch(url)
		.then(res => res.json())
		.then(res => {
			if (res.Response === "True") {
				this.setState({
					movies: res.Search,
					ready: true
				})
			}
		})
	}

	render() {
		if (this.state.ready) {
			return (
				<Render movies={this.state.movies} {...this.props}/>
			)
		} else {
			return (
				<div>
					Not ready
				</div>
			)
		}
	}
}

const Render = ({movies, ...props}) => {
	return movies.map(mov => {
		let movie = {
			title: mov.Title,
			year: mov.Year,
			poster: mov.Poster,
			imdbId: mov.imdbID
		}

		return <SoftCards movie={movie} key={movie.imdbId} {...props}/>
	})
}

export default Search