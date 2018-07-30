import * as api from '../../constants/api';


const APP_KEY = "CST";
const USR_KEY = `${APP_KEY}_USR`;

export function getUser() {
	if (localStorage.getItem(USR_KEY)) {
		return JSON.parse(localStorage.getItem(USR_KEY));
	}
	return {};
}	

export function setUser(user) {
	//dummy permissions
	user.permissions = ['adb0a36965f46601161ea60a7ee81a5e'];
	localStorage.setItem(USR_KEY, JSON.stringify(user));
}


export function logout() {
	localStorage.removeItem(USR_KEY);
}

export function loggedIn() {
	if (localStorage.getItem(USR_KEY)) {
		return true;
	} else {
		return false;
	}
}