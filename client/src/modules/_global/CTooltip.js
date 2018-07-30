/*eslint-disable no-console*/

import React, {PropTypes} from 'react';
import { Tooltip, OverlayTrigger } from 'react-bootstrap';

class CTooltip extends React.Component {
	constructor(props, context) {
		super(props, context);
	}

	tooltip() {
		return (
			<Tooltip id={(Math.random() * 99999)}>
				{this.props.title}
			</Tooltip>
		);
	}

	render() {
		return (
			<OverlayTrigger overlay={this.tooltip()} placement={this.props.placement ? this.props.placement : "top"}>
				{this.props.children}
			</OverlayTrigger>
		);
	}
}

CTooltip.propTypes = {
	children: PropTypes.object.isRequired,
	title: PropTypes.string,
	placement: PropTypes.string
};

export default CTooltip;