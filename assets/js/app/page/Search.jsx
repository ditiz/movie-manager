import React, { PureComponent } from 'react'
import styled from 'styled-components'

import SoftCards from '../component/softCards'
import { Loader } from '../component/loader'

class Search extends PureComponent {

	state = {
		movies: [],
		ready: false,
		search: ''
	}


	componentDidMount() {
		let search = this.props.match.params.search
			
		this.setState({
			search: search
		})

		this.search(search)
	}

	search = (search) => {
		let url = '/api/movies/search/' + search

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
				<ListCards>
					<Render movies={this.state.movies} {...this.props} />
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

const Render = ({movies, ...props}) => {
	return movies.map(mov => {
		let movie = {
			title: mov.Title,
			year: mov.Year,
			poster: mov.Poster,
			imdbId: mov.imdbID
		}

		return <SoftCards movie={movie} key={movie.imdbId + Math.random()} {...props}/>
	})
}

const ListCards = styled.div`
	display: flex;
	justify-content: space-evenly;
	flex-flow: row nowrap;
`

export default Search