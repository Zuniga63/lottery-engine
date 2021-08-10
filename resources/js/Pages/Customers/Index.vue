<template>
  <app-layout title="Clientes">
    <!-- HEADER -->
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Clientes
        </h2>

        <nav-link :href="route('customers.create')" :only="['customers']"
          >Registrar Cliente</nav-link
        >
      </div>
    </template>

    <div class="grid grid-cols-8 px-4">
      <div class="relative col-span-2 lg:none"></div>

      <div class="col-span-8 lg:col-span-8">
        <!--  Tabla de Clientes -->
        <div class="flex flex-col">
          <div class="mt-2 mx-8">
            <input
              class="inline-block rounded w-96"
              type="text"
              placeholder="Nombre del cliente a buscar"
              v-model.trim="search"
            />
          </div>
          <!-- Level 1 -->
          <div class="my-2 overflow-x-auto">
            <!-- Level 2 -->
            <div
              class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
              <!-- Level 3 -->
              <div
                class="
                  shadow
                  overflow-hidden
                  border-b border-gray-200
                  sm:rounded-lg
                "
              >
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-20">
                    <tr>
                      <!-- Nombres -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Cliente
                      </th>
                      <!-- NIT -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        CC
                      </th>
                      <!-- Telefono -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Telefono
                      </th>
                      <!-- Dirección -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Dirección
                      </th>
                      <!-- Boletos -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-center text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Boletos
                      </th>
                      <!-- Importe -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-center text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Importe
                      </th>
                      <!-- Recaudo -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-center text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Recaudo
                      </th>
                      <!-- Actions -->
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="(item, index) in customers"
                      :key="item.id"
                      :class="{ 'bg-gray-50': index % 2 == 0 }"
                      class="hover:bg-gray-200"
                    >
                      <!-- NOMBRES -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ item.first_name }} {{ item.last_name }}
                        </div>
                      </td>
                      <!-- NIT -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ item.nit }}
                        </div>
                      </td>
                      <!-- Telefono -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ item.phone }}
                        </div>
                      </td>
                      <!-- Dirección -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ item.address }}
                        </div>
                      </td>
                      <!-- boletos -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-center">
                          {{ item.tickets }}
                        </div>
                      </td>
                      <!-- importe -->
                      <td
                        class="px-6 py-4 whitespace-nowrap"
                        :title="`Boletos: ${item.tickets}`"
                      >
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(item.tickets * 5e4) }}
                        </div>
                      </td>
                      <!-- RECAUDO -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{
                            item.paymentAmount
                              ? formatCurrency(parseFloat(item.paymentAmount))
                              : null
                          }}
                        </div>
                      </td>

                      <td
                        class="
                          px-2
                          py-4
                          whitespace-nowrap
                          text-right text-sm
                          font-medium
                        "
                      >
                        <div class="flex">
                          <!-- Mostrar Cliente -->
                          <Link
                            :href="route('customers.show', item.id)"
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
                          <!-- Editar Cliente -->
                          <Link
                            :href="route('customers.edit', item.id)"
                            class="mr-2 text-blue-600 hover:text-opacity-50"
                            preserve-state
                            preserve-scroll
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-5 w-5"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                              />
                              <path
                                fill-rule="evenodd"
                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                clip-rule="evenodd"
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
                <!-- /.end table -->
              </div>
              <!-- /.end level 3 -->
            </div>
            <!-- /.end level 2 -->
          </div>
          <!-- /.end level 1 -->
        </div>
        <!-- /.end user table -->
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import formatCurrency from "@/Utilities/FormatCurrency.js";
import { Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Jetstream/NavLink.vue";

export default {
  props: {
    allCustomers: Array
  },
  components: {
    AppLayout,
    NavLink,
    Link,
  },
  data() {
    return {
      search: null,
    };
  },
  methods: {
    formatCurrency,
    registerCustomer() {
      let url = this.route("customers.create");
      this.$inertia.get(url, null, {
        preserveScroll: true,
      });
    },
    destroy(customerId) {
      let url = this.route("customers.destroy", customerId);
      this.$inertia.delete(url, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
          let success = this.$page.props.flash.success;
          let error = this.$page.props.flash.error;

          if (success) {
            toastr.success(success.message, success.title);
          } else if (error) {
            toastr.error(error.message, error.title);
          }
        },
      });
    },
    normalizeText(text) {
      text = text.normalize("NFD");
      text = text.replace(
        /([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,
        "$1"
      );
      text = text.normalize();
      return text;
    },
  },
  computed: {
    customers() {
      if (this.search && !_.isEmpty(this.search)) {
        let text = this.normalizeText(this.search.toUpperCase());
        let result = this.allCustomers.filter(item => {
          let name = `${item.first_name} ${item.last_name}`.trim();
          name = this.normalizeText(name.toUpperCase());

          return name.includes(text);
        })

        return result;
      }
      return this.allCustomers;
    },
  },
};
</script>