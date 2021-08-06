<template>
  <app-layout title="Vendedores">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Vendedores
      </h2>
    </template>

    <div class="grid grid-cols-8 px-4">
      <div class="relative col-span-2 lg:none" ></div>

      <div class="col-span-8 lg:col-span-8">
        <!--  Tabla de Usuarios -->
        <div class="flex flex-col">
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
                  <thead class="bg-gray-50">
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
                        Nombres
                      </th>
                      <!-- Apellidos -->
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
                        Apellidos
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
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="seller in sellers" :key="seller.id">
                      <!-- NOMBRES -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ seller.firstName }}
                        </div>
                      </td>
                      <!-- APELLIDOS -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ seller.lastName }}
                        </div>
                      </td>
                      <!-- boletos -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-center">
                          {{ seller.tickets }}
                        </div>
                      </td>
                      <!-- importe -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(seller.amount) }}
                        </div>
                      </td>
                      <!-- RECAUDO -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(seller.collect) }}
                        </div>
                      </td>

                      <td
                        class="
                          px-6
                          py-4
                          whitespace-nowrap
                          text-right text-sm
                          font-medium
                        "
                      ></td>
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

export default {
  props: ["allSellers"],
  components: {
    AppLayout,
  },
  data() {
    return {
      sellers: [],
    };
  },
  beforeMount() {
    this.allSellers.forEach((seller) => {
      this.sellers.push({
        id: seller.id,
        firstName: seller.first_name,
        lastName: seller.last_name,
        tickets: seller.tickets_count,
        amount: seller.tickets_count * 5e4,
        collect: seller.payments_sum_amount ? seller.payments_sum_amount : 0,
      });
    });
  },
  methods: {
    formatCurrency,
  },
};
</script>