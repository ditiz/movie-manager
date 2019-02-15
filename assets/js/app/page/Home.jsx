import React, { Component } from 'react'
import { Link } from 'react-router-dom' 

class Home extends Component {
	render() {
		return (
			<div className='mdc-card'>
				<Link to='/app/movie/tt0093773'>voir predator</Link>
				<Link to='/app/movie/tt4123430'>voir crime de grindeval</Link>
			</div>
		)
	}
}

export default Home