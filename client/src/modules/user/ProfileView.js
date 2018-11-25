import React, {Component, PropTypes} from 'react';
import {connect} from 'react-redux';
import moment from 'moment';
import * as actions from '../leagues/league.actions';
import {bindActionCreators} from 'redux';
import CTooltip from '../_global/CTooltip';
import Loader from '../_global/Loader';


class ProfileView extends Component {
	constructor(props) {
		super (props);

		this.state = {
			loading: true,
			user: Object.assign({}, this.props.user),
			leagues: []
		};
	}
	
	componentWillMount() {
		if(this.props.user.front_user_type == 'student') {
			this.props.actions.getLeagues(this.props.user.id).then(res => {
				// console.log(res);
				if(res.data != undefined) {
					this.setState({leagues: res.data});
				}
			});
		} else {
			let tasks = [];
			this.props.actions.getList(this.props.user.id).then(res => {
				if(res.data != undefined) {
					this.setState({leagues: res.data});
				}
			});
		}
	}

	processData(data) {
		let prcs = {
			league_count: data.length,
			quest_count: 0,
			completed_quest: 0,
			failed_quest: 0,
			success_rate: 0,
			failing_rate: 0,
			points: 0,
			exp: 0,
			badges: 0
		};

		if(data.length > 0) {
			data.map(league => {
				prcs.quest_count += league.tasks.length;

				league.tasks.map(task => {
					task.users.map(user => {
						if(this.props.user.front_user_type == 'student') {
							if(user.id == this.props.user.id) {
								if(user.pivot.status == 'teacher') {
									if(parseFloat(user.pivot.score) > 0) {
										prcs.completed_quest++;
										prcs.points += parseFloat(user.pivot.score);
									} else {
										prcs.failed_quest++;
									}
								}
							}	
						} else {
							if(user.pivot.status == 'teacher') {
								if(parseFloat(user.pivot.score) > 0) {
									prcs.completed_quest++;
									prcs.points += parseFloat(user.pivot.score);
								} else {
									prcs.failed_quest++;
								}
							}
						}
					});
				});
			});
		}

		prcs.success_rate = ((prcs.completed_quest / prcs.quest_count) * 100);
		prcs.failing_rate = ((prcs.failed_quest / prcs.quest_count) * 100);

		return prcs;
	}

    render() {
		const data = this.processData(this.state.leagues);

        return(
            <div className="profile-container">
                <div className="user-dp">
					<img
						src={require('assets/img/log.jpg')}
					/>
					<div className="username">
						{this.state.user.first_name + (this.state.user.middle_name ? (' ' + this.state.user.middle_name) : '') + ' ' + this.state.user.last_name}
					</div>
					<div className="username">
						{this.state.user.email}
					</div>
					<div className="usertype">
						{this.state.user.front_user_type == 'student' ? 'Player' : 'Game Master'}
					</div>
				</div>
				{/* <div className="flex">
					<div className="input-grp flex-1">
						<div className="input-lbl">
							First Name
						</div>
						<input className="form-control" value={this.state.user.first_name}/>
					</div>
					<div className="input-grp flex-1 margin-left-10 margin-right-10">
						<div className="input-lbl">
							Middle Name
						</div>
						<input className="form-control" value={this.state.user.middle_name}/>
					</div>
					<div className="input-grp flex-1">
						<div className="input-lbl">
							Last Name
						</div>
						<input className="form-control" value={this.state.user.last_name}/>
					</div>
				</div> */}
				<div className="stats">
					<div className="header">
						Stats
					</div>
					<div className="stat-details">
						<div className="stat">
							<div>
								Leagues
							</div>
							<div>
								{data.league_count}
							</div>
						</div>
						<div className="stat">
							<div>
								Quests
							</div>
							<div>
								{data.quest_count}
							</div>
						</div>
						<div className="stat">
							<div>
								Completed Quest
							</div>
							<div>
								{data.completed_quest}
							</div>
						</div>
						<div className="stat">
							<div>
								Failed Quest
							</div>
							<div>
								{data.failed_quest}
							</div>
						</div>
						<div className="stat">
							<div>
								Success rate
							</div>
							<div>
								{data.success_rate.toFixed(2)}
							</div>
						</div>
						<div className="stat">
							<div>
								Failing rate
							</div>
							<div>
								{data.failing_rate.toFixed(2)}
							</div>
						</div>
						<div className="stat">
							<div>
								Points
							</div>
							<div>
								{parseFloat(data.points).toFixed(2)}
							</div>
						</div>
						<div className="stat">
							<div>
								Experience
							</div>
							<div>
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Badges
							</div>
							<div>
								0
							</div>
						</div>
					</div>
				</div>
            </div>
        );
    }
}

function mapStateToProps(state, ownProps) {
	return {
		user: state.user,
		leagues: state.leagues
	};
}


function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(ProfileView);