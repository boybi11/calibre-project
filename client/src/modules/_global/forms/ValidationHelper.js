import revalidator from 'revalidator';

/**BASED ON https://github.com/flatiron/revalidator**/
export function validate(object, schema, options){
	let errors = {};
	let validation = revalidator.validate(object, schema, options);
	if (!validation.valid) {

		const humanize = (str) => {
			let frags = str.split('_');
			for (let i=0; i<frags.length; i++) {
				frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
			}
			return frags.join(' ');
		};

		validation.errors.forEach((error) => {
			let propName = humanize(error.property);
			errors[error.property] = `"${propName}" ${error.message}`;
		});
	}
	return {
		valid: validation.valid,
		errors: errors
	};
}
