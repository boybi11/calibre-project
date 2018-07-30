/*eslint-disable no-console*/

import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import _ from 'lodash';
import * as registrationActions from './registration.actions';
import {bindActionCreators} from 'redux';
import TextInput from '../_global/forms/TextInput';
import CTooltip from '../_global/CTooltip';
import * as sessionHelper from '../_global/SessionHelper';

import 'simplebar'; // or "import SimpleBar from 'simplebar';" if you want to use it manually.
import 'simplebar/dist/simplebar.css';

class Registration extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.state = {
			account: {
				first_name: '',
				middle_name: '',
				last_name: '',
				type: 'student',
				username: '',
				password: ''
			},
			initialFormValue: {
				first_name: '',
				middle_name: '',
				last_name: '',
				type: 'student',
				username: '',
				password: ''
			},
			validation: {
				first_name: ['required'],
				middle_name: [],
				last_name: ['required'],
				type: [],
				username: ['required'],
				password: ['required', 'length-6']
			},
			passwordStr: 'poor',
			usernameState: 0,
			formState: '',
			error: 'Please fill in all the details',
			checkForDups: '',
			saving: false
		};

		this.handleInputState = this.handleInputState.bind(this);
		this.computePasswordStr = this.computePasswordStr.bind(this);
		this.submitRegistration = this.submitRegistration.bind(this);
		this.resetForm = this.resetForm.bind(this);
		this.toggle = this.toggle.bind(this);
	}

	componentDidMount() {
		this.checkForDups = _.debounce((term) => {
								this.props.actions.checkForDups(term)
									.then(res => {
										if (res.result) {
											if (res.data) {
												this.setState({usernameState: 2, error: "The username you entered is already in use."});
											} else {
												this.setState({usernameState: 1});
											}
										}
									});
							}, 300);
	}

	resetForm() {
		let account = Object.assign({}, this.state.initialFormValue);
		let passwordStr = this.computePasswordStr(account.password);
		let error = "Please fill in all the details.";
		let formState = "success";
		let usernameState = 0;
		this.setState({ account, passwordStr, error, formState, usernameState });
	}

	handleInputState(event) {
		const field = event.target.name;
		let account = this.state.account;
		let passwordStr = this.state.passwordStr;
		let error = '';
		account[field] = event.target.value;
		
		if (field == "password") {
			passwordStr = this.computePasswordStr(account[field]);
		} else if (field == "username") {
			this.checkForDups(account[field]);
		}

		Object.keys(account).map(key => {
			if (key == "password" && account[key].length < 6) {
				error = 'Password must be atleast 6 characters long';
			}

			if (!account[key] && key !== "middle_name") {
				error = 'Please fill in all the details.';
			}
		});

		return this.setState({ account, passwordStr, error });
	}

	submitRegistration() {
		let formFields = Object.assign({}, this.state.account);

		this.setState({saving: true});
		this.props.actions.register(this.state.account)
			.then(res => {
				this.setState({saving: false});

				if (res.result) {
					this.resetForm();
				}
			})
			.catch(error => {
				this.setState({saving: false});
			});
	}

	computePasswordStr(password) {
		let upperCaseRegx = new RegExp("(?=.*[A-Z])");
		let numericCaseRegx = new RegExp("(?=.*[0-9])");
		let specialCaseRegx = new RegExp("(?=.*[!@#\$%\^&])");

		let passwordStr = 0;
		let passwordCategory = {
			0: "poor",
			1: "weak",
			2: "intermediate",
			3: "strong",
			4: "over powered"
		};

		if(password.length >= 6)
			passwordStr++;

		if(upperCaseRegx.test(password))
			passwordStr++;

		if(numericCaseRegx.test(password))
			passwordStr++;

		if(specialCaseRegx.test(password))
			passwordStr++;

		return passwordCategory[passwordStr];
	}

	toggle() {
		this.props.toggle();
		this.resetForm(); this.setState({formState: ''});
	}

	render() {
		return (
			<div className={this.props.isOpen + " out-of-bounds out-of-bounds-right flex fixed full-width full-height"}>
				<div className="flex-1" onClick={this.toggle}>
				</div>
				<div id="registrationContainer" className={this.props.isOpen + (this.props.isOpen == "in" ? " animated jello" : "") + " relative flex flex-align-center"}>
					<div className="flex-1 full-height" data-simplebar>
						<div className={(this.state.formState == "success" ? " scale-out" : " transitioned-3") + " pad-sides-20 flex flex-direction-column relative"}>
							<div className="margin-none text-h2 margin-top-20">
								<div className="text-center">
									<div className="icon icon-h1 icon-circular bg-success margin-right">
										<i className="ion-edit"></i>
									</div>
								</div>
								<div className="text-center margin-top-10">
									Registration
								</div>
							</div>
							<div className="flex-1">
								<div className="pad-sides-15">
									<div className="form-group margin-top-15">
										<TextInput
											name="type"
											label="Type"
											value={this.state.account.type}
											onChange={this.handleInputState}
											type="select"
											options={{student:'Player', teacher:'Game Master'}}
										/>
									</div>
									<div className="form-group margin-top-15 relative">
										<TextInput
											name="username"
											label="Username"
											value={this.state.account.username}
											onChange={this.handleInputState}
											type="text"
											autocomplete="off"
										/>
										<div className="absolute right-0 top-0 flex flex-align-center full-height pad-right zindex-2">
											<CTooltip title="Unavailable" placement="left">
												<i className={(this.state.usernameState != 2 ? "hidden animated jello" : "animated jello") + " fas fa-times-circle text-danger text-large"}></i>
											</CTooltip>
										</div>
										<div className="absolute right-0 top-0 flex flex-align-center full-height pad-right zindex-2">
											<CTooltip title="Available" placement="left">
												<i className={(this.state.usernameState != 1 ? "hidden animated jello" : "animated jello") + " fas fa-check-circle text-success text-large"}></i>
											</CTooltip>
										</div>
									</div>
									<div className="form-group margin-top-15 relative">
										<TextInput
											name="password"
											label="Password"
											value={this.state.account.password}
											onChange={this.handleInputState}
											type="password"
										/>
										<div className="absolute right-0 top-0 flex flex-align-center full-height zindex-2">
											<CTooltip title={this.state.passwordStr} placement="left">
												<div>
													<img
														src={require('assets/img/pw_str/poor.png')}
														className={(this.state.passwordStr == "poor" ? "" : "hidden ") + "logo-small thumb-20 animated infinite duration-5 wobble-with-delay zindex-2"}
														data-toggle="tooltip"
													/>
													<img
														src={require('assets/img/pw_str/weak.png')}
														className={(this.state.passwordStr == "weak" ? "" : "hidden ") + "logo-small thumb-20 animated infinite duration-5 rubberBand-with-delay zindex-2"}
														data-toggle="tooltip"
													/>
													<img
														src={require('assets/img/pw_str/intermediate.png')}
														className={(this.state.passwordStr == "intermediate" ? "" : "hidden ") + "logo-small thumb-20 animated infinite pulse zindex-2"}
														data-toggle="tooltip"
													/>
													<img
														src={require('assets/img/pw_str/strong.png')}
														className={(this.state.passwordStr == "strong" ? "" : "hidden ") + "logo-small thumb-20 animated infinite duration-5 tada-with-delay zindex-2"}
														data-toggle="tooltip"
													/>
													<img
														src={require('assets/img/pw_str/super_strong.png')}
														className={(this.state.passwordStr == "over powered" ? "" : "hidden ") + "logo-small thumb-25 animated infinite duration-5 tada-with-delay z-index-2"}
														data-toggle="tooltip"
													/>
												</div>
											</CTooltip>
										</div>
									</div>
									<div className={(this.state.account.password.length > 5 ? 'hidden' : '') + " text-small text-right text-warning"}>
										Password must be atleast 6 characters long.
									</div>
									<div className="form-group margin-top-15">
										<TextInput
											name="first_name"
											label="First name"
											value={this.state.account.first_name}
											onChange={this.handleInputState}
											type="text"
										/>
									</div>
									<div className="form-group margin-top-15">
										<TextInput
											name="middle_name"
											label="Middle name"
											value={this.state.account.middle_name}
											onChange={this.handleInputState}
											type="text"
										/>
									</div>
									<div className="form-group margin-top-15">
										<TextInput
											name="last_name"
											label="Last name"
											value={this.state.account.last_name}
											onChange={this.handleInputState}
											type="text"
										/>
									</div>
								</div>
							</div>
							{
								this.state.error ? 
								(
									<CTooltip title={this.state.error}>
										<div className="form-group text-center margin-top-20">
											<button
												type="button"
												className={(this.state.error || this.state.saving ? "disabled" : "") + " btn btn-success btn-block submit-btn"}
												onClick={this.submitRegistration}
											>
												<span className={this.state.saving ? 'hidden' : ''}>Submit</span>
												<i className={(!this.state.saving ? 'hidden' : '') + " fas fa-spinner fa-spin"}></i>
											</button>
										</div>
									</CTooltip>
								) : (
									<div className="form-group text-center margin-top-20">
										<button
											type="button"
											className={(this.state.error || this.state.saving ? "disabled" : "") + " btn btn-success btn-block submit-btn"}
											onClick={this.submitRegistration}
										>
											<span className={this.state.saving ? 'hidden' : ''}>Submit</span>
											<i className={(!this.state.saving ? 'hidden' : '') + " fas fa-spinner fa-spin"}></i>
										</button>
									</div>
								)
							}
							
						</div>
						<div className={(!this.state.formState ? "scale-out " : "") + " transitioned absolute full-height full-width left-0 top-0 flex flex-align-center"}>
							<div className="flex-1 padded-20">
								<div className="text-center margin-bottom-10">
									<i className="fas fa-check-circle text-jumbo text-success animated tada-with-delay duration-5 infinite"></i>
								</div>
								<div className="text-center text-h1">
									Registration Successful
								</div>
								<div className="text-center padded-all pad-top-10">
									Congratulations, your <span className="text-primary">{this.state.account.type}</span> account was successfully registered. You can now log in to your account.
								</div>
								<div className="text-center margin-top-20">
									<button
										type="button"
										className="btn btn-success submit-btn text-small"
										onClick={this.toggle}
									>
										Continue
									</button>
								</div>
							</div>
						</div>
					</div>
					<div
						className="absolute upper-left text-large hover-scale hover-transitioned"
						onClick={this.toggle}
						role="button"
					>
						<i className="fas fa-arrow-left text-large"></i>
					</div>
				</div>
			</div>
		);
	}
}


Registration.propTypes = {
	isOpen: PropTypes.string,
	toggle: PropTypes.func,
	actions: PropTypes.object.isRequired
};

// function mapStateToProps(state, ownProps) {
// 	return {
// 		user: state.user
// 	};
// }

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(registrationActions, dispatch)
	};
}

export default connect(null, mapDispatchToProps)(Registration);