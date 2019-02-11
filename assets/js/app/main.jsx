import React from 'react';
import ReactDOM from 'react-dom';

class Main extends React.Component {
	render() {
		return (
			<React.Fragment>
				<h1>Hello world!</h1>
				<button className="mdc-button">
					<span className="mdc-button__label">Button</span>
				</button>

				<div ref={this.divRef}></div>
			</React.Fragment>
		);
	}
}

ReactDOM.render(
	<Main/>,
	document.getElementById('app')
);