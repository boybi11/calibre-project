import React, {Component, PropTypes} from 'react';
import {connect} from 'react-redux';
import moment from 'moment';
import {bindActionCreators} from 'redux';
import { browserHistory } from 'react-router'
import * as leagueActions from './league.actions';
import CTooltip from '../_global/CTooltip';
import TaskForm from '../tasks/components/TaskForm';
import TaskView from '../tasks/components/TaskView';
import Loader from '../_global/Loader';
import * as textHelper from '../../helpers/text_helpers';


class LeagueView extends Component {
	constructor(props) {
		super (props);

		this.state = {
			league: {},
			showForm: false,
			showView: false,
			formMode: 'add',
			sort: '',
			filter: '',
			data: {
				title: "",
				description: "",
				duration: "",
				exp: "",
				points: "",
				badge_reward: "",
				badge_leader: ""
				
			},
			tab: 'tasks',
			loading: true,
			selectedTask: {}
		};

		this.textChangeHandle = this.textChangeHandle.bind(this);
		this.submitForm = this.submitForm.bind(this);
		this.toggleForm = this.toggleForm.bind(this);
		this.toggleView = this.toggleView.bind(this);
		this.acceptUser = this.acceptUser.bind(this);
		this.complete = this.complete.bind(this);
		this.handleUserScore = this.handleUserScore.bind(this);
		this.selectBadge = this.selectBadge.bind(this);
		this.processPlayerScore = this.processPlayerScore.bind(this);
		this.finishTask = this.finishTask.bind(this);
		this.toggleTab = this.toggleTab.bind(this);
	}

	componentDidMount() {
		this.props.actions.getTasks(this.props.params.slug).then((res) => {
			this.setState({loading: false, league: res.data});
		});
	}

	toggleTab(tab) {
		this.setState({tab});
		this.props.actions.getTasks(this.props.params.slug).then((res) => {
			this.setState({loading: false, league: res.data});
		});
	}

	submitForm() {
		let data = Object.assign({}, this.state.data);

		let validation = Object.keys(data).filter(key => {
			return data[key] == "";
		});
		
		if(validation.length > 0) {
			alert("Fill in all the form fields");
		} else {
			this.setState({loading: true});
			data['league_id'] = this.state.league.id;
			this.props.actions.addTask(data).then(res => {
				this.props.actions.getTasks(this.props.params.slug).then((res) => {

					this.setState({
						loading: false,
						league: res.data
					});
				});
			});

			this.toggleForm(false);
		}
	}

	textChangeHandle(e) {
		let data = Object.assign({}, this.state.data);

		data[e.target.name] = e.target.value;
		this.setState({ data });
	}

	selectBadge(type, badge) {
		let data = Object.assign({}, this.state.data);

		data[type] = badge;
		this.setState({ data });
	}

	toggleForm(state, mode) {
		this.setState({
			showForm: state,
			formMode: mode == undefined ? '' : mode,
			data: {
				title: "",
				description: "",
				duration: "",
				exp: "",
				points: "",
				badge_leader: "",
				badge_reward: ""
			}
		});
	}

	toggleView(state, task) {
		this.setState({loading: true});
		if(task != undefined) {
			this.props.actions.getTask(task.id).then(res => {
				let players = res.data.league.players;
	
				res.data.users.map(user => {
					let find = players.find(player => {
						return player.id == user.id;
					});
	
					if(find) {
						find.task_status = user.pivot.status;
						find.score = user.pivot.score;
					}
				});
	
				res.data.users = players;
				
				this.setState({
					showView: state,
					selectedTask: this.processTask(res.data),
					loading: false
				});
			});
		} else {
			this.setState({
				showView: false,
				loading: false
			});
		}
	}

	acceptUser(user) {
		let league = Object.assign({}, this.state.league);
		let find = league.players.find(player => {
			return player.id == user.id;
		});

		if(find) {
			find.loading = true;
		}

		this.setState({league});
		this.props.actions.acceptUser({player: user.id, league: league.id}).then(res => {
			find = league.players.find(player => {
				return player.id == user.id;
			});
	
			if(find) {
				find.pivot.status = res.data.pivot.status;
				find.loading = false;
			}
	
			this.setState({league});
		});
	}

