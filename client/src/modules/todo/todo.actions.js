import * as types from '../../constants/actionTypes';

export function loadTodos(todoList) {
    return {type: types.LOAD_TODO_SUCCESS, todos: todoList};
}

export function saveTodo(todo) {
    return {type: types.SAVE_TODO_SUCCESS, todo: todo};
}

export function clearTodo(todo) {
    return {type: types.CLEAR_TODO_SUCCESS, todo: []};
}

