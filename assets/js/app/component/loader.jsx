import React, { Component } from 'react'
import styled from 'styled-components';

import loaderGif from '../img/loader.gif'

export const Loader = (props) => (
	<ImgDiv>
		<Img src={loaderGif} alt="loader"/>
	</ImgDiv>
)

const Img = styled.img`
	margin: auto;
	height: 30rem;
`

const ImgDiv = styled.div`
	width: 100%;
	display: flex;
	justify-content: center;
`