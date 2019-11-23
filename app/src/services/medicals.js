import Axios from './axios';

export default {
  getMedicals: () => Axios().get('/medicals'),
  getMedical: id => Axios().get(`medical/${id}/edit`),
};
