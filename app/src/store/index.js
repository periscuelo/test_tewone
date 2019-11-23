import Vue from 'vue';
import Vuex from 'vuex';
import createLogger from 'vuex/dist/logger';

import Medicals from './modules/medicals';
import Specialties from './modules/specialties';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    Medicals,
    Specialties,
  },
  strict: debug,
  plugins: debug ? [createLogger()] : [],
});
