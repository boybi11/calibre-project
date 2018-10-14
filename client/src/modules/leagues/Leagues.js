import React, {Component, PropTypes} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as leagueActions from './league.actions';
import CTooltip from '../_global/CTooltip';
import Loader from '../_global/Loader';
import LeagueForm from '../leagues/League_form';

class Leagues extends Component {
	constructor(props) {
		super (props);

		this.state = {
			tasks: [1,2,3,4,5],
			showForm: false,
			formMode: 'add',
			data: {name: ""},
			loading: true
		};

		this.submitForm = this.submitForm.bind(this);
		this.toggleForm = this.toggleForm.bind(this);
		this.deleteTask = this.deleteTask.bind(this);
		this.textChangeHandle = this.textChangeHandle.bind(this);
		this.archive = this.archive.bind(this);
	}

	componentDidMount() {
		this.props.actions.getList(this.props.user.id).then((res) => {
			this.setState({loading: false});
		});
	}

	submitForm() {
		this.setState({loading: true});
		let data = Object.assign({}, this.state.data);
		data['gm_id'] = this.props.user.id;
		this.props.actions.create(data).then(res => {
			this.props.actions.getList(this.props.user.id).then((res) => {
				this.setState({loading: false});
			});
		});

		this.toggleForm(false);
	}

	archive(id) {
		const data = {
			ids: [id]
		};
		this.setState({loading: true});
		this.props.actions.archive(data).then(res => {
			this.props.actions.getList(this.props.user.id).then((res) => {
				this.setState({loading: false});
			});
		});

		this.toggleForm(false);
	}

	textChangeHandle(e) {
		let data = Object.assign({}, this.state.data);

		data[e.target.name] = e.target.value;
		this.setState({ data });
	}

	toggleForm(state, mode) {
		this.setState({
			showForm: state,
			formMode: mode == undefined ? '' : mode,
			data: {name: ""}
		});
	}

	deleteTask(id) {
		let tasks = this.state.tasks.splice(0);

		tasks.splice(tasks.indexOf(id), 1);

		this.setState({tasks});
	}

	render() {
		return (
			<div className="leagues-page">
				<div className="tasks-board flex">
					<div className="tasks-list flex-1">
						<div className="flex flex-align-center">
							<div className="text-h1 flex-1 no-margin">Leagues</div>
							{
								(this.props.user.front_user_type == "teacher") &&
								(
									<div className="task-actions">
										<CTooltip
											title="Add League"
											placement="top"
										>
											<div
												className="btn btn-sm btn-success"
												role="button"
												onClick={() => {this.toggleForm(true, 'add')}}
											>
												<i className="fas fa-plus" role="button"></i> Create
											</div>
										</CTooltip>
									</div>
								)
							}
						</div>
						<div className="league-list flex">
							{
								this.props.leagues.map((league, index) => {
									return (
										<div className="wrap-1-3">
											<div className="card" key={league.id}>
												<div className="flex">
													<div className="flex-1">
														<div className="league-name">
															<i className="margin-right fas fa-book"></i> {league.name}
														</div>
														{
															(this.props.user.front_user_type !== "teacher") && (
																<div className="gm-name text-primary">
																	{league.user.first_name + " " + league.user.last_name}
																</div>
															)
														}
														<div className="flex flex-align-center margin-top-20">
															<CTooltip
																title="Active Quest"
																placement="top"
															>
																<div className="badge bg-success margin-right">
																	<i className="fas fa-star margin-right"></i> 10
																</div>
															</CTooltip>

															<CTooltip
																title="Players"
																placement="top"
															>
																<div className="badge bg-warning">
																	<i className="fas fa-user margin-right"></i> 40
																</div>
															</CTooltip>
														</div>
													</div>
													<div className="task-actions">
														{
															(this.props.user.front_user_type == "teacher") &&
															(
																<div
																	className="btn-xs bg-danger hover-opacity transitioned"
																	role="button"
																	onClick={() => this.archive(league.id)}
																>
																	<i className="fas fa-archive" role="button"></i> Archive
																</div>
															)
														}
													</div>
												</div>
											</div>
										</div>
									);
								})
							}
						</div>
					</div>
				</div>
				<LeagueForm
					submitForm={this.submitForm}
					toggleForm={this.toggleForm}
					formMode={this.state.formMode}
					show={this.state.showForm}
					textChangeHandle={this.textChangeHandle}
					data={this.state.data}
				/>
				<Loader loading={this.state.loading} />
			</div>
		);
	}
}

Leagues.propTypes = {
	user: React.PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		user: state.user,
		leagues: state.leagues
	};
}


function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(leagueActions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(Leagues);