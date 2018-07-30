import {combineReducers} from 'redux';
import posts from '../modules/posts/posts.reducer';
import samples from '../modules/samples/samples.reducer';
import todos from '../modules/todo/todo.reducer';
import login from '../modules/login/login.reducer';

const rootReducer = combineReducers({
	posts,
	samples,
    todos,
	user : login
});

export default rootReducer;
