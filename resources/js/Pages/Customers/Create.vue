<template>
  <app-layout title="Registrar Cliente">
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Registrar Cliente
        </h2>

        <nav-link :href="route('customers.index')">Regresar</nav-link>
      </div>
    </template>

    <div class="mt-10 mx-10">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <!-- INFORMACIÓN -->
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del cliente</h3>
            <p class="mt-1 text-sm text-gray-600">
              Escriba aquí la información personal y de contacto del cliente. Recuerde que solo el nombre del cliente es requerido y que en caso de suminsitrar numero de cedula y telefono debe asegurarse que estos sean unicos entre todos los cliente.
            </p>
          </div>
        </div>
        <!-- FORMULARIO -->
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form @submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
              <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <!-- FIRST NAME -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="first-name" required>Nombres</custom-label>
                    <custom-input name="first-name" id="first-name" type="text" v-model="form.first_name" :hasError="form.errors.first_name ? true : false"></custom-input>
                    <jet-input-error :message="form.errors.first_name" />
                  </div>

                  <!-- LAST NAME -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="last-name">Apellidos</custom-label>
                    <custom-input name="last-name" id="last-name" type="text" v-model="form.last_name" :hasError="form.errors.last_name ? true : false"></custom-input>
                    <jet-input-error :message="form.errors.last_name" />
                  </div>

                  <!-- NIT -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="nit">Cedula de Ciudadanía</custom-label>
                    <custom-input name="nit" id="nit" type="text" v-model="form.nit" :hasError="form.errors.nit ? true : false"></custom-input>
                    <jet-input-error :message="form.errors.nit" />
                  </div>
                  
                  <!-- PHONE -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="phone">Telefono</custom-label>
                    <custom-input name="phone" id="phone" type="tel" v-model="form.phone" :hasError="form.errors.phone ? true : false"></custom-input>
                    <jet-input-error :message="form.errors.phone" />
                  </div>
                  
                  <!-- ADDRESS -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="address">Dirección</custom-label>
                    <custom-input name="address" id="address" type="text" v-model="form.address" :hasError="form.errors.address ? true : false"></custom-input>
                    <jet-input-error :message="form.errors.address" />
                  </div>

                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <jet-button :disabled="form.processing">Registrar</jet-button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import CustomLabel from "@/Form/Label.vue";
import CustomInput from "@/Form/Input.vue";
import NavLink from "@/Jetstream/NavLink.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInputError from "@/Jetstream/InputError";

export default {
  components: {
    AppLayout,
    NavLink,
    CustomLabel,
    CustomInput,
    JetButton,
    JetInputError
  },
  data() {
    return {
      form: new useForm({
        first_name: null,
        last_name: null,
        nit: null,
        phone: null,
        address: null,
      })
    }
  },
  methods: {
    submit(){
      let url = this.route('customers.store');
      this.form.post(url, {
        onSuccess: () => {
          let success = this.$page.props.flash.success;
          if (success) {
            toastr.success(success.message, success.title);
          }
        }
      })
    }
  },
};
</script>