import React, {PropTypes} from 'react';

const TaskForm = ({submitForm, toggleForm, formMode}) => {
	return(
		<div id="taskForm" className="form-overlay">
			<div className="form-box">
				<h3 className="title">
					{formMode == 'add' ? 'Add a' : 'Edit'} quest
				</h3>
				<div className="form">
					<div className="form-group">
						<div>
							Title
						</div>
						<div>
							<input type="text" className="form-control" />
						</div>
					</div>
					<div className="form-group">
						<div>
							Description
						</div>
						<div>
							<textarea className="form-control" />
						</div>
					</div>
					<div className="form-group">
						<div>
							Duration (in days)
						</div>
						<div>
							<input type="text" className="form-control" />
						</div>
					</div>
					<div className="form-group">
						<div>
							Exp Reward
						</div>
						<div>
							<input type="text" className="form-control" />
						</div>
					</div>
					<div className="form-group">
						<div>
							Points Reward
						</div>
						<div>
							<input type="text" className="form-control" />
						</div>
					</div>
					<div className="flex align-center">
						<button
							className="btn btn-clear white flex-1 margin-right"
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