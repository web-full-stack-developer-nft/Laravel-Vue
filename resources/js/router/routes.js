function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/taskcurd', name: 'home', component: page('taskcurd.vue') },
  { path: '/task', name: 'home', component: page('task.vue') },
  { path: '/client', name: 'home', component: page('client.vue') },
  { path: '/project', name: 'home', component: page('project.vue') },
  { path: '/department', name: 'home', component: page('department.vue') },
  { path: '/designation', name: 'home', component: page('designation.vue') },
  { path: '/status', name: 'home', component: page('status.vue') },
  { path: '/issues', name: 'home', component: page('issues.vue') },
  { path: '/issue', name: 'home', component: page('issue.vue') },
  { path: '/issue-type', name: 'home', component: page('issue-type.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },

  { path: '*', component: page('errors/404.vue') }
]
