<template>
  <app-layout title="Boletos">
    <!-- HEADER -->
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Boletos
        </h2>

        <nav-link :href="route('tickets.create')">Registrar Boleto</nav-link>
      </div>
    </template>

    <div class="container mx-auto">
      <div class="mt-2">
        <input
          class="inline-block rounded w-80"
          type="text"
          placeholder="Escribe el numero del boleto"
          v-model="search"
        />
      </div>
      <div class="my-2 overflow-x-auto">
        <div class="py-2 min-w-full">
          <div
            class="shadow overflow-auto border-b border-gray-200 sm:rounded-lg"
          >
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-200">
                <tr>
                  <th class="text-left" :class="thClass">Cliente</th>
                  <th class="text-center" :class="thClass">Numeros</th>
                  <th class="text-left" :class="thClass">Vendedor</th>
                  <th class="text-left" :class="thClass">Recaudado</th>
                  <!-- Actions -->
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200">
                <tr
                  v-for="(item, index) in tickets"
                  :key="item.id"
                  :class="{ 'bg-gray-50': index % 2 == 0 }"
                  class="hover:bg-gray-200"
                >
                  <!-- CLIENTE -->
                  <th class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 text-left">
                      {{ item.customer.first_name }}
                      {{ item.customer.last_name }}
                    </div>
                  </th>
                  <!-- NUMEROS -->
                  <th class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                      {{ item.first_option }} - {{ item.second_option }}
                    </div>
                  </th>
                  <!-- VENDEDOR -->
                  <th class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 text-left">
                      {{ item.seller.first_name }} {{ item.seller.last_name }}
                    </div>
                  </th>
                  <!-- PAYMENTS -->
                  <th class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 text-right">
                      {{ formatCurrency(item.payments) }}
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
                      <!-- Mostrar Cliente -->
                      <Link
                        :href="route('tickets.show', item.id)"
                        class="mr-2 text-green-600 hover:text-opacity-50"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"
                          />
                        </svg>
                      </Link>
                      <!-- Eliminar Cliente -->
                      <a
                        href="javascript:;"
                        class="mr-2 text-red-500 hover:text-opacity-50"
                        @click="destroy(item.id)"
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
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Jetstream/NavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import formatCurrency from "@/Utilities/FormatCurrency.js";
import Swal from "sweetalert2";

export default {
  props: {
    allTickets: Array
  },
  components: {
    AppLayout,
    NavLink,
    Link,
  },
  data() {
    return {
      thClass: [
        "px-6",
        "py-3",
        "text-xs",
        "font-medium",
        "text-gray-500",
        "uppercase",
        "tracking-wider",
      ],
      search: null,
    };
  },
  methods: {
    formatCurrency,
    destroy(ticketId) {
      Swal.fire({
        title: "¿Seguro que quiere eliminar este boleto?",
        text: "Esta acción es irreversible",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Si, ¡Eliminalo!",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          let url = this.route("tickets.destroy", ticketId);
          this.$inertia.delete(url, {
            preserveScroll: true,
            preserveState: true,
            only: ["allTickets", "flash"],
            onSuccess: () => {
              console.log(this.$page.props.flash);
              let success = this.$page.props.flash.success;
              let error = this.$page.props.flash.error;

              if (success) {
                Swal.fire({
                  title: success.title,
                  text: success.message,
                  icon: "success",
                });
              } else if (error) {
                Swal.fire({
                  title: error.title,
                  text: error.message,
                  icon: "error",
                });
              }
            },
          });
        }
      });
    },
  },
  computed: {
    tickets() {
      if (this.search && !_.isEmpty(this.search)) {
        return this.allTickets.filter(item => {
          return item.first_option.includes(this.search) || item.second_option.includes(this.search);
        })
      }

      return this.allTickets;
    },
  },
};
</script>