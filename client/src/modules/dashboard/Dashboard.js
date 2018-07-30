import React from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as dashboardActions from './dashboard.actions';
import * as sessionHelper from '../_global/SessionHelper';
import CTooltip from '../_global/CTooltip';
import {Link} from 'react-router';

class Dashboard extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.state = {
			user : sessionHelper.getUser(),
			tasks: [1,2,3,4,5]
		};
	}

	render() {
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
							{
								this.state.tasks.map(function(task) {
									return(
										<div key={task} className="task-card padded-20">
											<div className="text-right margin-bottom-20">
												Quest ID: #123456{task}
											</div>
											<div className="text-xlarge margin-bottom">
												Super mega task
											</div>
											<div className="margin-bottom-10 faded-light">
												Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
											</div>
											<div className="margin-bottom-10">
												Quest giver: <span className="text-warning">Teacher Zernie</span>
											</div>
											<div className="margin-bottom-10">
												Quest difficulty: <span className="text-error">Hard</span>
											</div>
											<div className="margin-bottom-10">
												Remaining Time: 3 days
											</div>
											<div className="text-right">
												150 exp
											</div>
											<div className="text-right margin-top-10">
												<div className="inline-block">
													<CTooltip
														title="Finish Task"
														placement="bottom"
													>
														<div
															className="icon icon-circular icon-large text-large bg-success hover-scale transitioned"
															role="button"
														>
															<i className="ion-checkmark"></i>
														</div>
													</CTooltip>
												</div>
											</div>
										</div>	
									);
								})
							}
						</div>
					</div>
					<div className="activity-panel margin-top-30">
						<div className="text-h1">
							Failed Quests
						</div>
						<div className="tasks-container flex flex-wrap">
							{
								this.state.tasks.map(function(task) {
									return(
										<div key={task} className="task-card padded-20">
											<div className="text-right margin-bottom-20">
												Quest ID: #123456{task}
											</div>
											<div className="text-xlarge margin-bottom">
												Super mega task
											</div>
											<div className="margin-bottom-10 faded-light">
												Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
											</div>
											<div className="margin-bottom-10">
												Quest giver: Teacher Zernie
											</div>
											<div className="text-right">
												150 exp
											</div>
										</div>	
									);
								})
							}
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


export default connect(mapStateToProps, null)(Dashboard);