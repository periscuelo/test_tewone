import axios from 'axios';

export default () => axios.create({
  baseURL: 'http://localhost',
  withCredentials: true,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});
