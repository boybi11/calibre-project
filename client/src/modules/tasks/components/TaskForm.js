import React, {PropTypes} from 'react';

const TaskForm = ({submitForm, toggleForm, formMode, textChangeHandle, data, show, selectBadge}) => {
	const badges = {
		bdg_1: require('assets/img/badges/bdg_1.png'),
		bdg_2: require('assets/img/badges/bdg_2.png'),
		bdg_3: require('assets/img/badges/bdg_3.png')
	};

	return(
		<div id="taskForm" className={(show && 'in') + " form-overlay modal"}>
			<div className="form-box modal-box">
				<h3 className="title">
					{formMode == 'add' ? 'Create a' : 'Edit'} quest
				</h3>
				<div className="form">
					<div className="form-group">
						<div>
							Title
						</div>
						<div>
                            <input
                                name="title"
                                type="text"
                                className="form-control"
                                onChange={(e) => textChangeHandle(e)}
                                value={data.title}
                            />
						</div>
					</div>
					<div className="form-group">
						<div>
							Description
						</div>
						<div>
                            <textarea
                                name="description"
                                className="form-control"
                                onChange={(e) => textChangeHandle(e)}
								value={data.description}
							/>
						</div>
					</div>
					<div className="form-group">
						<div>
							Duration
						</div>
						<div>
                            <input
                                name="duration"
                                type="text"
                                className="form-control"
                                onChange={(e) => textChangeHandle(e)}
                                value={data.duration}
                            />
						</div>
					</div>
					<div className="form-group">
						<div>
							Exp Reward
						</div>
						<div>
                            <input
                                name="exp"
                                type="text"
                                className="form-control"
                                onChange={(e) => textChangeHandle(e)}
                                value={data.exp}
                            />
						</div>
					</div>
					<div className="form-group">
						<div>
							Points Reward
						</div>
						<div>
                            <input
                                name="points"
                                type="text"
                                className="form-control"
                                onChange={(e) => textChangeHandle(e)}
                                value={data.points}
                            />
						</div>
					</div>
					<div className="form-group">
						<div>
							Badge Reward
						</div>
						<div>
                            <div className="bdg-holder">
								{
									Object.keys(badges).map((badge) => {
										return(
											<div
												className={`badge-option ${data.badge_reward == badge ? 'selected' : ''}`}
												onClick={() => selectBadge("badge_reward", badge)}
											>
												<img src={badges[badge]} />
												<i className="fas fa-check-square indicator" />
											</div>
										)
									})
								}
							</div>
						</div>
					</div>
					<div className="form-group">
						<div>
							Leaderboard Badge
						</div>
						<div>
                            <div className="bdg-holder">
								{
									Object.keys(badges).map((badge) => {
										return(
											<div
												className={`badge-option ${data.badge_leader == badge ? 'selected' : ''}`}
												onClick={() => selectBadge("badge_leader", badge)}
											>
												<img src={badges[badge]} />
												<i className="fas fa-check-square indicator" />
											</div>
										)
									})
								}
							</div>
						</div>
					</div>
					<div className="flex align-center">
						<button
							className="btn btn-danger flex-1 margin-right"
							onClick={() => toggleForm(false)}
						>
							cancel
						</button>
						<button
							className="btn btn-success flex-1 margin-left"
							onClick={() => submitForm()}
						>
							save
						</button>
					</div>
				</div>
			</div>
		</div>
	);
};

export default TaskForm;