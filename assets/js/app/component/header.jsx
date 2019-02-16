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
				<button className='mdc-button mdc-button--raised'>
					<i class="material-icons mdc-button__label"><SearchIcon/></i>
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
	display: flex;
	flex-flow: nowrap row;
	justify-content: center;

	input {
		border: #FFF 1px solid;
		color: #000;
		background: white;	
		padding: .3rem .7rem;
		font-size: 1.3rem;
		border-radius: 3px 0 0 3px;
		border: 1px solid #6200ee;
		height: 100%;
	}

	button {
		border-radius: 0 3px 3px 0;
	}
`

const SearchIcon = (props) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
		<path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0V0z"/>
		<path d="M17.01 14h-.8l-.27-.27c.98-1.14 1.57-2.61 1.57-4.23 0-3.59-2.91-6.5-6.5-6.5s-6.5 3-6.5 6.5H2l3.84 4 4.16-4H6.51C6.51 7 8.53 5 11.01 5s4.5 2.01 4.5 4.5c0 2.48-2.02 4.5-4.5 4.5-.65 0-1.26-.14-1.82-.38L7.71 15.1c.97.57 2.09.9 3.3.9 1.61 0 3.08-.59 4.22-1.57l.27.27v.79l5.01 4.99L22 19l-4.99-5z" stroke="white" fill='white'/>
	</svg>
)