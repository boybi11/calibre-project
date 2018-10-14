import React, {PropTypes} from 'react';

const LeagueForm = ({submitForm, toggleForm, formMode, textChangeHandle, data, show}) => {
	return(
		<div id="leagueForm" className={(show && 'in') + " form-overlay modal"}>
			<div className="form-box modal-box">
				<h3 className="title">
					{formMode == 'add' ? 'Create a' : 'Edit'} league
				</h3>
				<div className="form">
					<div className="form-group">
						<div>
							Name
						</div>
						<div>
                            <input
                                name="name"
                                type="text"
                                className="form-control"
                                onChange={(e) => textChangeHandle(e)}
                                value={data.name}
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

export default LeagueForm;