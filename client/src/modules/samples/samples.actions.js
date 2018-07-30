/*eslint-disable no-console*/

import * as types from '../../constants/actionTypes';
import * as api from '../../constants/api';
import * as apiHelper from '../_global/ApiHelper';

export function loadSamples() {
	//pass true/false to connect to display TOASTR message
	let request = apiHelper.connect(false).get(`/samples/get`);
	return { type: types.LOAD_SAMPLES_SUCCESS, payload: request };
}

export function findSamples(id) {
	let request = apiHelper.connect(false).get(`/samples/find`, {
		params : {
			id:id
		}
	});
	return { type: types.FIND_SAMPLE_SUCCESS, payload: request };
}

export function deleteSample(id) {
	let request = apiHelper.connect(true).post(`/samples/destroy`, {id:id});
	return { type: types.DELETE_SAMPLE_SUCCESS, payload: id };
}

export function updateSample(sample) {
	let request = apiHelper.connect(true).post(`/samples/update`, Object.assign({}, sample));
	return { type: types.UPDATE_SAMPLE_SUCCESS, payload: request };
}

export function createSample(sample) {
	let request = apiHelper.connect(true).post(`/samples/store`, Object.assign({}, sample));
	return { type: types.CREATE_SAMPLE_SUCCESS, payload: request };
}
