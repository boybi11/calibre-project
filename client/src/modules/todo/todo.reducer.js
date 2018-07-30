import * as types from '../../constants/actionTypes';
import initialState from '../../reducers/initialState';

export default function (state = initialState.todos, action) {

    let index;

    switch(action.type) {
        case types.SAVE_TODO_SUCCESS: {
            return [
                ...state,
                {
                    id: Math.random(),
                    text: action.todo
                }
            ]
        }

        case types.CLEAR_TODO_SUCCESS: {
            return []
        }

        default:
            return state;
    }
}
