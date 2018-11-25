import React, {Component, PropTypes} from 'react';
import {connect} from 'react-redux';
import moment from 'moment';
import {bindActionCreators} from 'redux';
import { browserHistory } from 'react-router'
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
		if(this.props.user.front_user_type == 'teacher') {
			this.props.actions.getList(this.props.user.id).then((res) => {
				this.setState({loading: false});
			});
		} else {
			this.props.actions.getLeagues(this.props.user.id).then((res) => {
				this.setState({loading: false});
			});
		}
		
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

	join(id) {
		const data = {
			league: id,
			player: this.props.user.id
		}
		this.props.actions.join(data).then(res => {
			console.log(res);
		});
	}

	deleteTask(id) {
		let tasks = this.state.tasks.splice(0);

		tasks.splice(tasks.indexOf(id), 1);

		this.setState({tasks});
	}

	searchLeague(e) {
		const searchKey = e.target.value;
		const player = this.props.user.front_user_type == 'student' ? this.props.user.id : 0;
		const gm = this.props.user.front_user_type == 'teacher' ? this.props.user.id : 0;
		this.props.actions.findList(searchKey, player, gm).then((res) => {
			this.setState({loading: false});
		});
	}

	processLeague(league) {
		let find = league.players.find(player => {
				return this.props.user.id == player.id;
		});
		
		if(find) {
			league.isJoined = true;
			league.membership = find.pivot.status;
		} else {
			league.isJoined = false;
		}

		return league;
	}

	render() {
		let leagues = this.props.leagues.slice(0);
		if(this.props.user.front_user_type == 'student') {
			leagues.map(league => {
				league = Object.assign({}, this.processLeague(league));
			});
		}

		console.log(leagues);
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
							{
								(this.props.user.front_user_type == "student") &&
								(
									<div className="task-actions">
										<input
											className="form-control search-control"
											placeholder="Search keyword"
											onChange={e => this.searchLeague(e)}
										/>
									</div>
								)
							}
						</div>
						<div className="league-list flex">
							{
								leagues.map((league, index) => {
									return (
										<div className="wrap-1-3" style={{animationDelay: ((index + 1) * 0.2) + 's'}}>
											<div className="card" key={league.id}>
												<div className="bg-icon">
													<i className="fab fa-galactic-republic"></i>
												</div>
												<div className="flex">
													<div className="flex-1">
														<div className="league-name">
															 {league.name}
														</div>
														{
															(this.props.user.front_user_type !== "teacher") && (
																<div className="gm-name">
																	<div className="sm-label">
																		Quest Giver:
																	</div>
																	<div className="text-warning">
																		{league.user.first_name + " " + league.user.last_name}
																	</div>
																</div>
															)
														}
														<div className="gm-name text-disable margin-top-10">
															<div className="sm-label">
																Created at:
															</div>
															{moment(league.created_at).format('LLL')}
														</div>
														{
															this.props.user.front_user_type == 'student' && (
																<div className="gm-name text-disable margin-top-10">
																	<div className="sm-label">
																		Membership:
																	</div>
																	{league.isJoined ? (league.membership == 'accepted' ? 'Active Member' : 'Pending Membership') : 'Non-member'}
																</div>
															)
														}
														<div className="flex flex-align-center margin-top-20 status-part">
															<CTooltip
																title="Active Quest"
																placement="top"
															>
																<div className="badge bg-success margin-right">
																	<i className="fas fa-tasks margin-right"></i> {league.tasks.length}
																</div>
															</CTooltip>

															<CTooltip
																title="Players"
																placement="top"
															>
																<div className="badge bg-warning">
																	<i className="fas fa-user margin-right"></i> {league.players.length}
																</div>
															</CTooltip>
														</div>
													</div>
													<div className="task-actions">
														<div
															className="btn-xs bg-primary hover-opacity transitioned text-center margin-bottom"
															role="button"
															onClick={() => browserHistory.replace({pathname: '/league/' + league.slug})}
														>
															View
														</div>
														{
															(this.props.user.front_user_type == "teacher") &&
															(
																<div
																	className="btn-xs bg-danger hover-opacity transitioned"
																	role="button"
																	onClick={() => this.archive(league.id)}
																>
																	Archive
																</div>
															)
														}
														{
															(this.props.user.front_user_type == "student") &&
															(
																<div>
																	{
																		!league.isJoined && (
																			<div
																				className="btn-xs bg-warning hover-opacity transitioned"
																				role="button"
																				onClick={() => this.join(league.id)}
																			>
																				Join
																			</div>
																		)
																	}
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