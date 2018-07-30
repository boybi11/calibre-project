import React, {PropTypes} from 'react';
import DocumentTitle from 'react-document-title';

class LayoutBlank extends React.Component {
	render() {
		return (
			<div>
				{this.props.children}
			</div>
		);
	}
}
LayoutBlank.propTypes = {
	children: PropTypes.object.isRequired
};

export default LayoutBlank;