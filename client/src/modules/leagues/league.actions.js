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