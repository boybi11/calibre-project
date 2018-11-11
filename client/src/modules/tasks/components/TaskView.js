import React, {PropTypes} from 'react';
import moment from 'moment';
import Loader from '../../_global/Loader';

const TaskView = ({complete, toggleView, textChangeHandle, task, show, fe_type, user}) => {
    // if(task.users != undefined) {
    //     task.users = task.users.sort((a, b) => {
    //         a.score = a.score ? a.score : 0;
    //         b.score = b.score ? b.score : 0;
    
    //         if (parseFloat(a.score) > parseFloat(b.score))
    //             return -1;
    //         if (parseFloat(a.score) < parseFloat(b.score))
    //             return 1;
    //         return 0;
    //     });
    // }
	return(
		<div id="taskView" className={(show && 'in') + " form-overlay modal"}>
			<div className="form-box modal-box">
                <div
                    className="close-btn"
                    onClick={() => toggleView(false)}
                >
                    <i className="fas fa-times" />
                </div>
                {
                    task && (
                        <div>
                            <h3 className="title">
                                {task.title ? task.title : 'No title'}
                            </h3>
                            <div className="form overflow-auto">
                                {
                                    Object.keys(task).length > 0 && task.users.length > 0 ? (
                                        task.users.map((player, index) => {
                                            return (
                                                <div>
                                                    <div className={"task-status bg-" + (player.task_status != undefined ? (player.task_status == 'student' ? 'warning' : 'success') : '')}>
                                                        {player.task_status != undefined ? (player.task_status == 'student' ? 'Pending' : 'Finished') : (
                                                            <span>
                                                                <i className="fas fa-circle"/><i className="fas fa-circle"/><i className="fas fa-circle"/>
                                                            </span>
                                                        )}
                                                    </div>
                                                    <div className="player-card flex flex-align-center" style={{animationDelay: (0.2 * (index + 1)) + 's'}}>
                                                        <div className="bg-icon">
                                                            <i className="fas fa-user-astronaut"/>
                                                        </div>
                                                        <div className="dp">
                                                            <img src={require('assets/img/log.jpg')} />
                                                        </div>
                                                        <div className="fullname margin-left-20 flex-1">
                                                            <div className="player-name">
                                                                {player.first_name + " " + player.last_name}
                                                            </div>
                                                            <div className="player-email">
                                                                {player.email}
                                                            </div>
                                                        </div>
                                                        {
                                                            player.task_status != undefined ? (
                                                                <div>
                                                                    {
                                                                        player.loading ? (
                                                                            <div>
                                                                                <Loader loading/>
                                                                            </div>
                                                                        ) : (
                                                                            <div>
                                                                                {
                                                                                    player.task_status == 'student' ? (
                                                                                        <div>
                                                                                            {
                                                                                                fe_type == 'student' ? (
                                                                                                    "Waiting for score..."
                                                                                                ) : (
                                                                                                    <div className="flex flex-align-center score-sheet">
                                                                                                        <input
                                                                                                            placeholder="Enter score here..."
                                                                                                            onChange={e => textChangeHandle(e, player)}
                                                                                                            value={player.score > 0 ? player.score : ''}
                                                                                                        />
                                                                                                        <div
                                                                                                            className={`btn-xs bg-success hover-opacity transitioned`}
                                                                                                            role="button"
                                                                                                            onClick={() => complete(task, player.score, player.id)}
                                                                                                        >
                                                                                                            Save
                                                                                                        </div>
                                                                                                    </div>
                                                                                                )
                                                                                            }
                                                                                        </div>
                                                                                    ) : (
                                                                                        <div>
                                                                                            {player.score}
                                                                                        </div>
                                                                                    )   
                                                                                }
                                                                            </div>
                                                                        )
                                                                    }
                                                                </div>
                                                            ) : (
                                                                <div>
                                                                    {
                                                                        player.loading ? (
                                                                            <div>
                                                                                <Loader loading/>
                                                                            </div>
                                                                        ) : (
                                                                           <div>
                                                                               {
                                                                                   fe_type == 'student' && ((player.id == user) && task.onGoing) && (
                                                                                        <div
                                                                                            className={`btn-xs bg-success hover-opacity transitioned`}
                                                                                            role="button"
                                                                                            onClick={() => complete(task, 0, player.id)}
                                                                                        >
                                                                                            Complete
                                                                                        </div>
                                                                                    )
                                                                               }
                                                                            </div> 
                                                                        )
                                                                    }
                                                                </div>
                                                            )
                                                        }
                                                    </div>
                                                </div>
                                            )
                                        })
                                    ) : (
                                        <div className="empty-message">
                                            There are no players found for this task.
                                        </div>
                                    )
                                }
                            </div>
                        </div>
                    )
                }
			</div>
		</div>
	);
};

export default TaskView;