import React from 'react';
import styled from 'styled-components';

export const BtnAddToSee = (props) => {
	let mdcClass = 'mdc-button mdc-button--raised'

	if (props.toSee) {
		mdcClass = 'mdc-button mdc-button--outlined'
	}

	return (
		<Button className={mdcClass} {...props}>
			<span className="mdc-button__label">à voir</span>
		</Button>
	)
}

export const BtnAddSee = (props) => {
	let mdcClass = 'mdc-button mdc-button--raised'

	if (props.see) {
		mdcClass = 'mdc-button mdc-button--outlined'
	}

	return (
		<Button className={mdcClass} {...props}>
			<span className="mdc-button__label">vu</span>
		</Button>
	)
}

const Button = styled.div`
	margin: 0 .4rem .375rem .4rem;
`