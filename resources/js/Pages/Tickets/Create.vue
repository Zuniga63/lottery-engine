<template>
  <app-layout title="Registrar Boleto">
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Registrar Boleto
        </h2>

        <nav-link :href="route('tickets.index')">Regresar</nav-link>
      </div>
    </template>

    <div class="mt-10 mx-10">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <!-- INFORMACIÓN -->
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Formulario de Registro
            </h3>
            <p class="mt-1 text-sm text-gray-600">
              En esta sección se registran las boletas, tenga en cuenta que la
              dupla de numeros debe ser unica por lo que no le permitirá
              registrar boletos repetidos y para todos los boletos es necesario
              especificar el vendedor y el cliente. Si el cliente paga la boleta
              inmediatamente puede acceder posteriormente al boleto y resgistrar
              un pago o un abono.
            </p>
          </div>
        </div>
        <!-- FORMULARIO -->
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form @submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
              <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <!-- CUSTOMER -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="customer" required>Cliente</custom-label>
                    <custom-select
                      name="customer"
                      id="customer"
                      v-model="form.customer_id"
                      :hasError="form.errors.customer_id ? true : false"
                    >
                      <option value="" disabled>Selecciona un cliente</option>
                      <option
                        v-for="customer in customers"
                        :value="customer.id"
                        :key="customer.id"
                      >
                        {{ customer.first_name }} {{ customer.last_name }}
                      </option>
                    </custom-select>
                    <jet-input-error :message="form.errors.customer_id" />
                  </div>
                  <!-- CUSTOMER -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="seller" required>Vendedor</custom-label>
                    <custom-select
                      name="seller"
                      id="seller"
                      v-model="form.seller_id"
                      :hasError="form.errors.seller_id ? true : false"
                    >
                      <option value="" disabled>Selecciona un vendedor</option>
                      <option
                        v-for="seller in sellers"
                        :value="seller.id"
                        :key="seller.id"
                      >
                        {{ seller.first_name }} {{ seller.last_name }}
                      </option>
                    </custom-select>
                    <jet-input-error :message="form.errors.seller_id" />
                  </div>

                  <!-- LAST NAME -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="first-option"
                      >Primera Opción</custom-label
                    >
                    <custom-input
                      name="first-option"
                      id="first-option"
                      type="text"
                      v-model="form.first_option"
                      :hasError="form.errors.first_option ? true : false"
                    ></custom-input>
                    <jet-input-error :message="form.errors.first_option" />
                  </div>

                  <!-- NIT -->
                  <div class="col-span-6 sm:col-span-3">
                    <custom-label for="second-option"
                      >Segunda Opción</custom-label
                    >
                    <custom-input
                      name="second-option"
                      id="second-option"
                      type="text"
                      v-model="form.second_option"
                      :hasError="form.errors.second_option ? true : false"
                    ></custom-input>
                    <jet-input-error :message="form.errors.second_option" />
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
import CustomSelect from "@/Form/Select.vue";
import NavLink from "@/Jetstream/NavLink.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInputError from "@/Jetstream/InputError";

export default {
  props: ["customers", "sellers"],
  components: {
    AppLayout,
    NavLink,
    CustomLabel,
    CustomInput,
    CustomSelect,
    JetButton,
    JetInputError,
  },
  data() {
    return {
      form: new useForm({
        customer_id: null,
        seller_id: null,
        first_option: null,
        second_option: null,
      }),
    };
  },
  methods: {
    submit() {
      let url = this.route("tickets.store");
      this.form.post(url, {
        onSuccess: () => {
          toastr.success("Boleto Registrado Correctamente");
        },
      });
    },
  },
};
</script>