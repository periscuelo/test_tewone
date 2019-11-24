import { CHANGE_MEDICALS_DATA, CHANGE_MEDICAL_DATA } from '../mutations-types';
import MedicalService from '@/services/medicals';

const formatPhone = phone => {
  let ret = '';
  if (phone.length === 11) {
    ret = `(${phone.substr(0, 2)}) ${phone.substr(2, 5)}-${phone.substr(7, 4)}`;
  } else {
    ret = `(${phone.substr(0, 2)}) ${phone.substr(2, 4)}-${phone.substr(6, 4)}`;
  }
  return ret;
};

const getters = {
  gridMedical: state => state.medicals.map(medical => ({
    id: medical.id,
    name: medical.name,
    crm: medical.crm,
    phone: formatPhone(medical.phone),
    specialties: medical.medicals_specialties.map(specialties => specialties.specialty).join(', '),
    actions: '',
  })),
  medical: state => {
    let ret = {};
    if (state.medical.id !== undefined) {
      ret = {
        id: state.medical.id,
        name: state.medical.name,
        crm: state.medical.crm,
        phone: formatPhone(state.medical.phone),
        medicals_specialties: state.medical.medicals_specialties.map(specialties => specialties.id),
      };
    }
    return ret;
  },
};

const mutations = {
  [CHANGE_MEDICALS_DATA](state, value) {
    state.medicals = value;
  },
  [CHANGE_MEDICAL_DATA](state, value) {
    state.medical = value;
  },
};

const actions = {
  async getMedicals({ commit }) {
    try {
      const response = await MedicalService.getMedicals();
      commit(CHANGE_MEDICALS_DATA, response.data);
    } catch (error) {
      commit(CHANGE_MEDICALS_DATA, []);
      console.log('Não foi possível carregar os dados da API!', error);
    }
  },
  async getMedical({ commit }, id) {
    try {
      const response = await MedicalService.getMedical(id);
      commit(CHANGE_MEDICAL_DATA, response.data);
    } catch (error) {
      commit(CHANGE_MEDICAL_DATA, {});
      console.log('Não foi possível carregar os dados da API!', error);
    }
  },
  async removeMedical({ dispatch }, id) {
    try {
      const response = await MedicalService.deleteMedical(id);
      if (response.status === 204) dispatch('getMedicals');
    } catch (error) {
      console.log('Não foi possível apagar o dado na API!', error);
    }
  },
  async searchMedical({ commit }, data) {
    try {
      const response = await MedicalService.searchMedical(data);
      commit(CHANGE_MEDICALS_DATA, response.data);
    } catch (error) {
      commit(CHANGE_MEDICALS_DATA, []);
      console.log('Não foi possível encontrar os dados na API!', error);
    }
  },
  async setMedical({ dispatch }, data) {
    try {
      const response = await MedicalService.setMedical(data);
      if (response.status === 201) dispatch('getMedicals');
    } catch (error) {
      console.log('Não foi possível salvar os dados na API!', error);
    }
  },
  async updateMedical({ dispatch }, data) {
    try {
      const response = await MedicalService.updateMedical(data);
      if (response.status === 201) dispatch('getMedicals');
    } catch (error) {
      console.log('Não foi possível atualizar os dados na API!', error);
    }
  },
};

const state = {
  medicals: [],
  medical: {},
};

export default {
  namespaced: true,
  getters,
  mutations,
  actions,
  state,
};
