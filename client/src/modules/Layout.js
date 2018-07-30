import React, {PropTypes} from 'react';
import {browserHistory} from 'react-router';
import Nav from './_global/nav/Nav';

class Layout extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.onClickLogo = this.onClickLogo.bind(this);
	}

	onClickLogo() {
		browserHistory.push('/');
	}

	render() {
		return (
			<div>
				<div className="navigation">
					<Nav />
				</div>
				<div>
					{this.props.children}
				</div>
			</div>
		);
	}
}
Layout.propTypes = {
	children: PropTypes.object.isRequired
};

export default Layout;