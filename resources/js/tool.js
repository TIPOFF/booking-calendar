/* eslint-disable no-undef, global-require */
Nova.booting((Vue, router) => {
  router.addRoutes([
    {
      name: 'booking-calendar',
      path: '/booking-calendar',
      component: require('./components/Tool.vue'),
    },
  ]);
})
