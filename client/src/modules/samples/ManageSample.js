import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as samplesActions from './samples.actions';
import ManageSampleForm from './components/ManageSampleForm';
import toastr from 'toastr';
import {browserHistory} from 'react-router';
import DocumentTitle from 'react-document-title';
import * as validationHelper from '../_global/forms/ValidationHelper';

class ManageSample extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.state = {
			pageTitle: (this.props.params.id ? "Edit Sample" : "Create Sample"),
			sample: {'name' : '', 'embedded_rune' : ''},
			errors: {},
			saving: false
		};
		this.handleInputState = this.handleInputState.bind(this);
		this.saveSample = this.saveSample.bind(this);
	}

	componentDidMount() {
		if (this.props.params.id) {
			this.props.actions.findSamples(this.props.params.id);
		}
	}

	componentWillReceiveProps(nextProps) {
		if (this.props.sample.id != nextProps.sample.id) {
			this.setState({sample: Object.assign({}, nextProps.sample)});
		}
	}

	handleInputState(event) {
		const field = event.target.name;
		let sample = this.state.sample;
		sample[field] = event.target.value;
		return this.setState({sample: sample});
	}

	sampleFormIsValid() {
		let schema = {
			properties: {
				name: {
					type: 'string',
					required: true,
					minLength: 3,
					allowEmpty: false
				},
				embedded_rune: {
					type: 'string',
					minLength: 3,
					required: true,
					allowEmpty: false
				}
			}
		};

		let validation = validationHelper.validate(this.state.sample, schema);
		this.setState({errors: validation.errors});
		return validation.valid;
	}

	saveSample(event) {
		event.preventDefault();
		if (!this.sampleFormIsValid()) {
			return;
		}

		this.setState({saving: true});

		if (this.state.sample.id) {
			this.props.actions.updateSample(this.state.sample)
				.then(() => this.redirectToSamplesPage())
				.catch(error => {
					toastr.error(error);
					this.setState({saving: false});
				});
		} else {
			this.props.actions.createSample(this.state.sample)
				.then(() => this.redirectToSamplesPage())
				.catch(error => {
					toastr.error(error);
					this.setState({saving: false});
				});
		}
	}

	redirectToSamplesPage() {
		this.setState({saving: false});
		browserHistory.push('/samples');
	}

	render() {

		if (!this.state.sample && this.props.params.id) {
			return <div>Loading...</div>;
		} 

		return (
			<div>
				<DocumentTitle title={this.state.pageTitle}/>
				<ManageSampleForm
					onChange={this.handleInputState}
					onSave={this.saveSample}
					sample={this.state.sample}
					errors={this.state.errors}
					saving={this.state.saving}/>
			</div>
		);
	}
}

ManageSample.propTypes = {
	sample: PropTypes.object.isRequired,
	actions: PropTypes.object.isRequired,
	params: PropTypes.object
};

ManageSample.contextTypes = {
	router: PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
	return {
		sample: state.samples.selected
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(samplesActions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(ManageSample);