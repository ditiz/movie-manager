import React from 'react';
import styled from 'styled-components';
import { Link } from "react-router-dom";


export const NavBar = (props) => {
	return (
		<Header className="develop-toolbar__row mdc-toolbar__row">
			<Link to='/app/toSee'>
				Film à voir
						</Link>
			<Link to='/app/see'>
				Film vu
			</Link>

			<Search>
				<div className="mdc-text-field mdc-text-field--outlined">
					<input type="text" className="mdc-text-field__input" aria-label="Label"/>
						<div className="mdc-notched-outline">
							<div className="mdc-notched-outline__leading"></div>
							<div className="mdc-notched-outline__trailing"></div>
						</div>
				</div>
			</Search>
		</Header>
	)
}

export const Header = styled.header`
background: #000;
color: #FFF;
font-size: 1.3rem;
padding: .375rem .75rem;

a {
	color: #FFF;
	text-decoration: none;
	padding: .375rem .75rem;
	transition: all .2s;
	height: 100%;

	&:hover {
		background: var(--mdc-theme-primary);
	}
}
`

export const Search = styled.div`
	border: #FFF 1px solid;
	position: absolute;
	right: 0;
	max-height: 100%;

	input.mdc-text-field__input{
		color: #FFF !important;
	}
`