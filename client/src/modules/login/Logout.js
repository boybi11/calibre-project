/*eslint-disable no-console*/

import React, {PropTypes} from 'react';
import {browserHistory}  from 'react-router';
import toastr from 'toastr';
import * as sessionHelper from '../_global/SessionHelper';
import * as loginActions from './login.actions';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';

class Logout extends React.Component {
	constructor(props, context) {
		super(props, context);
	}

	componentDidMount() {
		//redirect to home page if already logged in
		toastr.success("Logged out successfully!");
		if (!sessionHelper.loggedIn()){
			browserHistory.push("/login");
		} else {
			this.props.actions.doLogout();
			browserHistory.push("/login");
		}
	}

	render() {
		return (
			<div> Logging out </div>
		);
	}
}

Logout.propTypes = {
	actions: PropTypes.object.isRequired
};


function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(loginActions, dispatch)
	};
}

export default connect(null, mapDispatchToProps)(Logout);