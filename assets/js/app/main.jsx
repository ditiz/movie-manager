import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Link } from "react-router-dom";

import { Test } from './test';

class Main extends React.Component {
	render() {
		return (
			<Router>
				<div>
					<Route exact path='/' component={Test} />

					<header>
						<div>
							<Link to='/toSee'>
								Film à voir
						</Link>
							<Link to='/see'>
								Film bu
						</Link>
						</div>
					</header>
				</div>
			</Router>
		);
	}
}

ReactDOM.render(
	<Main/>,
	document.getElementById('app')
);