/* eslint-disable no-new */
import Vue from 'vue'

import registration from '@/js/views/Registration.vue'

window.axios = require('axios')

new Vue({
  el: '#registration',
  //  vuetify: new Vuetify(),
  components: {
    'my-registration': registration
    // ValidationProvider
  }
})
