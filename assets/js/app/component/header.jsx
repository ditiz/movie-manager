import React, { Component } from 'react'
import styled from 'styled-components'
import { Link } from 'react-router-dom'

import LogoCamera from '../img/logo-camera.png'

class NavBar extends Component {

	refSearch = React.createRef()

	search = () => {
		let search = this.refSearch.current.value
		this.props.history.push('/app/movie/search/' + search)
	}

	handleKeySearch = (e) => {
		let keyCode = e.keyCode || e.which

		if (keyCode == '13') {
			this.search()
			return false
		}
	} 

	render() {
		return (
			<Header className="develop-toolbar__row mdc-toolbar__row">
				<Link to='/app'>
					<Logo src={LogoCamera} alt="logo"/>
				</Link>

				<Link className='link' to='/app/toSee'>
					Film à voir
				</Link>
				<Link className='link' to='/app/see'>
					Film vu
				</Link>

				<Link className='link' to='/app/explore'>
					Explorer
				</Link>

				<Search>
					<input type="text" ref={this.refSearch} onKeyDown={this.handleKeySearch}/>
					<button className='mdc-button mdc-button--raised' onClick={this.search}>
						<i className="material-icons mdc-button__label"><SearchIcon/></i>
					</button>
				</Search>
			</Header>
		)
	}
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
		border: 1px solid #FFF;
		height: 100%;
	}

	button {
		border-radius: 0 3px 3px 0;
	}
`

const SearchIcon = (props) => {
	let icon = `M15.5 
	14h-.79l-.28-.27C15.41 
	12.59 16 11.11 16 9.5 16 
	5.91 13.09 3 9.5 3S3 5.91 
	3 9.5 5.91 16 9.5 16c1.61 
	0 3.09-.59 
	4.23-1.57l.27.28v.79l5 
	4.99L20.49 19l-4.99-5zm-6 
	0C7.01 14 5 11.99 5 
	9.5S7.01 5 9.5 5 14 
	7.01 14 9.5 11.99 14 9.5 14z`

	return (
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
			<path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0V0z"/>
			<path d={icon} stroke="white" fill='white'/>
		</svg>
	)
}

const Logo = styled.img`
	height: 2rem;
	&:hover {
		filter: 
			invert(87%) 
			sepia(99%) 
			saturate(7445%) 
			hue-rotate(269deg) 
			brightness(86%) 
			contrast(123%);
	}
`

export default NavBar