import React, {PropTypes} from 'react';
import Datetime from 'react-datetime';
import "react-datetime/css/react-datetime.css";

const TextInput = ({name, label, onChange, placeholder, value, error, type = 'text', disabled, className, autocomplete="on", options = {}}) => {
	let formGroup = 'form-group';
	let formControl = 'form-control';
	let animtedPlaceholder = label ? label : (placeholder ? placeholder : false);
	if (error && error.length > 0) {
		formGroup += " " + 'has-danger';
		formControl += " " + 'form-control-danger';
	}
	if (!value) { value = ''; } //initialize value always

	let dateTimeOnChange = function(moment){
		//simulate an onchange event
		let event = {
			target : {
				name : name,
				value: moment.format("YYYY-MM-DD HH:mm:SS")
			} 
		};
		onChange(event);
	};

	return (
		<div className={formGroup}>
			<div className={(value || type == "select" ? "active" : "") + " animated-placeholder"}>
				{animtedPlaceholder && <label htmlFor={name}>{label}</label>}
				<div className="field">
					{type == "datetime-local" && 
						<Datetime
							value={value}
							inputProps={{disabled:disabled, placeholder:placeholder, name:name}}
							onChange={dateTimeOnChange}/>
					}
					{type != "datetime-local" && type != "select" &&
						<input
							type={type}
							name={name}
							className={className || formControl}
							placeholder={placeholder}
							value={value}
							disabled={disabled}
							onChange={onChange}
							autoComplete="off"
						/>
					}
					{type != "datetime-local" && type == "select" &&
						<select
							name={name}
							className={className || formControl}
							disabled={disabled}
							onChange={onChange}
							value={value}
						>
							{
								Object.keys(options).map((key) => {
									return <option value={key} key={key}>{options[key]}</option>;
								})
							}
						</select>
					}
					{error && <div className="alert alert-danger mt-10">{error}</div>}

				</div>
			</div>
		</div>
	);
};

TextInput.propTypes = {
	name: PropTypes.string.isRequired,
	onChange: PropTypes.func.isRequired,
	placeholder: PropTypes.string,
	label: PropTypes.string,
	value:  React.PropTypes.oneOfType([
		React.PropTypes.string,
		React.PropTypes.number
	]),
	error: PropTypes.string,
	type: PropTypes.string,
	disabled: PropTypes.bool,
	autocomplete: PropTypes.string,
	className: PropTypes.string,
	options: PropTypes.object	
};

export default TextInput;
