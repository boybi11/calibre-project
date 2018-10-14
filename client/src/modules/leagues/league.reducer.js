import * as types from '../../constants/actionTypes';
import initialState from '../../reducers/initialState';

export default function (state = initialState.leagues, action) {
	
	let index;

	switch(action.type) {

		case types.LEAGUE_LIST_RETRIEVED:
			return action.data;
		default:
			return state;
	}
} 