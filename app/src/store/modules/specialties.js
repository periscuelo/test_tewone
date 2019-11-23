import { CHANGE_SPECIALTY_DATA } from '../mutations-types';
import SpecialtyService from '@/services/specialties';

const getters = {
  optsSpecialty: state => state.specialties.map(specialty => ({
    value: specialty.id,
    text: specialty.specialty,
  })),
};

const mutations = {
  [CHANGE_SPECIALTY_DATA](state, value) {
    state.specialties = value;
  },
};

const actions = {
  async getSpecialties({ commit }) {
    try {
      const response = await SpecialtyService.getSpecialties();
      commit(CHANGE_SPECIALTY_DATA, response.data.body);
    } catch (error) {
      console.log('Não foi possível carregar os dados da API!', error);
    }
  },
};

const state = {
  specialties: [],
};

export default {
  namespaced: true,
  getters,
  mutations,
  actions,
  state,
};