	processTask(task) {
		const endDate = moment(moment(task.created_at).format('YYYY-MM-DD 23:59:59')).add(task.duration, 'days');
		let find = false;
		if(endDate.isBefore(moment())) {
			task.onGoing = false;
		} else {
			task.onGoing = true;
		}

		if(this.props.user.front_user_type == 'student') {
			find = task.users.find(user => {
				return user.id == this.props.user.id;
			});	
		}

		if(find) {
			task.currentUserState = find;
		}

		return task;
	}

	changeSelect(e, type) {
		if(type == 'filter') {
			this.setState({filter: e.target.value});
		} else {
			this.setState({sort: e.target.value});
		}
	}

	alphaAZ(a,b) {
		if (a.title < b.title)
			return -1;
		if (a.title > b.title)
			return 1;
		return 0;
	}

	alphaZA(a,b) {
		if (a.title > b.title)
			return -1;
		if (a.title < b.title)
			return 1;
		return 0;
	}

	edASC(a,b) {
		const endDateA = moment(moment(a.created_at).format('YYYY-MM-DD 23:59:59')).add(a.duration, 'days');
		const endDateB = moment(moment(b.created_at).format('YYYY-MM-DD 23:59:59')).add(b.duration, 'days');
		if (endDateA.isSameOrAfter(endDateB))
			return 1;
		if (endDateA.isSameOrBefore(endDateB))
			return -1;
		return 0;
	}

	edDSC(a,b) {
		const endDateA = moment(moment(a.created_at).format('YYYY-MM-DD 23:59:59')).add(a.duration, 'days');
		const endDateB = moment(moment(b.created_at).format('YYYY-MM-DD 23:59:59')).add(b.duration, 'days');
		if (endDateA.isSameOrAfter(endDateB))
			return -1;
		if (endDateA.isSameOrBefore(endDateB))
			return 1;
		return 0;
	}

	expASC(a,b) {
		if (a.exp < b.exp)
			return -1;
		if (a.exp > b.exp)
			return 1;
		return 0;
	}

	expDSC(a,b) {
		if (a.exp > b.exp)
			return -1;
		if (a.exp < b.exp)
			return 1;
		return 0;
	}

	ptsASC(a,b) {
		if (a.points < b.points)
			return -1;
		if (a.points > b.points)
			return 1;
		return 0;
	}

	ptsDSC(a,b) {
		if (a.points > b.points)
			return -1;
		if (a.points < b.points)
			return 1;
		return 0;
	}

	processPlayerScore(player) {
		player.total_score = 0;
		
		if(player.tasks.length > 0) {
			player.tasks.map(task => {
				if(task.league.id == this.state.league.id) {
					player.total_score += parseFloat(task.points) * (parseFloat(task.pivot.score) / 100);
				}
			});
		}

		return player;
	}

	finishTask(task) {
		let league = Object.assign({}, this.state.league);

		const data = {
			teacher: this.props.user.id,
			task
		};

		let find = league.tasks.find(task_f => {
			return task == task_f.id;
		});
		
		if(find) {
			find.loading = true;
		}

		this.setState({league});
		this.props.actions.finishTask(data).then(res => {
			let find = league.tasks.find(task_f => {
				return task == task_f.id;
			});
			
			if(find) {
				find.loading = false;
				find.status = "completed";
			}
	
			this.setState({league});
		});
	}

	complete(task, score, player) {
		score = score != undefined ? score : 0;

		let league = Object.assign({}, this.state.league);
		let selectedTask = Object.assign({}, this.state.selectedTask);

		const data = {
			task: task.id,
			player: player == undefined ? this.props.user.id : player,
			status: this.props.user.front_user_type,
			score
		};

		let find = league.tasks.find(task_f => {
			return task.id == task_f.id;
		});
		
		if(find) {
			find.loading = true;
		}

		if(player != undefined) {
			let find_p = selectedTask.users.find(player_f => {
				return player == player_f.id;
			});
			
			if(find_p) {
				find_p.loading = true;
			}
		}

		this.setState({league, selectedTask});
		this.props.actions.completeTask(data).then(res => {
			let find = league.tasks.find(task_f => {
				return task.id == task_f.id;
			});
	
			if(find) {
				find.loading = false;
				find.currentUserState = Object.assign({}, this.props.user);
			}

			if(player != undefined) {
				let find_p = selectedTask.users.find(player_f => {
					return player == player_f.id;
				});
				
				if(find_p) {
					find_p.loading = false;
					find_p.task_status = data.status;
					find_p.score = data.score;
				}
			}

			this.setState({league});
		});
	}

