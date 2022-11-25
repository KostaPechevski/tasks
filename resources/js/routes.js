import AllTasks from './components/Tasks/AllTasks';
import CreateTask from './components/Tasks/CreateTask';
export default {
    mode: 'history',
    routes: [
        {
            name: 'all-tasks',
            path: '/tasks',
            component: AllTasks
        },
        {
            name: 'create-task',
            path: '/create',
            component: CreateTask
        },
    ]
}
