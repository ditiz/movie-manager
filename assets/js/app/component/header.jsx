import React from 'react';
import styled from 'styled-components';
import { Link } from "react-router-dom";


export const NavBar = (props) => {
	return (
		<Header className="develop-toolbar__row mdc-toolbar__row">
			<Link to='/app'>
				Logo
			</Link>

			<Link className='link' to='/app/toSee'>
				Film à voir
						</Link>
			<Link className='link' to='/app/see'>
				Film vu
			</Link>

			<Search>
				<input type="text"/>
				<button>
					<i className="material-icons">face</i>
				</button>
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
		height: 100%;

		&.link {
			transition: all .2s;

			&:hover {
				background: var(--mdc-theme-primary);
			}
		}
	}
`

export const Search = styled.div`
	margin-left: auto;

	input {
		border: #FFF 1px solid;
		color: #000;
		background: white;	
		padding: .3rem .7rem;
		font-size: 1.3rem;
		border-radius: 3px;
	}
`