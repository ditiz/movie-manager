import React, { PureComponent } from 'react'
import styled from 'styled-components'

const Explore = React.memo(function Explore() {

	const [ready, setReady] = React.useState(false)
	const [movies, setMovies] = React.useState([])

	const useApi = () => {
		//url temporaire
		const url = '/api/movies/search/scrubs'

		fetch(url)
		.then(res => res.json)
		.then(res => {
			setMovies(res)
			setReady(true)
		}).catch(err => alert(err.reason))
	}


	return (
		<div onLoad={useApi()}>
			Explore
		</div>
	)
})

export default Explore