/*eslint-disable no-console*/

import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as loginActions from './login.actions';
import {browserHistory}  from 'react-router';
import toastr from 'toastr';
import DocumentTitle from 'react-document-title';
import TextInput from '../_global/forms/TextInput';
import * as sessionHelper from '../_global/SessionHelper';

import Registration from '../registration/Registration';

class Login extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.state = {
			user: {email:'', password:''},
			errors: {},
			saving: false,
			register: "out"
		};

		//redirect to home page already logged in
		if (sessionHelper.loggedIn()){
			browserHistory.push("/");
		}

		this.handleInputState = this.handleInputState.bind(this);
		this.doLogin = this.doLogin.bind(this);
		this.postFormIsValid = this.postFormIsValid.bind(this);
		this.toggleRegister = this.toggleRegister.bind(this);
	}

	componentDidMount() {
		// this.props.actions.loadPosts();
	}

	handleInputState(event) {
		const field = event.target.name;
		let user = this.state.user;
		user[field] = event.target.value;
		return this.setState({user: user});
	}

	postFormIsValid() {
		let formIsValid = true;
		let errors = {};

		if (this.state.user.email.length < 1) {
			errors.email = 'Email is required';
			formIsValid = false;
		}

		if (this.state.user.password.length < 1) {
			errors.password = 'Password is required';
			formIsValid = false;
		}

		this.setState({errors: errors});
		return formIsValid;
	}

	redirectToPostsPage() {
		this.setState({saving: false});
		browserHistory.push('/');
	}

	doLogin(event) {
		event.preventDefault();
		if (!this.postFormIsValid()) {
			return;
		}

		this.setState({saving: true});
		this.props.actions.doLogin(this.state.user)
			.then(res => {
				this.redirectToPostsPage(res);
			})
			.catch(error => {
				this.setState({saving: false});
			});
	}

	toggleRegister() {
		let registerState = this.state.register;
		let register = "";

		if (registerState == "in") {
			register = "out";
		} else {
			register = "in";
		}

		this.setState({register});

	}


	render() {
		return (
			<div id="loginContainer" className="flex flex-align-center flex-justify-center">
				<DocumentTitle title="Login"/>
				<div className="login-box-holder">
					<div className={(this.state.register == "in" ? "scale-down-50" : "") + " login-box relative"}>
						<div className="row relative"> 
							<div className="text-center margin-top-10">
								<div className="icon icon-h1 icon-circular bg-primary margin-right">
									<i className="ion-log-in text-h1"></i>
								</div>
							</div>
							<h1 className="typ-h1 text-center" style={{marginTop: "0px"}}>
								Login
							</h1>
							<div className="panel-body">
								<form className="form">
									<div className="form-group">
										<TextInput
										name="email"
										label="Email"
										value={this.state.user.email}
										onChange={this.handleInputState}
										error={this.state.errors.email}/>
									</div>
									<div className="form-group">
										<TextInput
										name="password"
										label="Password"
										value={this.state.user.password}
										onChange={this.handleInputState}
										type="password"
										error={this.state.errors.password}/>
									</div>
									<div className="form-group text-center">
										<button
											type="submit"
											className="btn btn-primary btn-block submit-btn"
											disabled={this.state.saving}
											onClick={this.doLogin}>
											<span className={this.state.saving ? "hidden" : ""}>
												Login
											</span>
											<span className={this.state.saving ? "" : "hidden"}>
												Authenticating
											</span>
											<i className={(!this.state.saving ? 'hidden' : '') + " fas fa-spinner fa-spin margin-left"}></i>
										</button>
									</div>
									<div className="form-group text-center flex flex-align-center">
										<div className="flex-1">
											<a
												role="button"
												onClick={this.toggleRegister}
											>
												Sign Up
											</a>
										</div>
										<div className="flex-1">
											<a
												href="#"
											>
													Forgot password?
											</a>
										</div>
									</div>
								</form>
							</div> 
						</div>
					</div>
				</div>
				<Registration isOpen={this.state.register} toggle={this.toggleRegister}/>
				<div
					className="absolute upper-left"
				>
					<img
						src={require('assets/img/logo.png')}
						className="logo-small"
					/>
				</div>
			</div>
		);
	}
}


Login.propTypes = {
	user: PropTypes.object.isRequired,
	actions: PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		user: state.user
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(loginActions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(Login);