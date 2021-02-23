import NotFound from './components/NotFound';
import Home from './components/Home';
import Register from './components/Register';
import Login from './components/Login';
import Favorites from './components/Favorites';
import axios from 'axios';

export default {
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            name: 'Home',
            path: '/',
            component: Home
        },
        {
            name: 'Register',
            path: '/register',
            component: Register
        },
        {
            name: 'Login',
            path: '/login',
            component: Login
        },
        {
            name: 'Logout',
            path: '/logout',
            beforeEnter: (to, from, next) => {
                axios.post('/api/logout').then(() => {
                    return next({ name: 'Home' })
                }).catch(() => {
                    return next({ name: 'Home'})
                })
            }
        },
        {
            name: 'Favorites',
            path: '/favorites',
            component: Favorites,
            beforeEnter: (to, from, next) => {
                axios.get('api/authenticated').then(() => {
                    next()
                }).catch(() => {
                    return next({ name: 'Login'})
                })
            }
        }

    ]
}
