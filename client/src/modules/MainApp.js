import React, {PropTypes} from 'react';
import DocumentTitle from 'react-document-title';

class MainApp extends React.Component {
	render() {
		return (
			<div>
				<DocumentTitle title="Calibre"/>
				{this.props.children}
			</div>
		);
	}
}
MainApp.propTypes = {
	children: PropTypes.object.isRequired
};

export default MainApp;