import * as types from '../../constants/actionTypes';
import * as apiHelper from '../_global/ApiHelper';
import * as sessionHelper from '../_global/SessionHelper';
import axios from 'axios';

export function register(post) {
	return function (dispatch) {
		return apiHelper.connect().post('/auth/register', post)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}

export function checkForDups(email) {
	return function (dispatch) {
		return apiHelper.connect().get('/auth/dup_email?email='+email)
			.then(res => {
				return res;
			}).catch(error => {
				throw(error);
			});
	};
}