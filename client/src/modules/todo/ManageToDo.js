import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import * as todoActions from './todo.actions';

class ManageToDo extends React.Component {
    constructor(props, context) {
        super(props, context);

        this.handleInputState = this.handleInputState.bind(this);
        this.clearTodo = this.clearTodo.bind(this);
        this.addTodo = this.addTodo.bind(this);

        this.state = {
            todo: 'hello world'
        };
    }

    handleInputState(event) {
        const field = event.target.name;
        let todo = event.target.value;
        return this.setState({todo: todo});
    }

    addTodo(event) {
        event.preventDefault();
        this.props.actions.saveTodo(this.state.todo);
        this.setState({todo:''});
    }

    clearTodo(event) {
        this.setState({todo:''});
        this.props.actions.clearTodo(this.state.todo);
    }

    render() {
        let idx = 0;
        return (
            <form onSubmit={this.addTodo}>
                Add To Do &nbsp;
                <input type="text"
                    name="text"
                    onChange={this.handleInputState}
                    value={this.state.todo}/>
                <input type="submit" value="Add"/>
                <button onClick={this.clearTodo} type="button"> CLEAR</button>
                <hr/>
                <ul>
                {this.props.todos.map(todo =>
                    <li key={todo.id}>
                        {todo.text}
                    </li>
                )}
                </ul>
            </form>
        );
    }
}

ManageToDo.propTypes = {
    actions: PropTypes.object.isRequired
};

ManageToDo.contextTypes = {
    router: PropTypes.object.isRequired
};

function mapStateToProps(state, ownProps) {
    return {
        todos : state.todos
    }
}

function mapDispatchToProps(dispatch) {
    return {
        actions: bindActionCreators(todoActions, dispatch)
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(ManageToDo);
