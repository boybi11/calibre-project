import React from 'react';

const PageNotFound = () => {
	return (
		<div>
			<div className="example text-center">
				<h1 className="section-title"> Force not found </h1>
				<img src={require('assets/img/vader404.jpg')} className="img-fluid"/>
				<p> These are not the droids you are looking for...</p>
			</div>
			
		</div>
	);
};

export default PageNotFound;