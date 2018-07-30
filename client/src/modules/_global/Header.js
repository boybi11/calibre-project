import React, {PropTypes} from 'react';
import {Link, IndexLink} from 'react-router';

const Header = ({redirectToIndex}) => {
	return (
		<div className="header">
			<div className="header__logo">
				<i onClick={redirectToIndex} className="ion-ios-bolt-outline"></i>
			</div>
			<ul className="header__nav-list">
				<li className="header__nav-item">
					<IndexLink to="/" className="header__nav-link" activeClassName="active-nav"> Home </IndexLink>
				</li>
				<li className="header__nav-item">
					<Link to="/samples" className="header__nav-link" activeClassName="active-nav"> Samples</Link>
				</li>

				<li className="header__nav-item">
					<Link to="/logout" className="header__nav-link" activeClassName="active-nav"> Logout</Link>
				</li>
				<li className="header__nav-item">
					<a href="https://github.com/JuneDomingo/react-starterkit" className="header__nav-link"> Github</a>
				</li>
			</ul>
		</div>
	);
};


Header.propTypes = {
	redirectToIndex: PropTypes.func.isRequired
};


export default Header;