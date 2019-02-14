import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Link } from "react-router-dom";

import { Test } from './test';
import { Header } from './component/header'

class Main extends React.Component {
	render() {
		return (
			<Router>
				<div>
					<Header>
						<Link to='/app/toSee'>
							Film à voir
						</Link>
						<Link to='/app/see'>
							Film bu
						</Link>
					</Header>

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