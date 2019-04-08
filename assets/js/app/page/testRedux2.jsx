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

window.store = store
window.increment = increment
window.decrement = decrement

store.dispatch(decrement())

function TestCounter(props) {
	return (
		<Provider store={store}>
			pouet
		</Provider>
	)
}

//display
function ConnectDisplay () {
	
}

//edit counter value
function ConnectInterect () {

}


export default TestCounter