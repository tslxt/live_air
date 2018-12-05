import Home from './components/Home';
import Live from './components/Live';
import Login from './components/Login';
import UserInfo from './components/UserInfo';


export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/live/:course_id',
        name: 'live',
        component: Live,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/userinfo',
        name: 'userinfo',
        component: UserInfo,
        meta: {
            requiresAuth: true
        },
    },
];