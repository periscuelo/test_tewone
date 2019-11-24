<template>
  <b-modal id="modal-1" title="Input data" @cancel="cancel" @ok="save">
    <b-form>
      <b-form-group
        id="input-group-1"
        label="Medical:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="$v.name.$model"
          required
          placeholder="Enter Medical Name"
          :state="$v.name.$dirty ? !$v.name.$error : null"
        ></b-form-input>

        <b-form-invalid-feedback id="input-1-live-feedback">
          This is a required field and don't must be more than 150 characters.
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        id="input-group-2"
        label="CRM:"
        label-for="input-2"
      >
        <b-form-input
          id="input-2"
          v-model="$v.crm.$model"
          v-mask="'######'"
          required
          placeholder="Enter CRM"
          :state="$v.crm.$dirty ? !$v.crm.$error : null"
        ></b-form-input>

        <b-form-invalid-feedback id="input-2-live-feedback">
          This is a required field.
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        id="input-group-3"
        label="Phone:"
        label-for="input-3"
      >
        <b-form-input
          id="input-3"
          v-model="$v.phone.$model"
          v-mask="['(##) ####-####', '(##) #####-####']"
          required
          placeholder="Enter Phone"
          :state="$v.phone.$dirty ? !$v.phone.$error : null"
        ></b-form-input>

        <b-form-invalid-feedback id="input-3-live-feedback">
          This is a required field and must be at least 14 characters.
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        id="input-group-4"
        label="Specialties:"
        label-for="input-4"
      >
        <b-form-select
          id="input-4"
          v-model="$v.medicals_specialties.$model"
          :options="optsSpecialty"
          :select-size="4"
          :state="$v.medicals_specialties.$dirty ? !$v.medicals_specialties.$error : null"
          multiple
        ></b-form-select>
        <div class="mt-3">
          Specialties Selected: <strong>{{ medicals_specialties }}</strong>
        </div>

        <b-form-invalid-feedback id="input-4-live-feedback">
          This is a required field and must be at least 2 options selected
        </b-form-invalid-feedback>
      </b-form-group>
    </b-form>
    <template v-slot:modal-footer="{ cancel, ok }">
      <b-button size="sm" variant="danger" @click="cancel()">
        Cancel
      </b-button>
      <b-button size="sm" variant="success" :disabled="$v.$invalid" @click="ok()">
        Save
      </b-button>
    </template>
  </b-modal>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { validationMixin } from 'vuelidate';
import { required, minLength, maxLength } from 'vuelidate/lib/validators';

export default {
  name: 'Modal',
  mixins: [validationMixin],
  data() {
    return {
      name: '',
      crm: '',
      phone: '',
      medicals_specialties: [],
    };
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(150),
    },
    crm: {
      required,
    },
    phone: {
      required,
      minLength: minLength(14),
    },
    medicals_specialties: {
      required,
      minLength: minLength(2),
    },
  },
  computed: {
    ...mapGetters('Medicals', ['medical']),
    ...mapGetters('Specialties', ['optsSpecialty']),
  },
  watch: {
    medical(value) {
      if (value.id !== undefined) Object.assign(this.$data, value);
    },
  },
  created() {
    this.$v.$touch();
    this.getSpecialties();
  },
  methods: {
    ...mapActions('Specialties', ['getSpecialties']),
    ...mapActions('Medicals', ['setMedical', 'updateMedical']),
    cancel() {
      Object.assign(this.$data, this.$options.data.apply(this));
    },
    save() {
      if (!this.$v.$anyError) {
        const saveData = Object.assign({}, this.$data);
        saveData.phone = saveData.phone.replace(/[^0-9]/g, '');
        if (saveData.id !== undefined) {
          this.updateMedical(saveData);
        } else {
          this.setMedical(saveData);
        }
        Object.assign(this.$data, this.$options.data.apply(this));
      }
    },
  },
};
</script>
