import React, {Component, PropTypes} from 'react';
import {connect} from 'react-redux';
import moment from 'moment';
import {bindActionCreators} from 'redux';
import CTooltip from '../_global/CTooltip';
import Loader from '../_global/Loader';


class ProfileView extends Component {
	constructor(props) {
		super (props);

		this.state = {
			loading: true,
			user: Object.assign({}, this.props.user)
		};
    }
    
    render() {
        return(
            <div className="profile-container">
                <div className="user-dp">
					<img
						src={require('assets/img/log.jpg')}
					/>
					<div className="username">
						{this.state.user.email}
					</div>
					<div className="usertype">
						{this.state.user.front_user_type == 'student' ? 'Player' : 'Game Master'}
					</div>
				</div>
				<div className="flex">
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
				</div>
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
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Quests
							</div>
							<div>
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Completed Quest
							</div>
							<div>
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Failed Quest
							</div>
							<div>
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Success rate
							</div>
							<div>
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Failing rate
							</div>
							<div>
								0
							</div>
						</div>
						<div className="stat">
							<div>
								Points
							</div>
							<div>
								0
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


// function mapDispatchToProps(dispatch) {
// 	return {
// 		actions: bindActionCreators(leagueActions, dispatch)
// 	};
// }

export default connect(mapStateToProps, null)(ProfileView);