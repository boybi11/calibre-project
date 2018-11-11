import * as types from '../../constants/actionTypes';
import * as apiHelper from '../_global/ApiHelper';
import * as sessionHelper from '../_global/SessionHelper';
import axios from 'axios';


export function getList(id) {
	return function (dispatch) {
		return apiHelper.connect().get('/classes/get_list?gm_id=' + id)
			.then(res => {
				dispatch({type: types.LEAGUE_LIST_RETRIEVED, data: res.data});
			}).catch(error => {
				throw(error);
			});
	};
}

export function getLeagues(id) {
	return function (dispatch) {
		return apiHelper.connect().get('/classes/get_leagues?player=' + id)
			.then(res => {
				dispatch({type: types.LEAGUE_LIST_RETRIEVED, data: res.data});
			}).catch(error => {
				throw(error);
			});
	};
}

export function findList(keyword, player, gm) {
	return function (dispatch) {
		return apiHelper.connect().get('/classes/find_list?keyword=' + keyword + '&player=' + player + '&gm=' + gm)
			.then(res => {
				dispatch({type: types.LEAGUE_LIST_RETRIEVED, data: res.data});
			}).catch(error => {
				throw(error);
			});
	};
}

export function create(params) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/create', params)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function archive(ids) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/delete', ids)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function getTasks(slug) {
	return function (dispatch) {
		return apiHelper.connect().get('/classes/get_tasks?slug=' + slug)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function getTask(id) {
	return function (dispatch) {
		return apiHelper.connect().get('/classes/get_task?id=' + id)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function addTask(data) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/add_task', data)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function removeTask(slug) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/delete_task?slug=' + slug)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function join(data) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/join', data)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function acceptUser(data) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/accept_user', data)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function removeUser(data) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/remove_user', data)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function completeTask(data) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/complete_task', data)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function finishTask(data) {
	return function (dispatch) {
		return apiHelper.connect().post('/classes/finish_task', data)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}