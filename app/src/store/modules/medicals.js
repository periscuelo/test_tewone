import { CHANGE_MEDICAL_DATA } from '../mutations-types';
import MedicalService from '@/services/medicals';

const mutations = {
  [CHANGE_MEDICAL_DATA](state, value) {
    state.medicals = value;
  },
};

const actions = {
  async getMedicals({ commit }) {
    try {
      const response = await MedicalService.getMedicals();
      commit(CHANGE_MEDICAL_DATA, response.data.body);
    } catch (error) {
      console.log('Não foi possível carregar os dados da API!', error);
    }
  },
};

const state = {
  medicals: [],
};

export default {
  namespaced: true,
  mutations,
  actions,
  state,
};
