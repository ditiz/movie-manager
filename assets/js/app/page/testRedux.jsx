import React, { useState, useEffect } from 'react'
import { createStore } from "redux"
import { Provider } from "react-redux"
import { connect } from "react-redux"

function Test() {
	const store = createStore(rootReducer)
	
	return (
		<Provider store={store}>
			<div>
				<h2>Article</h2>
				<ListArticle />
			</div>
			<div>
				<Form/>
			</div>
	</Provider>
	)
}

// Add article
function mapDispatchToProps(dispatch) {
	return {
		addArticle: article => dispatch(addArticle(article))
	};
}

function ConnectedForm (props) {
	let [title, setTitle] = useState('')

	const handleSubmit = (e) => {
		e.preventDefault()
		console.log(e, title)
		
		const id = 3
		props.addArticle({ title, id })

		setTitle('')
	}

	return (
		<form onSubmit={handleSubmit}>
			<fieldset>
				<legend>Ajouter article</legend>
				<input type="text" onChange={(e) => setTitle(e.target.value)} value={title}/>
				<input type="submit"/>
			</fieldset>
		</form>
	)
}

const Form = connect(null, mapDispatchToProps)(ConnectedForm);

//List article
const mapStateToProps = state => {
	return { articles: state.articles };
};

const ConnectedList = ({articles}) => (
	<ul>
		{articles.map((article) => (
			<li key={article.id}>{article.title}</li>
		))}
	</ul>
)

const ListArticle = connect(mapStateToProps)(ConnectedList)

//Reducer
const ADD_ARTICLE = "ADD_ARTICLE"

const initialState = {
	articles: [
		{ title: 'first article', id: 1 },
		{ title: 'second article', id: 2 },
	]
}

function addArticle(payload) {
	return { type: "ADD_ARTICLE", payload }
}

function rootReducer(state = initialState, action) {
	if (action.type === ADD_ARTICLE) {
		return Object.assign({}, state, {
			articles: state.articles.concat(action.payload)
		});
	}
	return state
}

//Store
const store = createStore(rootReducer)

window.store = store;
window.addArticle = addArticle;


store.dispatch(addArticle({ title: 'React Redux Tutorial for Beginners', id: 1 }))


export default Test 