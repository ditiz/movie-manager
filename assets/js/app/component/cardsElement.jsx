import styled from 'styled-components'

const Card = styled.div`
	width: 19rem;
	background: #212121;
	color: #FFF;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;
	font-family: Roboto;
	margin: 2rem auto;
	transition: all 0.3s cubic-bezier(.25,.8,.25,1);
	font-size: 1rem;

  	&:hover {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)
	}
`

const Poster = styled.img`
	width: 100%;
`

const Bottom = styled.div`
	flex-shrink: 1;
	min-width: 30%;
	width: 100%;
	display: flex;
	justify-content: space-between;
	flex-flow: column nowrap;

	& header {
		text-align: center;
	}

	& > p {
		padding: 0 50px;
	}
`

const Down = styled.div`
	display: flex;
	justify-content: space-evenly;
	flex-flow: row nowrap;
	margin: .375rem .7rem;

	button {
		margin: 0;
	}
`

export { Card, Poster, Bottom, Down }