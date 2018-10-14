import {combineReducers} from 'redux';
import posts from '../modules/posts/posts.reducer';
import samples from '../modules/samples/samples.reducer';
import todos from '../modules/todo/todo.reducer';
import login from '../modules/login/login.reducer';
import leagues from '../modules/leagues/league.reducer';

const rootReducer = combineReducers({
	posts,
	samples,
	todos,
	leagues,
	user : login
});

export default rootReducer;
