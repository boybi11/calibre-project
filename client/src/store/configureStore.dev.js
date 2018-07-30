import {createStore, applyMiddleware, compose} from 'redux';
import rootReducer from '../reducers/rootReducer';
import thunk from 'redux-thunk';
import createLogger from 'redux-logger';
import ReduxPromise from 'redux-promise';

const logger = createLogger({collapsed: true});

export default function configureStore(initialState) {

	const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
	return createStore(
		rootReducer,
		initialState,
		composeEnhancers(
			applyMiddleware(thunk, ReduxPromise, logger)
		)
	);
}