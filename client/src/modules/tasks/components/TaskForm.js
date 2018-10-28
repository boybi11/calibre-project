import React, {PropTypes} from 'react';

const TaskForm = ({submitForm, toggleForm, formMode, textChangeHandle, data, show}) => {
	return(
		<div id="taskForm" className={(show && 'in') + " form-overlay modal"}>
			<div className="form-box modal-box">
				<h3 className="title">
					{formMode == 'add' ? 'Create a' : 'Edit'} task
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