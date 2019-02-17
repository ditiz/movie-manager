import React, { Component } from 'react'
import styled from 'styled-components';
import { Link } from 'react-router-dom' 

class Home extends Component {
	render() {
		return (
			<BoxParent>
				<Box>
					<Title>Dernier film ajouté à voir</Title>
				</Box>
				<Box>
					<Title>Dernier film vu</Title>
				</Box>
			</BoxParent>
		)
	}
}

const Box = (props) => (
	<BoxCss className="mdc-card">
		{props.children}
	</BoxCss>
)

const BoxCss = styled.div`
	width: 30rem;
	height: 35rem;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;
	text-align: center;
	font-family: Roboto;
	margin: 2rem auto;
	transition: all 0.3s cubic-bezier(.25,.8,.25,1);
	font-size: 1rem;

  	&:hover {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)
	}
`

const BoxParent = styled.div`
	display: flex;
	justify-content: space-evenly;;
	flex-flow: wrap row;
	width: 100%;
`

const Title = styled.h2`
	color: white;
`

export default Home