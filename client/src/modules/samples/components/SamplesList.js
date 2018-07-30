import React, {PropTypes} from 'react';
import {Link} from 'react-router';
import AuthorizedComponent from '../../_global/AuthorizedComponent';

const SamplesList = ({samples, onDelete}) => {
	return (
		<div className="example">
			<div className="create-new-btn">
				<Link to="/sample" className="btn btn-success pull-xs-right"> Create new</Link>
			</div>
			<h1 className="section-title"> Samples 
				{!samples.length && <span className="no-content">Empty</span>}
			</h1>
			<div className="example-samples">
				<table className="table">
					<thead>
						<tr>
							<th> ID</th>
							<th> Name</th>
							<th> Runes</th>
							<th> Actions</th>
						</tr>
					</thead>
					<tbody>
						{samples.map(sample => 
							<tr key={sample.id}>
								<th scope="row">{sample.id}</th>
								<td>{sample.name}</td>
								<td>{sample.embedded_rune}</td>
								<td width="17%">
									<AuthorizedComponent mode="hide" func="edit-sample1">
										<Link to={'/sample/' + sample.id} className="btn btn-link btn-sm">Edit</Link>
									</AuthorizedComponent>
									<button className="btn btn-link btn-sm" onClick={onDelete.bind(this, sample.id)}> Delete</button>
								</td>
							</tr>
						)}
					</tbody>
				</table>
			</div>
		</div>
	);
};

SamplesList.propTypes = {
	samples: PropTypes.array.isRequired,
	onDelete: PropTypes.func
};

export default SamplesList;