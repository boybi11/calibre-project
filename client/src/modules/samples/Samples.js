/*eslint-disable no-console*/

import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as samplesActions from './samples.actions';
import SamplesList from './components/SamplesList';
import {browserHistory}  from 'react-router';
import toastr from 'toastr';
import DocumentTitle from 'react-document-title';

class Samples extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.handleDelete = this.handleDelete.bind(this);
	}

	componentDidMount() {
		this.props.actions.loadSamples();
	}

	handleDelete(sampleId) {
		this.props.actions.deleteSample(sampleId);
	}

	render() {
		const {samples} = this.props;
		return (
			<div>
				<DocumentTitle title="Example"/>
				<SamplesList
					samples={samples.list}
					onDelete={this.handleDelete}/>
			</div>
		);
	}
}

Samples.propTypes = {
	samples: PropTypes.object.isRequired,
	actions: PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		samples: state.samples
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(samplesActions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(Samples);