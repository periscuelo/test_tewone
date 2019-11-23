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
        <p>
          <label for="search">Search:</label>
          <b-form-input
            id="search"
            placeholder="Enter Search"
          >
          </b-form-input>
        </p>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table
          id="my-table"
          :items="items"
          :per-page="perPage"
          :current-page="currentPage"
          responsive
          small
        >
          <template v-slot:cell(actions)="data">
            <b-button
              variant="outline-primary"
              class="mr-1"
              v-b-modal.modal-1
            >
              Edit
            </b-button>
            <b-button variant="outline-danger">Delete</b-button>
          </template>
        </b-table>
      </b-col>
    </b-row>
    <Modal/>
  </b-container>
</template>

<script>
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
      items: [
        {
          medical: 'Fred', crm: 'Flintstone', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Wilma', crm: 'Flintstone', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Barney', crm: 'Rubble', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Betty', crm: 'Rubble', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Pebbles', crm: 'Flintstone', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Bamm Bamm', crm: 'Rubble', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'The Great', crm: 'Gazzoo', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Rockhead', crm: 'Slate', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
        {
          medical: 'Pearl', crm: 'Slaghoople', phone: 'Flintstone', specialties: 'Flintstone', actions: '',
        },
      ],
    };
  },
  computed: {
    rows() {
      return this.items.length;
    },
  },
};
</script>
