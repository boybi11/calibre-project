import axios from 'axios';
import toastr from 'toastr';
import * as api from '../../constants/api';


export function connect(showLog = true){
	let instance = axios.create({
		baseURL: api.URL
	});
	instance.interceptors.response.use(function (response) {
		// Do something with response data
		// if (response.data.message && showLog) {
		// 	toastr.success(response.data.message);
		// }
		//only return the data
		return response.data;
	}, function (error) {
		// Do something with response error
		if (error.data.message) {
			toastr.error(error.data.message);
		}
		return Promise.reject(error);
	});
	return instance;
}
