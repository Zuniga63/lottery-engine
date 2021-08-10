<template>
  <app-layout title="Boletos">
    <!-- HEADER -->
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Informacion del Boleto
        </h2>

        <nav-link :href="route('tickets.index')">Regresar a Index</nav-link>
      </div>
    </template>

    <div class="container mx-auto my-6">
      <div class="grid grid-cols-4 gap-4">
        <!-- Información del Boleto -->
        <div class="w-full text-sm">
          <div class="p-3 border border-gray-400 rounded bg-white shadow">
            <!-- Cliente -->
            <p class="mb-1">
              Cliente: <span class="font-bold">{{ customer.name }}</span>
            </p>
            <!-- Vendedor -->
            <p class="mb-1">
              Vendedor: <span class="font-bold">{{ seller.name }}</span>
            </p>
            <!-- Numeros -->
            <p class="mb-1">
              Numeros:
              <span class="font-bold">
                {{ ticket.firstOption }} - {{ ticket.secondOption }}
              </span>
            </p>
            <!-- Abonos -->
            <p class="mb-1">
              Abonos:
              <span class="font-bold mr-2">
                {{ paymentAmount }}
              </span>
              <span
                class="text-sm text-gray-600 text-opacity-50"
                v-if="ticket.paymentDate"
                >Pagado {{ ticket.paymentDate.fromNow() }}</span
              >
            </p>
          </div>
        </div>

        <!-- Abonos -->
        <div class="col-span-2">
          <div class="min-w-full">
            <div
              class="
                shadow
                overflow-auto
                border-b border-gray-200
                sm:rounded-lg
              "
            >
              <table class="min-w-full divide-y divide-gray-200 table-auto">
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
                          item.createdAt.format("dddd DD-MM-YYYY hh:mm:ss a")
                        }}</span>
                        <span class="text-gray-400 text-opacity-50">{{
                          item.createdAt.fromNow()
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

        <!-- Formulario -->
        <div class="w-full">
          <form
            class="border border-gray-300 rounded overflow-hidden"
            @submit.prevent="submit"
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
              <jet-button :disabled="form.processing || ticket.paymentDate"
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
import NavLink from "@/Jetstream/NavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import CustomLabel from "@/Form/Label.vue";
import CustomInput from "@/Form/Input.vue";
import JetInputError from "@/Jetstream/InputError";
import JetButton from "@/Jetstream/Button.vue";
import formatCurrency from "@/Utilities/FormatCurrency.js";
import { useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import dayjs from "dayjs";

var relativeTime = require("dayjs/plugin/relativeTime");
dayjs.extend(relativeTime);
require("dayjs/locale/es-do");
dayjs.locale("es-do");

export default {
  props: ["data"],
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
      seller: {},
      customer: {},
      ticket: {},
      payments: [],
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
        lottery_ticket_id: this.data.ticket.id,
        customer_id: this.data.customer.id,
        seller_id: this.data.seller.id,
        amount: null,
      }),
    };
  },
  beforeMount() {
    this.loadData();
  },
  methods: {
    formatCurrency,
    submit() {
      let url = this.route("tickets.payment");
      this.form.post(url, {
        preserveScroll: true,
        onSuccess: () => {
          let success = this.$page.props.flash.success;
          let error = this.$page.props.flash.error;
          let title, message, icon;
          let showAlert = false;
          this.form.reset("amount");
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

          this.loadData();
        },
      });
    },
    loadData() {
      this.seller.id = this.data.seller.id;
      this.seller.name =
        `${this.data.seller.first_name} ${this.data.seller.last_name}`.trim();

      this.customer.id = this.data.customer.id;
      this.customer.name =
        `${this.data.customer.first_name} ${this.data.customer.last_name}`.trim();

      this.ticket.id = this.data.ticket.id;
      this.ticket.firstOption = this.data.ticket.first_option;
      this.ticket.secondOption = this.data.ticket.second_option;
      this.ticket.paymentDate = this.data.ticket.payment_date
        ? dayjs(this.data.ticket.payment_date)
        : null;
      this.ticket.createdAt = dayjs(this.data.ticket.created_at);

      let totalPayment = 0;

      this.payments = [];
      this.data.payments.forEach((item) => {
        let amount = parseFloat(item.amount);
        totalPayment += amount;
        this.payments.push({
          id: item.id,
          amount: parseFloat(item.amount),
          accumulated: totalPayment,
          createdAt: dayjs(item.created_at),
          updatedAt: dayjs(item.updated_at),
        });
      });
    },
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
                  title: '¡Abono Eliminado!',
                  icon: "success",
                });
                this.loadData();
              }
            },
          });
        }
      });
    },
  },
  computed: {
    paymentAmount() {
      let amount = this.payments.reduce(
        (amount, item) => amount + item.amount,
        0
      );
      return formatCurrency(amount);
    },
  },
};
</script>