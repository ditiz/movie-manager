import React from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter as Router, Route, Switch } from "react-router-dom"

import NavBar from './component/header'

import Movie from './page/Movie'
import Home from './page/Home'
import MovieList from './page/MovieList'
import Search from './page/Search'
 
class Main extends React.Component {
	render() {
		return (
			<Router>
				<div>
					<NavBar/>

					<Switch>
						<Route exact path='/app' component={Home} />
						<Route exact path='/app/toSee' key="toSee" component={MovieList} />
						<Route exact path='/app/see' key="see" component={MovieList} />
						<Route exact path='/app/movie/:imdbId' component={Movie} />
						<Route exact path='/app/movie/search/:search' component={Search} />
					</Switch>
				</div>
			</Router>
		);
	}
}

ReactDOM.render(
	<Main/>,
	document.getElementById('app')
);