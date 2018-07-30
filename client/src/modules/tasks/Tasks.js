import React, {Component, PropTypes} from 'react';
import {connect} from 'react-redux';
import CTooltip from '../_global/CTooltip';
import TaskForm from './components/TaskForm';

class Tasks extends Component {
	constructor(props) {
		super (props);

		this.state = {
			tasks: [1,2,3,4,5],
			showForm: false,
			formMode: 'add'
		};

		this.submitForm = this.submitForm.bind(this);
		this.toggleForm = this.toggleForm.bind(this);
		this.deleteTask = this.deleteTask.bind(this);
	}

	submitForm() {
		this.toggleForm(false);
	}

	toggleForm(state, mode) {
		this.setState({
			showForm: state,
			formMode: mode == undefined ? '' : mode
		});
	}

	deleteTask(id) {
		let tasks = this.state.tasks.splice(0);

		tasks.splice(tasks.indexOf(id), 1);

		this.setState({tasks});
	}

	render() {
		return (
			<div className="tasks-page">
				<div className="tasks-board flex">
					<div className="filter">
						<div className="clan-filter">
							<div className="clan-holder">
								<div className="text-h2">Clan</div>
								<div className="clan-card">
									<i className="far fa-dot-circle"></i> All
								</div>
								<div className="clan-card">
									<i className="far fa-circle"></i> Clan 1
								</div>
								<div className="clan-card">
									<i className="far fa-circle"></i> Clan 2
								</div>
								<div className="clan-card">
									<i className="far fa-circle"></i> Clan 3
								</div>
							</div>
						</div>
					</div>
					<div className="tasks-list flex-1">
						<div className="flex flex-align-center">
							<div className="text-h2 flex-1 no-margin">Quests</div>
							{
								(this.props.user.front_user_type == "teacher") &&
								(
									<div className="task-actions">
										<CTooltip
											title="Add Task"
											placement="top"
										>
											<div
												className="icon icon-circular icon-large text-large bg-success hover-scale transitioned margin-right-10"
												role="button"
												onClick={() => {this.toggleForm(true, 'add')}}
											>
												<i className="fas fa-plus" role="button"></i>
											</div>
										</CTooltip>
									</div>
								)
							}
						</div>
						<div className="tasks">
							{
								this.state.tasks.map((task) => {
									return (
										<div className="task-card transitioned hover-scale-min" key={task}>
											<div className="flex flex-align-center">
												<div className="flex-1">
													<div className="task-id">
														ID #123456
													</div>
													<div className="task-name">
														Task name
													</div>
													<div className="task-duration margin-top-10">
														Jul 08, 2018 to Jul 12, 2018
													</div>
												</div>
												<div className="task-actions">
													<CTooltip
														title="Finish"
														placement="top"
													>
														<div
															className="icon icon-circular icon-large text-medium bg-primary hover-scale transitioned margin-right-10"
															role="button"
														>
															<i className="fas fa-star" role="button"></i>
														</div>
													</CTooltip>
													{
														(this.props.user.front_user_type == "teacher") &&
														(
															<div className="inline-block">
																<CTooltip
																	title="Edit"
																	placement="top"
																>
																	<div
																		className="icon icon-circular icon-large text-medium bg-success hover-scale transitioned margin-right-10"
																		role="button"
																		onClick={() => this.toggleForm(true, 'edit')}
																	>
																		<i className="fas fa-edit" role="button"></i>
																	</div>
																</CTooltip>

																<CTooltip
																	title="Remove"
																	placement="top"
																>
																	<div
																		className="icon icon-circular icon-large text-medium bg-danger hover-scale transitioned margin-right-10"
																		role="button"
																		onClick={() => this.deleteTask(task)}
																	>
																		<i className="fas fa-trash" role="button"></i>
																	</div>
																</CTooltip>
															</div>
														)
													}
													{
														(this.props.user.front_user_type == "student") &&
														(
															<div className="inline-block">
																<CTooltip
																	title="Read Quest"
																	placement="top"
																>
																	<div
																		className="icon icon-circular icon-large text-medium bg-warning hover-scale transitioned margin-right-10"
																		role="button"
																	>
																		<i className="fas fa-book" role="button"></i>
																	</div>
																</CTooltip>
															</div>
														)
													}
												</div>
											</div>
										</div>
									);
								})
							}
						</div>
					</div>
				</div>
				{
					this.state.showForm && (
						<TaskForm
							submitForm={this.submitForm}
							toggleForm={this.toggleForm}
							formMode={this.state.formMode}
						/>
					)
				}
			</div>
		);
	}
}

Tasks.propTypes = {
	user: React.PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		user: state.user
	};
}

export default connect(mapStateToProps, null)(Tasks);