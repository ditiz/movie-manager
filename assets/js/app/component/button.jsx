import React from 'react';
import styled from 'styled-components';

export const BtnAddToSee = (props) => {
	
	return (
		<Button className="mdc-button mdc-button--raised">
			<span className="mdc-button__label">Film à voir</span>
		</Button>
	)
}

export const BtnAddSee = (props) => {
	
	return (
		<Button className="mdc-button mdc-button--raised">
			<span className="mdc-button__label">Film vu</span>
		</Button>
	)
}

const Button = styled.div`
	margin: 5px 10px;
`