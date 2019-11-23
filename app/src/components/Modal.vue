<template>
  <b-modal id="modal-1" title="Input data">
    <b-form>
      <b-form-group
        id="input-group-1"
        label="Medical:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          required
          placeholder="Enter Medical Name"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-2"
        label="CRM:"
        label-for="input-2"
      >
        <b-form-input
          id="input-2"
          type="number"
          required
          placeholder="Enter CRM"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-3"
        label="Phone:"
        label-for="input-3"
      >
        <b-form-input
          id="input-3"
          required
          placeholder="Enter Phone"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-4"
        label="Specialties:"
        label-for="input-4"
      >
        <b-form-select
          id="input-4"
          v-model="selected"
          :options="options"
          :select-size="4"
          multiple
        ></b-form-select>
        <div class="mt-3">
          Specialties Selected: <strong>{{ selected }}</strong>
        </div>
      </b-form-group>
    </b-form>
    <template v-slot:modal-footer="{ cancel, save }">
      <b-button size="sm" variant="danger" @click="cancel()">
        Cancel
      </b-button>
      <b-button size="sm" variant="success" @click="save()">
        Save
      </b-button>
    </template>
  </b-modal>
</template>

<script>
export default {
  name: 'Modal',
  data() {
    return {
      selected: [],
      options: [
        { value: 'a', text: 'This is First option' },
        { value: 'b', text: 'Default Selected Option' },
        { value: 'c', text: 'This is another option' },
        { value: 'd', text: 'This one is disabled', disabled: true },
        { value: 'e', text: 'This is option e' },
        { value: 'f', text: 'This is option f' },
        { value: 'g', text: 'This is option g' },
      ],
    };
  },
};
</script>
