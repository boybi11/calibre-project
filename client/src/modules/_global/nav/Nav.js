import React from 'react';
import CTooltip from '../CTooltip';
import {connect} from 'react-redux';
import {Link} from 'react-router';

export class Nav extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			menu: "out"
		};

		this.toggleMenu = this.toggleMenu.bind(this);
	}

	toggleMenu() {
		let menu = "out";

		if(this.state.menu == "out") {
			menu = "in";
		}

		this.setState({menu});
	}

	render() {
		return (
			<div className="flex header-menu">
				<div className="flex-auto padded-10 pad-sides-50 avatar-container">
					<img
						className="thumb-200"
						src={require('assets/img/avatars/avatar1.png')}
					/>
				</div>
				<div className="flex-1 overflow-hidden flex flex-direction-column">
					<div className="menu-container flex flex-align-center">
						<div className="flex-1 pad-left-10">
							{this.props.user.front_user_type == "student" ? "Player" : "Game Master"} {this.props.user.email}
						</div>
						<div
							className="padded-10 inline-block"
							onClick={this.toggleMenu}
						>
							<CTooltip
								title="Menu"
								placement="bottom"
							>
								<div
									className="icon icon-circular icon-large text-large bg-primary hover-scale transitioned margin-right-10"
									role="button"
								>
									<i className="ion-android-menu"></i>
								</div>
							</CTooltip>
						</div>
						<div className={this.state.menu + " menu-toggable overflow-hidden"}>
							<div className="absolute top-0 left-0">
								<div className="padded-10 inline-block transitioned">
									<CTooltip
										title="Shop"
										placement="bottom"
									>
										<div
											className="icon icon-circular icon-large text-large bg-primary hover-scale transitioned margin-right-10"
											role="button"
										>
											<i className="ion-home"></i>
										</div>
									</CTooltip>
								</div>
								<div className="padded-10 inline-block transitioned">
									<CTooltip
										title="Achievements"
										placement="bottom"
									>
										<div
											className="icon icon-circular icon-large text-large bg-danger hover-scale transitioned margin-right-10"
											role="button"
										>
											<i className="ion-trophy"></i>
										</div>
									</CTooltip>
								</div>
								<div className="padded-10 inline-block transitioned">
									<CTooltip
										title="Tasks"
										placement="bottom"
									>
										<Link to="/tasks">
											<div
												className="icon icon-circular icon-large text-large bg-success hover-scale transitioned margin-right-10"
												role="button"
											>
												<i className="ion-android-send"></i>
											</div>
										</Link>
									</CTooltip>
								</div>
								<div className="padded-10 inline-block transitioned">
									<CTooltip
										title="Notifications"
										placement="bottom"
									>
										<div
											className="icon icon-circular icon-large text-large bg-warning hover-scale transitioned margin-right-10"
											role="button"
										>
											<i className="ion-android-notifications"></i>
										</div>
									</CTooltip>
								</div>
								<div className="padded-10 inline-block transitioned">
									<Link to="/logout">
										<CTooltip
											title="Log out"
											placement="bottom"
										>
											<div
												className="icon icon-circular icon-large text-large bg-primary hover-scale transitioned margin-right-10"
												role="button"
											>
												<i className="ion-log-out"></i>
											</div>
										</CTooltip>
									</Link>
								</div>
							</div>
						</div>
					</div>
					<div className="exp-bar padded-20 flex-1 flex flex-align-center relative">
						<div className="full-width">
							<div className="full-width relative">
								<div className="flex align-cener">
									<div className="flex-1">
										Base Exp (1050 / 2100)
									</div>
									<div>
										LVL 100
									</div>
								</div>
								<div className="bar relative">
									<div className="indicator absolute left-0 top-0 bg-warning transitioned full-height">
									</div>
								</div>
							</div>
							<div className="full-width relative margin-top-20">
								<div className="flex align-cener">
									<div className="flex-1">
										Job Exp (1050 / 2100)
									</div>
									<div>
										LVL 100
									</div>
								</div>
								<div className="bar relative">
									<div className="indicator absolute left-0 top-0 bg-primary transitioned full-height">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

Nav.propTypes = {
	user: React.PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		user: state.user
	};
}

export default connect(mapStateToProps, null)(Nav);