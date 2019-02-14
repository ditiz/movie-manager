import React from 'react';
import styled from 'styled-components';

export const Header = styled.header`
	width: 100%;
	background: #000;
	color: #FFF;
	margin: 0;
	padding: .375rem .75rem;

	a {
		color: #FFF;
		text-decoration: none;
		padding: .375rem .75rem;
		transition: all .1s

		&:hover {
			background: #484848;
		}
	}
`