import * as types from '../../constants/actionTypes';
import initialState from '../../reducers/initialState';

export default function (state = initialState.samples, action) {
	
	let index;
	switch(action.type) {
		case types.LOAD_SAMPLES_SUCCESS:
			return Object.assign({},
				state,
				{ list : action.payload.data.list }
			);

		case types.FIND_SAMPLE_SUCCESS:
			return Object.assign({},
				state,
				{ selected : action.payload.data }
			);

		case types.UPDATE_SAMPLE_SUCCESS:
			return Object.assign({},
				state,
				{ selected : {} } //clear selected
			);

		case types.CREATE_SAMPLE_SUCCESS:
			return Object.assign({},
				...state,
				{ selected : action.payload.data },
				{list : [
					Object.assign({}, action.payload.data)
				]});


		case types.DELETE_SAMPLE_SUCCESS:
			index = state.list.findIndex(sample => sample.id == action.payload);
			return Object.assign({},
				state,
				{list : [
					...state.list.slice(0, index),
					...state.list.slice(index + 1)
				]});

		default:
			return state;
	}
} 