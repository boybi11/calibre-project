/*eslint-disable no-console*/

import React from 'react';
import TextInput from '../../_global/forms/TextInput';
import AuthorizedComponent from '../../_global/AuthorizedComponent';

const ManageSampleForm = ({sample, onSave, onChange, saving, errors}) => {
	return (
		<AuthorizedComponent func="edit-sample1" mode="disable">
			<div className="example">
				<h1 className="section-title"> Form</h1>
				<form>
					<div className="form-group row">
						<div className="col-sm-10">	
							<TextInput
								name="name"
								label="Name"
								value={sample.name}
								onChange={onChange}
								error={errors.name}/>
						</div>
					</div>

					<div className="form-group row">
						<div className="col-sm-10">	
							<TextInput
								name="embedded_rune"
								label="Embedded Rune"
								value={sample.embedded_rune}
								onChange={onChange}
								error={errors.embedded_rune}/>
						</div>
					</div>

					<div className="form-group row">
						<div className="col-sm-12">
							<input
								type="submit"
								disabled={saving}
								value={saving ? 'Saving...' : 'Save'}
								className="btn btn-success pull-xs-right"
								onClick={onSave}/>
						</div>
					</div>
				</form>
			</div>
		</AuthorizedComponent>
	);
};

ManageSampleForm.propTypes = {
	sample: React.PropTypes.object.isRequired,
	onSave: React.PropTypes.func.isRequired,
	onChange: React.PropTypes.func.isRequired,
	saving: React.PropTypes.bool,
	errors: React.PropTypes.object
};

export default ManageSampleForm;
