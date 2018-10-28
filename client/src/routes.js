/*eslint-disable no-console*/

import React from 'react';
import {Route, IndexRoute, Redirect} from 'react-router';
import Layout from './modules/Layout';
import LayoutBlank from './modules/LayoutBlank';
import MainApp from './modules/MainApp';
import Home from './modules/home/Home';
import Dashboard from './modules/dashboard/Dashboard';
import Login from './modules/login/Login';
import Logout from './modules/login/Logout';
import Posts from './modules/posts/Posts';
import Leagues from './modules/leagues/Leagues';
import LeagueView from './modules/leagues/LeagueView';
import ManagePost from './modules/posts/ManagePost';
import Samples from './modules/samples/Samples';
import ManageSample from './modules/samples/ManageSample';
import ManageToDo from './modules/todo/ManageToDo';
import PageNotFound from './modules/_global/PageNotFound';
import * as sessionHelper from './modules/_global/SessionHelper';
import Tasks from './modules/tasks/Tasks';

const requireAuth = (nextState, replace) => {
	if (!sessionHelper.loggedIn()) {
		console.log("REDIRECTING TO LOGIN...");
		replace({
			pathname: '/login',
			state: { nextPathname: nextState.location.pathname }
		});
	} else {
		console.log("YOU ARE LOGGED IN...");
	}
};

export default (
	<Route path="/" component={MainApp}>
		<Route component={Layout}>
			<IndexRoute component={Dashboard} onEnter={requireAuth} />
			<Route path="posts" component={Posts} />
			<Route path="logout" component={Logout}/>
			<Route path="home" component={Home} />
			<Route path="post" component={ManagePost} />
			<Route path="post/:id" component={ManagePost} />
			<Route path="samples" component={Samples} />
			<Route path="sample" component={ManageSample} />
			<Route path="sample/:id" component={ManageSample} />
			<Route path="leagues" component={Leagues} />
			<Route path="league/:slug" component={LeagueView} />
			<Route path="tasks" component={Tasks} />
			<Route path="todo" component={ManageToDo} />

			<Route path="page-not-found" component={PageNotFound} />
		</Route>
		<Route component={LayoutBlank}>
			<Route path="login" component={Login}/>
		</Route>
		<Redirect from="*" to="page-not-found" />
	</Route>
);

