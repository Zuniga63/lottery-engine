<template>
  <app-layout :title="customer.first_name">
    <!-- HEADER -->
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ customer.first_name }} {{ customer.last_name }}
        </h2>

        <nav-link :href="route('customers.index')"
          >Regresar a Clientes</nav-link
        >
      </div>
    </template>

    <div class="container py-2 mx-auto">
      <div class="grid gap-4 grid-cols-4">
        <!-- Boletos -->
        <div class="w-full">
          <div class="border border-gray-200 rounded overflow-hidden shadow">
            <header
              class="
                p-3
                border-b-2 border-blue-400
                text-ls
                font-bold
                bg-blue-200
                text-gray-700
              "
            >
              Boletos
            </header>
            <!-- Body -->
            <div class="p-2">
              <!-- Boleto -->
              <div
                class="
                  w-full
                  p-2
                  mb-2
                  bg-blue-100
                  text-gray-500
                  hover:text-gray-700
                  hover:bg-blue-400
                  cursor-pointer
                "
                :class="{
                  'bg-blue-400': ticket?.id === item.id,
                  'text-gray-700': ticket?.id === item.id,
                }"
                v-for="item in customer.tickets"
                :key="item.id"
                @click="ticket = item"
              >
                <p class="mb-1 text-lg text-center tracking-wider">
                  {{ item.first_option }} - {{ item.second_option }}
                </p>
                <p class="text-xs">
                  Abonos:
                  <span class="font-bold">{{
                    formatCurrency(item.payments_sum_amount)
                  }}</span>
                </p>
                <div class="flex justify-between">
                  <p class="text-xs">
                    Vendido:
                    <span class="font-bold">{{
                      dayjs(item.created_at).fromNow()
                    }}</span>
                  </p>
                  <p class="text-xs" v-if="item.payment_date">
                    Pagado:
                    <span class="font-bold">{{
                      dayjs(item.payment_date).fromNow()
                    }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Abonos -->
        <div class="col-span-2">
          <!-- Abonos -->
          <div class="col-span-2" v-if="ticket">
            <div class="min-w-full">
              <div
                class="
                  shadow
                  overflow-auto
                  border-b border-gray-200
                  sm:rounded-lg
                "
              >
                <table
                  class="min-w-full min-h-0 divide-y divide-gray-200 table-auto"
                >
                  <thead class="bg-gray-200">
                    <tr>
                      <th class="text-left" :class="thClass">#</th>
                      <th class="text-center" :class="thClass">Fecha</th>
                      <th class="text-left" :class="thClass">Importe</th>
                      <th class="text-left" :class="thClass">Acumulado</th>
                      <!-- Actions -->
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                      </th>
                    </tr>
                  </thead>

                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="(item, index) in payments"
                      :key="item.id"
                      :class="{ 'bg-gray-50': index % 2 == 0 }"
                      class="hover:bg-gray-200"
                    >
                      <!-- # -->
                      <th class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-left">
                          {{ index + 1 }}
                        </div>
                      </th>
                      <!-- Fecha -->
                      <th class="px-6 py-4 whitespace-nowrap">
                        <div
                          class="flex flex-col text-sm text-gray-900 text-left"
                        >
                          <span>{{
                            dayjs(item.created_at).format(
                              "dddd DD-MM-YYYY hh:mm:ss a"
                            )
                          }}</span>
                          <span class="text-gray-400 text-opacity-50">{{
                            dayjs(item.created_at).fromNow()
                          }}</span>
                        </div>
                      </th>
                      <!-- IMPORTE -->
                      <th class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-left">
                          {{ formatCurrency(item.amount) }}
                        </div>
                      </th>
                      <!-- ACUMULADO -->
                      <th class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(item.accumulated) }}
                        </div>
                      </th>
                      <td
                        class="
                          px-2
                          py-4
                          whitespace-nowrap
                          text-left text-sm
                          font-medium
                        "
                      >
                        <div class="flex justify-end">
                          <!-- Eliminar Cliente -->
                          <a
                            href="javascript:;"
                            class="mr-2 text-red-500 hover:text-opacity-50"
                            @click="destroyPayment(item.id)"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-5 w-5"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                              />
                            </svg>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Formulario -->
        <div class="w-full">
          <form
            class="border border-gray-300 rounded overflow-hidden"
            @submit.prevent="submit"
            v-if="ticket"
          >
            <header
              class="
                p-3
                text-lg text-gray-600
                font-bold
                tracking-wider
                bg-gray-200
              "
            >
              Registrar Abono
            </header>
            <!-- Body -->
            <div class="p-4">
              <div class="mb-2">
                <custom-label for="amount">Importe</custom-label>
                <custom-input
                  name="amount"
                  id="amount"
                  type="number"
                  v-model="form.amount"
                  :hasError="form.errors.amount ? true : false"
                ></custom-input>
                <jet-input-error :message="form.errors.amount" />
              </div>
              <jet-input-error :message="form.errors.lottery_ticket_id" />
              <jet-input-error :message="form.errors.customer_id" />
              <jet-input-error :message="form.errors.seller_id" />
            </div>

            <footer class="px-4 py-3 bg-gray-200 text-left sm:px-6">
              <jet-button :disabled="form.processing || ticket.payment_date"
                >Registrar</jet-button
              >
            </footer>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import formatCurrency from "@/Utilities/FormatCurrency.js";
import { Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Jetstream/NavLink.vue";
import dayjs from "dayjs";
import Swal from "sweetalert2";
// Componentes del formulario
import CustomLabel from "@/Form/Label.vue";
import CustomInput from "@/Form/Input.vue";
import JetInputError from "@/Jetstream/InputError";
import JetButton from "@/Jetstream/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";

var relativeTime = require("dayjs/plugin/relativeTime");
dayjs.extend(relativeTime);
require("dayjs/locale/es-do");
dayjs.locale("es-do");

export default {
  props: ["customer"],
  components: {
    AppLayout,
    NavLink,
    Link,
    CustomLabel,
    CustomInput,
    JetInputError,
    JetButton,
  },
  data() {
    return {
      ticket: null,
      thClass: [
        "px-6",
        "py-3",
        "text-xs",
        "font-medium",
        "text-gray-500",
        "uppercase",
        "tracking-wider",
      ],
      form: new useForm({
        lottery_ticket_id: null,
        customer_id: this.customer.id,
        seller_id: null,
        amount: null,
      }),
    };
  },
  methods: {
    formatCurrency,
    dayjs,
    destroyPayment(id) {
      Swal.fire({
        title: "¿Seguro que quiere eliminar este abono?",
        text: "Esta acción es irreversible",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Si, ¡Eliminalo!",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          let url = this.route("tickets.destroyPayment", id);
          this.$inertia.delete(url, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
              let success = this.$page.props.flash.success;

              if (success) {
                Swal.fire({
                  title: "¡Abono Eliminado!",
                  icon: "success",
                });
                //Se busca el ticket
                this.ticket = this.customer.tickets.find(
                  (item) => item.id === this.ticket.id
                );
              }
            },
          });
        }
      });
    },
    submit() {
      let url = this.route("tickets.payment");
      this.form.lottery_ticket_id = this.ticket.id;
      this.form.seller_id = this.ticket.seller_id;
      this.form.post(url, {
        preserveScroll: true,
        onSuccess: () => {
          let success = this.$page.props.flash.success;
          let error = this.$page.props.flash.error;
          let title, message, icon;
          let showAlert = false;
          this.form.reset();
          if (success) {
            title = success.title;
            message = success.message;
            icon = "success";
            showAlert = true;
          } else if (error) {
            title = error.title;
            message = error.message;
            icon = "error";
            showAlert = true;
          }

          if (showAlert) {
            Swal.fire({
              title,
              text: message,
              icon,
            });
          }

          //Se busca el ticket
          this.ticket = this.customer.tickets.find(
            (item) => item.id === this.ticket.id
          );
        },
      });
    },
  },
  computed: {
    payments() {
      let payments = [];
      if (this.ticket) {
        let accumulated = 0;
        this.ticket.payments.forEach((item) => {
          accumulated += parseFloat(item.amount);
          item.accumulated = accumulated;
          payments.push(item);
        });
      }

      return payments;
    },
  },
};
</script>