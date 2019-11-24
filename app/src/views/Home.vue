<template>
  <b-container>
    <b-row>
      <b-col>
        <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          aria-controls="my-table"
        ></b-pagination>
        <label for="perPage">Registers per Page:</label>
        <b-form-input
          id="perPage"
          type="number"
          v-model="perPage"
        >
        </b-form-input> Current Page: {{ currentPage }}
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-button
          variant="outline-success"
          class="my-3"
          v-b-modal.modal-1
        >
          Register
        </b-button>
        <b-alert
          :show="dismissCountDown"
          dismissible
          fade
          variant="danger"
          @dismiss-count-down="countDownChanged"
        >
          {{ error.replace(/\d/g,'') }}
        </b-alert>
        <p>
          <label for="search">Search:</label>
          <b-form-input
            id="search"
            v-model="search"
            placeholder="Enter Search"
            debounce="1000"
          >
          </b-form-input>
        </p>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table
          id="my-table"
          :items="gridMedical"
          :fields="fields"
          :per-page="perPage"
          :current-page="currentPage"
          responsive
          small
        >
          <template v-slot:cell(actions)="data">
            <b-button
              variant="outline-primary"
              class="mr-1"
              @click="edit(data.item.id)"
            >
              Edit
            </b-button>
            <b-button
              variant="outline-danger"
              @click="remove(data.item.id)"
            >
              Delete
            </b-button>
          </template>
        </b-table>
      </b-col>
    </b-row>
    <Modal/>
  </b-container>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import Modal from '@/components/Modal.vue';

export default {
  name: 'home',
  components: {
    Modal,
  },
  data() {
    return {
      perPage: 3,
      currentPage: 1,
      fields: [
        { key: 'id', label: '#' },
        { key: 'name', label: 'Medical' },
        { key: 'crm', label: 'CRM' },
        { key: 'phone' },
        { key: 'specialties' },
        { key: 'actions' },
      ],
      search: '',
      dismissSecs: 5,
      dismissCountDown: 0,
    };
  },
  computed: {
    ...mapState('Medicals', ['error']),
    ...mapGetters('Medicals', ['gridMedical']),
    rows() {
      return this.gridMedical.length;
    },
  },
  watch: {
    error(value) {
      if (value !== '') this.showAlert();
    },
    search(value) {
      if (value !== '') {
        this.searchMedical(value);
      } else {
        this.getMedicals();
      }
    },
  },
  created() {
    this.getMedicals();
  },
  methods: {
    ...mapActions('Medicals', ['getMedicals', 'getMedical', 'removeMedical', 'searchMedical']),
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    edit(id) {
      this.getMedical(id);
      this.$bvModal.show('modal-1');
    },
    remove(id) {
      // Sorry eslint, this is a test app and i need to be hurry :/
      /* eslint-disable */
      if (confirm('Do you really want to delete this record?')) this.removeMedical(id);
      /* eslint-enable */
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
  },
};
</script>
