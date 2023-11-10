import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/js/views/HomeView.vue'),
  },
  {
    path: '/map',
    name: 'map',
    component: () => import('@/js/views/panel/user-object/UserObject.vue'),
  },
  {
    path: '/login',
    name: 'auth',
    component: () => import('@/js/views/Auth.vue'),
  },
  {
    path: '/panel',
    name: 'accounts',
    component: () => import('@/js/views/panel/accounts/Accounts.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/objects',
    name: 'objects',
    component: () => import('@/js/views/panel/objects.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/objects/groups',
    name: 'objectGroups',
    component: () => import('@/js/views/panel/objectGroup.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/equipment',
    name: 'equipment',
    component: () => import('@/js/views/panel/equipment.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/users',
    name: 'users',
    component: () => import('@/js/views/panel/users/Users.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/tariffs',
    name: 'tariffs',
    component: () => import('@/js/views/panel/tariffs/Tariffs.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/equipment/type',
    name: 'equipmentType',
    component: () => import('@/js/views/panel/typeEquipment.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/repeater',
    name: 'repeater',
    component: () => import('@/js/views/panel/repeater.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/users/roles',
    name: 'usersRoles',
    component: () => import('@/js/views/panel/userRoles.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/events',
    name: 'events',
    component: () => import('@/js/views/panel/eventPanel.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/dealers',
    name: 'dealers',
    component: () => import('@/js/views/panel/dillers.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/basket',
    name: 'basket',
    component: () => import('@/js/views/panel/basket.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/support',
    name: 'support',
    component: () => import('@/js/views/panel/support.vue'),
    meta: {
      auth: true,
      admin: true
    }
  },
  {
    path: '/panel/user-objects',
    name: 'user-objects',
    component: () => import('@/js/views/panel/user-object/UserObject.vue'),
    meta: {
      auth: true,
      admin: false
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to,from,next)=>{
  if(window.localStorage.getItem("auth_token")){
    axios.defaults.headers.common['Authorization'] = 'Bearer '+ window.localStorage.getItem("auth_token");
  }
  if (to.meta.auth) {
    axios.post('/auth/check')
      .then((res) => {
        if (res.data.result) {
          if (to.meta.admin) {
            if (parseInt(res.data.role) !==1) {
              window.location.href = '/'
              return false
            }
          } else if (['user-objects'].includes(to.name) && parseInt(res.data.role) !==3) {
            window.location.href = '/'
            return false
          }
          next();
        } else {
          window.localStorage.removeItem('auth_token')
          window.location.href = '/'
        }
      })
      .catch(res => {
        if (res.response.status === 401) {
          window.localStorage.removeItem('auth_token')
          window.location.href = '/'
        }
      })
  }
  else{
    if(window.localStorage.getItem("auth_token")){
      axios.post('/auth/check')
          .then((res) => {

          })
          .catch((res) => {
            window.localStorage.removeItem(("auth_token"));
          });
    }
    next();
  }
});


export default router



