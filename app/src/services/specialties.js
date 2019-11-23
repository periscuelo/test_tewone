import Axios from './axios';

export default {
  getSpecialties: () => Axios().get('/specialties'),
};
