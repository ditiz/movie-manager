import React from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter as Router, Route, Switch } from "react-router-dom"

import NavBar from './component/header'

import Movie from './page/Movie'
import Home from './page/Home'
import MovieList from './page/MovieList'
import Search from './page/Search'
import Expore from './page/Explore'
import Test from "./page/testRedux"
import TestCounter from "./page/testRedux2"

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
						<Route path='/app/movie/search/:search'
							render={props => 
								<Search key={props.match.params.search || 'search'} {...props}/>
							}
						/>
						<Route path='/app/explore' component={Expore} />

						<Route exact path='/app/test' component={Test}/>
						<Route path='/app/test/counter' component={TestCounter} />
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