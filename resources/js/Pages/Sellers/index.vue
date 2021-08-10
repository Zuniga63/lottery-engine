<template>
  <app-layout title="Vendedores">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Vendedores
      </h2>
    </template>

    <div class="grid grid-cols-8 px-4">
      <div class="relative col-span-2 lg:none"></div>

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
                        Vendidos
                      </th>
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
                        Pagados
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
                        Recaudado
                      </th>
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
                        Saldo
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="seller in sellers" :key="seller.id">
                      <!-- NOMBRES -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ seller.firstName }} {{ seller.lastName }}
                        </div>
                      </td>
                      <!-- boletos -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-center">
                          {{ seller.tickets }}
                        </div>
                      </td>
                      <!-- Pagados -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-center">
                          {{ seller.ticketsPay }}
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
                          <span class="ml-2 text-xs text-gray-400"
                            >{{ seller.collectPercentage }}%</span
                          >
                        </div>
                      </td>

                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(seller.balance) }}
                        </div>
                      </td>
                    </tr>
                    <!-- RESUME -->
                    <tr class="bg-gray-100">
                      <!-- NOMBRES -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Total</div>
                      </td>
                      <!-- boletos -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-center">
                          {{ totalTickets }}
                        </div>
                      </td>
                      <!-- Pagados -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-center">
                          {{ totalTicketsPay }}
                        </div>
                      </td>
                      <!-- importe -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(totalAmount) }}
                        </div>
                      </td>
                      <!-- RECAUDO -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(totalCollect) }}
                          <span class="ml-2 text-xs text-gray-400"
                            >{{ totalCollectPercentage }}%</span
                          >
                        </div>
                      </td>

                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-right">
                          {{ formatCurrency(totalBalance) }}
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

export default {
  props: ["allSellers"],
  components: {
    AppLayout,
  },
  data() {
    return {
      sellers: [],
      totalTickets: 0,
      totalTicketsPay: 0,
      totalAmount: 0,
      totalCollect: 0,
      totalCollectPercentage: 0,
      totalBalance: 0,
    };
  },
  beforeMount() {
    this.allSellers.forEach((seller) => {
      let amount = seller.tickets_count * 5e4;
      let collect = seller.payments_sum_amount ? parseFloat(seller.payments_sum_amount) : 0;
      let balance = amount - collect;
      let collectPercentage = amount ? _.round((collect / amount) * 100, 2) : 0;
      this.sellers.push({
        id: seller.id,
        firstName: seller.first_name,
        lastName: seller.last_name,
        tickets: seller.tickets_count,
        ticketsPay: seller.tickets_pay,
        amount,
        collect,
        collectPercentage,
        balance,
      });

      this.totalTickets += seller.tickets_count;
      this.totalTicketsPay += seller.tickets_pay;
      this.totalAmount += amount;
      this.totalCollect += collect;
      this.totalBalance += balance;
    });

    this.totalCollectPercentage = this.totalAmount
      ? _.round((this.totalCollect / this.totalAmount) * 100, 2)
      : 0;
  },
  methods: {
    formatCurrency,
  },
};
</script>