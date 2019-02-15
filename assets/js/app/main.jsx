import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";

import { NavBar } from './component/header'

import Movie from './page/Movie'
import Home from './page/Home'

class Main extends React.Component {
	render() {
		return (
			<Router>
				<div>
					<NavBar/>

					<Switch>
						<Route exact path='/app' component={Home} />
						<Route path='/app/toSee' component={Home} />
						<Route path='/app/see' component={Home} />
						<Route path='/app/movie/:imdbId' component={Movie} />
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