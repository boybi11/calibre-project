import * as sessionHelper from '../modules/_global/SessionHelper';

export default {
	posts: [],
	samples: {
		list : [],
		selected : {}
    },
    leagues: [],
    todos: [
    {   id: 0,
        text: 'learn react'
    },{
        id: 1,
        text: 'learn to love'
    },{
        id: 2,
        text: 'learn to move on'
    }],
	user: sessionHelper.getUser()
};
