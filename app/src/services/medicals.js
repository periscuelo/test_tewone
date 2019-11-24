import Axios from './axios';

export default {
  deleteMedical: id => Axios().delete(`/medical/${id}`),
  getMedicals: () => Axios().get('/medicals'),
  getMedical: id => Axios().get(`/medical/${id}/edit`),
  searchMedical: data => Axios().get('/medicals/search', { params: { search: data } }),
  setMedical: data => Axios().post('/medical', data),
  updateMedical: data => Axios().put(`/medical/${data.id}`, data),
};