	handleUserScore(e, user) {
		let score = e.target.value;
		let selectedTask = Object.assign({}, this.state.selectedTask);
		let find = selectedTask.users.find(search => {
			return search.id == user.id;
		});
		
		if(find) {
			if(isNaN(score)) {
				score = 0;
			} else {
				if(parseFloat(score) > 100) {
					score = 100;
				} else if(parseFloat(score) < 0) {
					score = 0;
				}
			}

			find.score = score;
		}

		this.setState({selectedTask});
	}

	render() {
		let league = Object.assign({}, this.state.league);
		if(league.tasks != undefined) {
			league.tasks.map(task => {
				task = this.processTask(task);
			});
		}

		if(this.state.filter) {
			if(this.state.filter == 'on-going') {
				league.tasks = league.tasks.filter(task => {
					return task.onGoing;
				});
			} else {
				league.tasks = league.tasks.filter(task => {
					return !task.onGoing;
				});
			}
		}

		if(this.state.sort) {
			switch(this.state.sort) {
				case 'az':
							league.tasks = league.tasks.sort(this.alphaAZ);
							break;
				case 'za':
							league.tasks = league.tasks.sort(this.alphaZA);
							break;
				case 'ed-asc':
							league.tasks = league.tasks.sort(this.edASC);
							break;
				case 'ed-dsc':
							league.tasks = league.tasks.sort(this.edDSC);
							break;
				case 'exp-asc':
							league.tasks = league.tasks.sort(this.expASC);
							break;
				case 'exp-dsc':
							league.tasks = league.tasks.sort(this.expDSC);
							break;
				case 'pts-asc':
							league.tasks = league.tasks.sort(this.ptsASC);
							break;
				case 'pts-dsc':
							league.tasks = league.tasks.sort(this.ptsDSC);
							break;
			}
		}

		
		if(league.players != undefined) {
			league.players.map(player => {
				player = this.processPlayerScore(player);
			});

			league.players = league.players.sort((a, b) => {
				a.total_score = a.total_score ? a.total_score : 0;
				b.total_score = b.total_score ? b.total_score : 0;
		
				if (parseFloat(a.total_score) > parseFloat(b.total_score))
					return -1;
				if (parseFloat(a.total_score) < parseFloat(b.total_score))
					return 1;
				return 0;
			});
		}
		return (
			<div className="leagues-page">
				<div className="tasks-board flex">
					<div className="tasks-list flex-1">
						<div className="flex flex-align-center">
							<div className="text-h1 flex-1 no-margin">{this.state.league.name} League</div>
						</div>
						<div className="default-tab">
							<div className="tab-headers flex align-center">
								<div
									className={`tab ${this.state.tab == 'tasks' ? 'active' : ''}`}
									onClick={() => this.toggleTab('tasks')}
								>
									Quests
								</div>
								<div
									className={`tab ${this.state.tab == 'users' ? 'active' : ''}`}
									onClick={() => this.toggleTab('users')}
								>
									Players
								</div>
							</div>
							<div className="tab-panel">
								<div className={`tab-pane ${this.state.tab == 'tasks' ? 'active' : ''}`}>
									<div className="flex flex-align-center">
										<div className="flex-1 flex flex-align-center">
											<div className="flex flex-align-center">
												<div>
													Status
												</div>
												<div className="margin-left">
													<select
														className="form-control"
														onChange={(e) => this.changeSelect(e, 'filter')}
														value={this.state.filter}
													>
														<option value="">All</option>
														<option value="on-going">On-going</option>
														<option value="ended">Ended</option>
													</select>
												</div>
											</div>
											<div className="flex flex-align-center margin-left-20">
												<div>
													Sort
												</div>
												<div className="margin-left">
													<select
														className="form-control"
														onChange={(e) => this.changeSelect(e, 'sort')}
														value={this.state.sort}
													>
														<option value="">None</option>
														<option value="az">Alphabetically (A-Z)</option>
														<option value="za">Alphabetically (Z-A)</option>
														<option value="ed-asc">End date (nearest to furthest)</option>
														<option value="ed-dsc">End date (furthest to nearest)</option>
														<option value="exp-dsc">Exp (highest to lowest)</option>
														<option value="exp-asc">Exp (lowest to highest)</option>
														<option value="pts-dsc">Pts (highest to lowest)</option>
														<option value="pts-asc">Pts (lowest to highest)</option>
													</select>
												</div>
											</div>
										</div>
										<div className="text-right">
											{
												(this.props.user.front_user_type == "teacher") &&
												(
													<div className="task-actions">
														<CTooltip
															title="Add quest"
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
									</div>
									<div className="tasks-list flex">
										{
											Object.keys(this.state.league).length > 0 && this.state.league.tasks.length > 0 ? (
												league.tasks.map((task, index) => {
													return (
														<div className="wrap-1-3" style={{animationDelay: ((index + 1) * 0.2) + 's'}}>
															<div className="badge-container">
																<CTooltip
																	title="Badge Reward"
																	placement="top"
																>
																	{
																		task.badge_reward ? (
																			<img src={require(`assets/img/badges/${task.badge_reward}.png`)} />
																		) : (
																			<div className="empty-img" />
																		)
																	}
																</CTooltip>
																<CTooltip
																	title="Leaderboard Badge"
																	placement="top"
																>
																	{
																		task.badge_leader ? (
																			<img src={require(`assets/img/badges/${task.badge_leader}.png`)} />
																		) : (
																			<div className="empty-img" />
																		)
																	}
																</CTooltip>
															</div>
															<div className="card flex flex-direction-column" key={task.id}>
																<div className="bg-icon">
																	<i className="fas fa-tasks"></i>
																</div>
																{
																	task.loading && (
																		<div className="loader">
																			<i className="fas fa-circle-notch fa-spin"	style={{fontSize: "20px"}}/>
																		</div>
																	)
																}
																<div className="flex flex-direction-column flex-1">
																	<div className="flex flex-1">
																		<div className="flex-1 flex flex-direction-column">
																			<div className="league-name">
																				{task.title ? task.title : 'No title'}
																			</div>
																			{
																				(this.props.user.front_user_type !== "teacher") && (
																					<div className="gm-name text-primary">
																						{this.state.league.user.first_name + " " + this.state.league.user.last_name}
																					</div>
																				)
																			}
																			<div className="gm-date text-disable">
																				{moment(task.created_at).format('MMM D, Y') + ' - ' + moment(task.created_at).add(task.duration, 'days').format('MMM D, Y')}
																			</div>
																			<div>
																				<div className={`label bg-${task.status == 'completed' ? 'success' : (task.onGoing ? (task.currentUserState ? 'success' : 'primary') : 'danger')}`}>
																					{task.status == 'completed' ? 'finished' : (task.onGoing ? (task.currentUserState ? 'completed' : 'on-going') : 'ended')}
																				</div>
																			</div>
																			<div className="description margin-top-10 flex-1">
																				{textHelper.moreChar(task.description)}
																			</div>
																			<div className="flex flex-align-center margin-top-20">
																				<CTooltip
																					title="Exp reward"
																					placement="top"
																				>
																					<div className="badge bg-success margin-right">
																						{`EXP ${task.exp}`}
																					</div>
																				</CTooltip>
					
																				<CTooltip
																					title="Points reward"
																					placement="top"
																				>
																					<div className="badge bg-warning">
																						{`PTS ${task.points}`}
																					</div>
																				</CTooltip>
																			</div>
																		</div>
																		<div className="task-actions">
																			<div
																				className="btn-xs bg-primary hover-opacity transitioned text-center margin-bottom"
																				role="button"
																				onClick={() => this.toggleView('in', task)}
																			>
																				View
																			</div>
																			{
																				(this.props.user.front_user_type == "teacher" && task.status != 'completed') &&
																				(
																					<div
																						className="btn-xs bg-success text-center hover-opacity transitioned margin-bottom"
																						role="button"
																						onClick={() => this.finishTask(task.id)}
																					>
																						Finish
																					</div>
																				)
																			}
																			{
																				(this.props.user.front_user_type == "teacher") &&
																				(
																					<div
																						className="btn-xs bg-danger text-center hover-opacity transitioned"
																						role="button"
																						onClick={() => this.archive(task.id)}
																					>
																						Archive
																					</div>
																				)
																			}
																			{
																				(this.props.user.front_user_type == "student" && task.onGoing && task.status != 'complete') &&
																				(
																					<div
																						className={`btn-xs bg-success hover-opacity transitioned ${(task.onGoing) && (task.currentUserState) && 'shrink'}`}
																						role="button"
																						onClick={() => this.complete(task)}
																					>
																						Complete
																					</div>
																				)
																			}
																		</div>
																	</div>
																</div>
															</div>
														</div>
													);
												})
											) : (
												!this.state.loading && (
													<div className="empty-message" onClick={this.toggleForm}>
														There are no quests found for this league.
													</div>
												)
											)
										}
									</div>
								</div>
								<div className={`tab-pane ${this.state.tab == 'users' ? 'active' : ''}`}>
									{
										Object.keys(this.state.league).length > 0 && this.state.league.players.length > 0 ? (
											league.players.map((player, index) => {
												return (
													<div>
														<div className={"task-status bg-success"}>
															{player.total_score}
														</div>
														<div className="player-card flex flex-align-center margin-none" style={{animationDelay: (0.2 * (index + 1)) + 's'}}>
															<div className="rank-number">
																{index + 1}
															</div>
															<div className="bg-icon">
																<i className="fas fa-user-astronaut"/>
															</div>
															<div className="dp">
																<img src={require('assets/img/log.jpg')} />
															</div>
															<div className="fullname margin-left-20 flex-1">
																<div className="player-name">
																	{player.first_name + " " + player.last_name}
																</div>
																<div className="player-email">
																	{player.email}
																</div>
																<div className={`label bg-${player.pivot.status == "pending" ? "warning" : "primary"}`}>
																	{player.pivot.status == 'accepted' ? 'active' : player.pivot.status}
																</div>
																<div className="player-email margin-top-20">
																	<div>
																		Last logged in:
																	</div>
																	{moment(player.last_login).format('LLL')}
																</div>
															</div>
															{
																player.loading != undefined && player.loading ? (
																	<div>
																		<i className="fas fa-circle-notch fa-spin"	style={{fontSize: "20px"}}/>
																	</div>
																) : (
																	this.props.user.front_user_type == 'teacher' && (
																		<div className={`player-actions ${player.pivot.status}`}>
																			<div>
																				{
																					
																					player.pivot.status == 'pending' && (
																						<button
																							className="btn btn-sm btn-success"
																							onClick={() => this.acceptUser(player)}
																						>
																							Accept
																						</button>
																					)
																				}
																				<button
																					className="btn btn-sm btn-danger margin-left-10"
																					onClick={() => this.removeUser(player)}
																				>
																					{player.pivot.status == 'pending' ? 'Reject' : 'Kick'}
																				</button>
																			</div>
																		</div>	
																	)
																)
															}
														</div>
													</div>
												)
											})
										) : (
											<div className="empty-message" onClick={this.toggleForm}>
												There are no players found for this league.
											</div>
										)
									}
								</div>
							</div>
						</div>
					</div>
				</div>
				<TaskForm
					submitForm={this.submitForm}
					toggleForm={this.toggleForm}
					formMode={this.state.formMode}
					show={this.state.showForm}
					textChangeHandle={this.textChangeHandle}
					data={this.state.data}
					selectBadge={this.selectBadge}
				/>
				<TaskView
					submitForm={this.submitForm}
					toggleView={this.toggleView}
					formMode={this.state.formMode}
					show={this.state.showView}
					textChangeHandle={this.handleUserScore}
					task={this.state.selectedTask}
					fe_type={this.props.user.front_user_type}
					complete={this.complete}
					user={this.props.user.id}
				/>
				<Loader loading={this.state.loading} />
			</div>
		);
	}
}

LeagueView.propTypes = {
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

export default connect(mapStateToProps, mapDispatchToProps)(LeagueView);