import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route } from "react-router-dom";

import { Test } from './test';
import { NavBar } from './component/header'

class Main extends React.Component {
	render() {
		return (
			<Router>
				<div>
					<NavBar/>

					<Route exact path='/app' component={Test} />
					<Route exact path='/app/toSee' component={Test} />
					<Route exact path='/app/see' component={Test} />
				</div>
			</Router>
		);
	}
}

ReactDOM.render(
	<Main/>,
	document.getElementById('app')
);