import React, { PureComponent } from 'react'

import ExploreCards from '../component/exploreCards'
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
			this.setState({
				ready: true,
				movies: res
			})
		})
	}

	render() {
		if (this.state.ready) {
			return (
				<div>
					<ListCards>
						<Movies movies={this.state.movies} {...this.props} />
					</ListCards>
				</div>
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
		}

		return <ExploreCards movie={movie} key={mov.id} {...props}/>
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