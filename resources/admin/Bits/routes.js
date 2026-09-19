import Dashboard from '../Modules/Dashboard';
import Settings from '../Modules/Settings';
import Templates from '../Modules/Templates';

export default [
    // {
    //     name: 'dashboard',
    //     path: '/',
    //     component: Dashboard,
    //     exact: true
    // },
    {
        name: 'templates',
        path: '/',
        component: Templates,
        exact: true
    },
    {
        name: 'settings',
        path: '/settings',
        component: Settings,
        exact: true
    }
];