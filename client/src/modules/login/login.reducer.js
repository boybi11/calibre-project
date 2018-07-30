import * as types from '../../constants/actionTypes';
import initialState from '../../reducers/initialState';

export default function (state = initialState.user, action) {
	
	let index;

	switch(action.type) {

		case types.LOGIN_SUCCESS:
			return action.user;
		case types.LOGOUT_SUCCESS:
			return {};
		default:
			return state;
	}
} 