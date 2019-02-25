import React from 'react';
import styled from 'styled-components';

export const BtnAddToSee = (props) => {
	return (
		<Button className="mdc-button mdc-button--raised" {...props}>
			<span className="mdc-button__label">à voir</span>
		</Button>
	)
}

export const BtnAddSee = (props) => {

	return (
		<Button className="mdc-button mdc-button--raised" {...props}>
			<span className="mdc-button__label">vu</span>
		</Button>
	)
}

const Button = styled.div`
	margin: 0 .4rem .375rem .4rem;
`