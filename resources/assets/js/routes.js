import VueRouter from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'welcome',
        component: require('./views/articles/index')
    },
    {
        path: '/articles/:id(\\d+)',
        name: 'articles.show',
        component: require('./views/articles/show'),
    },
    {
        path: '/auth/login',
        component: require('./views/auth/login'),
        meta: {
            guest: true
        }
    },
    {
        path: '/auth/register',
        component: require('./views/auth/register'),
        meta: {
            guest: true
        }
    },
    {
        path: '/tags',
        component: require('./views/tags/index'),
    },
    {
        path: '/tags/:slug',
        name: 'tags.show',
        component: require('./views/tags/show'),
    },
    {
        path: '/',
        component: require('./views/layouts/app'),
        children: [
            {
                path: '/articles/create',
                name: 'articles.create',
                component: require('./views/articles/create'),
                meta: {
                    auth: true
                }
            }, 
            {
                path: '/articles',
                name: 'my.articles',
                component: require('./views/home/articles'),
                meta: {
                    auth: true
                }
            },
            {
                path: 'articles/:id(\\d+)/edit',
                name: 'articles.edit',
                component: require('./views/articles/edit'),
                meta: {
                    auth: true
                }
            },
            {
                path: '/favorites',
                name: 'favorites.index',
                component: require('./views/home/favorites'),
                meta: {
                    auth: true
                }
            }
        ]
    },
    
    {
        path: '/404',
        name: 'error.404',
        component: require('./views/errors/404')
    },
        {
        path: '/401',
        name: 'error.401',
        component: require('./views/errors/401')
    }
    
];

const route =  new VueRouter({
    mode: 'history',
    linkActiveClass: 'is-active',
    routes 
});

route.beforeEach( (to, from, next) => {
    let user = Laravel.user

    let requireGuest = to.meta.guest;
    let requireAuth = to.meta.auth;

    if (requireGuest) {
        if (user) {
            return next({ path: '/' })
        } else {
            return next()
        }
    }

    if (requireAuth) {
        if (user) {
            return next()
        } else {
            return next({ path: '/auth/login' })
        }
    }

    return next()
});

export default route