import React, { PureComponent } from 'react'

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
			imdbId: mov.imdbID,
			toSee: mov.to_see,
			see: mov.see
		}

		return <SoftCards movie={movie} key={movie.imdbId + Math.random()} {...props}/>
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

export default Search