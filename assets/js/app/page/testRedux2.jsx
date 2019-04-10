import React, { useState, useEffect } from 'react'
import { createStore } from "redux"
import { Provider } from "react-redux"
import { connect } from "react-redux"

// init redux

//reducer
const initialState = {
	counter: 0
}

function increment () {
	return {
		type: 'add',
		value: 1
	}
}

function decrement () {
	return {
		type: 'remove',
		value: 1
	}
}

function rootReducer (state = initialState, action) {
	if (action.type == 'add') {
		return  {
			counter: state.counter + action.value
		}
	} else if (action.type == 'remove') {
		return {
			counter: state.counter - action.value
		}
	}

	return state
}

//store
const store = createStore(rootReducer)

function TestCounter(props) {
	return (
		<Provider store={store}>
			<DisplayCounter/>
			<DisplayInterect/>
		</Provider>
	)
}

//display

const mapStateToProps = state => {
	return { counter: state.counter };
};

const ConnectDisplay = ({counter}) => (
	<h1>{counter}</h1>
)

const DisplayCounter = connect(mapStateToProps)(ConnectDisplay)

//edit counter value
function mapDispatchToProps(dispatch) {
	return {
		increment: () => dispatch(increment()),
		decrement: () => dispatch(decrement()),
	};
}

function ConnectInterect({increment, decrement}) {
	const actionIncrement = () => {
		increment()
	}

	const actionDecrement = () => {
		decrement()
	}

	return (
		<div>
			<button onClick={actionIncrement}>increment</button>
			<button onClick={actionDecrement}>decrement</button>			
		</div>
	)
}

const DisplayInterect = connect(null, mapDispatchToProps)(ConnectInterect)


export default TestCounter