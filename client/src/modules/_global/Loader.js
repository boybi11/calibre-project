import React, {PropTypes} from 'react';

const Loader = ({loading}) => {
	return(
		<div className={(loading && "in") + " loader"}>
            <i className="fas fa-circle-notch fa-spin" />
        </div>
	);
};

export default Loader;