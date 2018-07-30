import React, {PropTypes} from 'react';
import * as sessionHelper from './SessionHelper';
import functions from '../../constants/functions';
import md5 from 'md5';

//mode can be 'hide'/'disable'
class AuthorizedComponent extends React.Component {
	constructor(props, context) {
		super(props, context);
		this.hasPermission = this.hasPermission.bind(this);
		this.displayContent = this.displayContent.bind(this);
		this.componentDidMount = this.componentDidMount.bind(this);
	}

	componentDidMount(){
		// console.log($(this.refs.container).find(":input"));
		if (this.props.mode == 'disable' && !this.hasPermission()) {
			// 	//disable all input and buttons
			$(this.refs.container).find(":input").prop("disabled", true);
		}
	}

	hasPermission() {
		if (functions[this.props.func]) {
			//get user permissions
			let permissions = sessionHelper.getUser().permissions;
			if (permissions && permissions.indexOf(md5(this.props.func)) != -1) {
				return true;
			} else {
				console.log("User permissions are undefined ");
			}
		} else {
			console.log("Invalid function: " + this.props.func);
		}
		return false;
	}

	displayContent() {
		if (this.props.mode == 'disable' || (this.props.mode == 'hide' && this.hasPermission())) { 
			return true 
		}
		return false;
	}

	render() {
		return (
			<span ref="container">
				{this.displayContent() &&
					this.props.children
				}
			</span>
		);
	}
}

AuthorizedComponent.propTypes = {
	mode: PropTypes.string.isRequired, //can be hide/disable
	func: PropTypes.string.isRequired  //from functions.js
};


export default AuthorizedComponent;