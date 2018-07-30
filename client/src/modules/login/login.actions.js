import * as types from '../../constants/actionTypes';
import * as apiHelper from '../_global/ApiHelper';
import * as sessionHelper from '../_global/SessionHelper';
import axios from 'axios';

export function loginSuccess(res) {
	sessionHelper.setUser(res.data);
	return {type: types.LOGIN_SUCCESS, user: res.data};
}

export function logoutSuccess() {
	sessionHelper.logout();
	return {type: types.LOGOUT_SUCCESS, user: {}};
}

export function initUser(){
	return {type: types.LOGIN_SUCCESS, user: sessionHelper.getUser()};
}


export function doLogin(post) {
	return function (dispatch) {
		return apiHelper.connect().post('/auth', post)
			.then(res => {
				dispatch(loginSuccess(res));
			}).catch(error => {
				throw(error);
			});
	};
}

export function doLogout() {
	return function (dispatch) {
		dispatch(logoutSuccess());
	};
}