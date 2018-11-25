import React from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as actions from '../leagues/league.actions';
import * as sessionHelper from '../_global/SessionHelper';
import * as textHelper from '../../helpers/text_helpers';
import CTooltip from '../_global/CTooltip';
import moment from 'moment';
import {Link} from 'react-router';

class Dashboard extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.state = {
			user : sessionHelper.getUser(),
			tasks: []
		};
	}

	componentWillMount() {
		if(this.props.user.front_user_type == 'student') {
			this.props.actions.getLeagues(this.props.user.id).then(res => {
				// console.log(res);
				if(res.data != undefined) {
					let tasks = [];
					res.data.map(league => {
						league.tasks.map(task => {
							task.gm = league.user.name;
						});

						tasks = tasks.concat(league.tasks);
					});
					// console.log(tasks);
					this.setState({tasks});
				}
			});
		} else {
			let tasks = [];
			this.props.actions.getList(this.props.user.id).then(res => {
				if(res.data != undefined) {
					res.data.map(league => {
						league.tasks.map(task => {
							task.gm = league.user.name;
						});

						tasks = tasks.concat(league.tasks);
						// console.log(tasks);
					});
					// console.log(tasks);
					this.setState({tasks});
				}
			});
		}
	}

	edASC(a,b) {
		const endDateA = moment(moment(a.created_at).format('YYYY-MM-DD 23:59:59'));
		const endDateB = moment(moment(b.created_at).format('YYYY-MM-DD 23:59:59'));
		if (endDateA.isSameOrAfter(endDateB))
			return 1;
		if (endDateA.isSameOrBefore(endDateB))
			return -1;
		return 0;
	}

	processLeagueTasks(data) {
		let prcs = {
			latest: data.sort(this.edASC).slice(0, 5),
			failed: data
		};

		return prcs;
	}

	render() {
		const tasks = this.processLeagueTasks(this.state.tasks.slice(0));
		return (
			<div id="dashboard">
				<div className="dashboard-activity-center pad-top-20 padded-50">
					<div clasName="search-panel margin-bottom-20">
						<input type="text" className="form-control text-xlarge padded-20" placeholder="Type your search here..."/>
					</div>
					<div className="activity-panel pad-top-20">
						<div className="text-h1">
							New Quests
						</div>
						<div className="tasks-container flex flex-wrap">
							<div className="tasks-list flex">
								{
									tasks.latest.length > 0 ? (
										tasks.latest.map((task, index) => {
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
																				{task.gm}
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
					</div>
					<div className="activity-panel margin-top-30">
						<div className="text-h1">
							Failed Quests
						</div>
						<div className="tasks-container flex flex-wrap">
							<div className="tasks-list flex">
								{
									tasks.failed.length > 0 ? (
										tasks.failed.map((task, index) => {
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
																				{task.gm}
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
					</div>
				</div>
			</div>
		);
	}
}

Dashboard.propTypes = {
	user: React.PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		user: state.user
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}


export default connect(mapStateToProps, mapDispatchToProps)(Dashboard);