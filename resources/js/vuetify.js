import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' 

Vue.use(Vuetify)

const opts = {
    theme: {
        themes: {
          light: {
            primary: '#b00845',
            secondary: '#b0bec5',
            accent: '#8c9eff',
            error: '#b71c1c',
          },
        },
      },
}

export default new Vuetify(opts)